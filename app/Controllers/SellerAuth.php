<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SellerModel;

class SellerAuth extends BaseController
{
    protected SellerModel $sellers;
    protected $layout = 'layouts/default';

    public function __construct()
    {
        $this->sellers = new SellerModel();
        $this->session = session();
    }

    public function register()
    {
        if ($this->session->get('seller_id')) {
            return redirect()->to('/seller/dashboard');
        }

        return $this->view('/');
    }

    
    
public function sendOtp()
{
    $rules = [
        'owner_name'       => 'required|min_length[2]|max_length[120]',
        'email'            => 'required|valid_email|max_length[190]',
        'phone'            => 'required|max_length[25]',
        'password'         => 'required|min_length[8]|max_length[72]',
        'confirm_password' => 'required|matches[password]',
    ];

    // Return validation errors as JSON for AJAX requests.
    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Please correct the following errors.',
            'errors'  => $this->validator->getErrors(),
        ]);
    }

    $email    = strtolower(trim((string) $this->request->getPost('email')));
    $name     = trim((string) $this->request->getPost('owner_name'));
    $phone    = trim((string) $this->request->getPost('phone'));
    $password = (string) $this->request->getPost('password');

    // Check whether seller already exists.
    if ($this->sellers->where('email', $email)->first()) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'An account with this email already exists.',
            'errors'  => [
                'email' => 'An account with this email already exists.',
            ],
        ]);
    }

    $db       = db_connect();
    $otpTable = $db->table('seller_email_otps');

    $existing = $otpTable->where('email', $email)->get()->getRowArray();

    // 60-second OTP request cooldown.
    if (
        $existing &&
        !empty($existing['created_at']) &&
        strtotime($existing['created_at']) > time() - 60
    ) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Please wait 60 seconds before requesting another OTP.',
            'errors'  => [
                'email' => 'Please wait 60 seconds before requesting another OTP.',
            ],
        ]);
    }

    // Generate a six-digit OTP.
    $otp = (string) random_int(100000, 999999);

    $pendingData = [
        'email'         => $email,
        'owner_name'    => $name,
        'phone'         => $phone,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'otp_hash'      => password_hash($otp, PASSWORD_DEFAULT),
        'expires_at'    => date('Y-m-d H:i:s', time() + 300),
        'attempts'      => 0,
        'created_at'    => date('Y-m-d H:i:s'),
    ];

    // Save or update the pending OTP.
    if ($existing) {
        $otpTable->where('email', $email)->update($pendingData);
    } else {
        $otpTable->insert($pendingData);
    }

    // Send verification email.
    
    if (!$this->sendEmailOtp(
        $email,
        $otp,
        'registration',
        'seller'
    )) {
        // Remove the pending OTP if email delivery fails.
        $otpTable->where('email', $email)->delete();

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Unable to send verification email. Please try again.',
            'errors'  => [
                'email' => 'Unable to send verification email. Please try again.',
            ],
        ]);
    }

    // Save the email in the session for OTP verification.
    $this->session->set('seller_pending_email', $email);

    // Return JSON so AJAX stays on the registration page.
    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'OTP sent successfully. Please check your email.',
    ]);

}

// public function verifyPage()
// {
//     if (!session()->get('seller_pending_email')) {
//         return redirect()->to(site_url('seller/register'));
//     }

//     return $this->view('seller/auth/verify_otp');
// }


    public function verifyOtp()
    {
        $email = $this->session->get('seller_pending_email');

        if (!$email) {
            return redirect()->to('/')
                ->with('errors', ['otp' => 'Please register again.']);
        }

        $otp = trim((string) $this->request->getPost('otp'));

        if (!preg_match('/^\d{6}$/', $otp)) {
            return redirect()->back()->with('errors', [
                'otp' => 'Enter a valid 6-digit OTP.',
            ]);
        }

        $db = db_connect();
        $otpTable = $db->table('seller_email_otps');

        $pending = $otpTable->where('email', $email)->get()->getRowArray();

        if (!$pending) {
            $this->session->remove('seller_pending_email');

            return redirect()->to('/')
                ->with('errors', ['otp' => 'Registration expired. Please register again.']);
        }

        if (strtotime($pending['expires_at']) < time()) {
            $otpTable->where('email', $email)->delete();
            $this->session->remove('seller_pending_email');

            return redirect()->to('/')
                ->with('errors', ['otp' => 'OTP expired. Please register again.']);
        }

        if ((int) $pending['attempts'] >= 5) {
            $otpTable->where('email', $email)->delete();
            $this->session->remove('seller_pending_email');

            return redirect()->to('/')
                ->with('errors', ['otp' => 'Too many attempts. Please register again.']);
        }

        if (!password_verify($otp, $pending['otp_hash'])) {
            $otpTable->where('email', $email)
                ->set('attempts', 'attempts + 1', false)
                ->update();

            return redirect()->back()->with('errors', [
                'otp' => 'Incorrect OTP. Please try again.',
            ]);
        }

        // Recheck the email before creating the seller.
        if ($this->sellers->where('email', $email)->first()) {
            $otpTable->where('email', $email)->delete();
            $this->session->remove('seller_pending_email');

            return redirect()->to('/seller/login')
                ->with('errors', ['email' => 'This email is already registered. Please log in.']);
        }

        $db->transBegin();

        try {
            $this->sellers->insert([
                'owner_name'    => $pending['owner_name'],
                'email'         => $pending['email'],
                'phone'         => $pending['phone'],
                'password_hash' => $pending['password_hash'],
                'status'        => 'pending',
            ]);

            $sellerId = $this->sellers->getInsertID();

            $otpTable->where('email', $email)->delete();

            if ($db->transStatus() === false || !$sellerId) {
                throw new \RuntimeException('Unable to create seller account.');
            }

            $db->transCommit();
            $this->session->remove('seller_pending_email');

            return redirect()->to('/')
                ->with('success', 'Email verified and registration successful. Your account is pending approval.');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', 'Seller registration failed: ' . $e->getMessage());

            return redirect()->back()->with('errors', [
                'otp' => 'Unable to complete registration. Please try again.',
            ]);
        }
    }

    public function resendOtp()
    {
        $email = session()->get('seller_pending_email');

        if (!$email) {
            return redirect()->to('/seller/register')
                ->with('errors', ['otp' => 'Please register again.']);
        }

        $db = db_connect();
        $otpTable = $db->table('seller_email_otps');

        $pending = $otpTable->where('email', $email)->get()->getRowArray();

        if (!$pending) {
            session()->remove('seller_pending_email');

            return redirect()->to('/seller/register')
                ->with('errors', ['otp' => 'Registration expired. Please register again.']);
        }

        if (strtotime($pending['created_at']) > time() - 60) {
            return redirect()->to('/seller/register/verify')
                ->with('errors', ['otp' => 'Please wait 60 seconds before resending.']);
        }

        $otp = (string) random_int(100000, 999999);

        $otpTable->where('email', $email)->update([
            'otp_hash'   => password_hash($otp, PASSWORD_DEFAULT),
            'expires_at' => date('Y-m-d H:i:s', time() + 300),
            'attempts'   => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $mail = service('email');
        $mail->clear(true);
        $mail->setFrom(env('email.fromEmail'), env('email.fromName', 'Ajobmart Seller'));
        $mail->setTo($email);
        $mail->setSubject('Your new Ajobmart verification OTP');
        $mail->setMailType('html');
        $mail->setMessage(
            '<p>Your new Ajobmart verification code is:</p>'
            . '<h2>' . esc($otp) . '</h2>'
            . '<p>This code expires in 5 minutes.</p>'
        );

        if (!$mail->send()) {
            log_message('error', 'Seller OTP resend failed: '
                . $mail->printDebugger(['headers']));

            return redirect()->to('/seller/register/verify')
                ->with('errors', ['otp' => 'Unable to resend OTP. Please try again.']);
        }

        return redirect()->to('/seller/register/verify')
            ->with('success', 'A new OTP has been sent to your email.');
    }

    

    public function authenticate()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        $seller = $this->sellers->where('email', $email)->first();

        if (! $seller || ! password_verify($password, $seller['password_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'login' => 'Invalid email or password.',
                ]);
        }

        session()->regenerate();

        session()->set([
            'seller_id'     => (int) $seller['id'],
            'seller_name'   => $seller['owner_name'],
            'seller_email'  => $seller['email'],
            'seller_status' => $seller['status'],
        ]);

        return redirect()->to('/seller/dashboard');
    }

    public function dashboard()
    {
        if (! session()->get('seller_id')) {
            return redirect()->to('/seller/login')
                ->with('errors', ['login' => 'Please log in to continue.']);
        }

        $seller = $this->sellers->find(session()->get('seller_id'));

        if (! $seller) {
            session()->destroy();

            return redirect()->to('/seller/login');
        }

        // Refresh the status from the database.
        session()->set('seller_status', $seller['status']);

        return view('seller/dashboard', [
            'seller' => $seller,
        ]);
    }

    public function logout()
    {
       $this->session->remove([
            'seller_id',
            'seller_name',
            'seller_email',
            'seller_status',
        ]);

        $this->session->regenerate(true);

        return redirect()->to('/seller/login')
            ->with('success', 'You have been logged out.');
    }
}