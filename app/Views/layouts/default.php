<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sell on Ajobmart – Seller Home</title>
<link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet"
    >
<style>
  :root{
    --brand:#4f46e5; --brand-dark:#3730a3; --accent:#f59e0b;
    --ink:#111827; --muted:#6b7280; --line:#e5e7eb; --bg:#ffffff; --soft:#f5f6ff;
    --radius:14px;
  }
  /* *{box-sizing:border-box;margin:0;padding:0} */
  /* body{font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:var(--ink);background:var(--bg);line-height:1.6}
  */
  a{color:inherit;text-decoration:none} 
  .wrap{max-width:1160px;margin:0 auto;padding:0 20px}
  .btn{display:inline-block;padding:12px 24px;border-radius:10px;font-weight:600;border:2px solid transparent;cursor:pointer;transition:.2s}
  .btn-primary{background:var(--brand);color:#fff}
  .btn-primary:hover{background:var(--brand-dark)}
  .btn-ghost{border-color:var(--brand);color:var(--brand);background:#fff}
  .btn-ghost:hover{background:var(--soft)}
  section{padding:72px 0}
  h2{font-size:32px;line-height:1.2;margin-bottom:12px}
  .sub{color:var(--muted);max-width:620px;margin-bottom:40px}
  .center{text-align:center}.center .sub{margin-inline:auto}

  /* Header */
  header{position:sticky;top:0;background:rgba(255,255,255,.95);backdrop-filter:blur(6px);border-bottom:1px solid var(--line);z-index:10}
  .nav{display:flex;align-items:center;justify-content:space-between;height:68px}
  .logo{font-weight:800;font-size:22px;color:var(--brand)}
  .logo span{color:var(--accent)}
  .menu{display:flex;gap:28px;font-weight:500;color:var(--muted)}
  .menu a:hover{color:var(--brand)}
  .nav-cta{display:flex;gap:10px;align-items:center}
  .nav-cta .btn{padding:9px 18px}

  /* Hero */
  .hero{background:linear-gradient(135deg,var(--soft),#fff 60%);padding:80px 0}
  .hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:center}
  .badge{display:inline-block;background:#e0e7ff;color:var(--brand-dark);padding:5px 14px;border-radius:99px;font-size:13px;font-weight:600;margin-bottom:18px}
  .hero h1{font-size:50px;line-height:1.1;margin-bottom:18px}
  .hero h1 em{font-style:normal;color:var(--brand)}
  .hero p{color:var(--muted);font-size:18px;margin-bottom:28px;max-width:520px}
  .hero-actions{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:22px}
  .hero-note{font-size:14px;color:var(--muted)}
  .hero-card{background:#fff;border:1px solid var(--line);border-radius:20px;padding:26px;box-shadow:0 20px 50px rgba(79,70,229,.12)}
  .hero-card h3{margin-bottom:16px}
  .field{margin-bottom:14px}
  .field label{display:block;font-size:13px;font-weight:600;margin-bottom:5px}
  .field input,.field select{width:100%;padding:11px 12px;border:1px solid var(--line);border-radius:9px;font-size:15px;font-family:inherit}
  .field input:focus,.field select:focus{outline:2px solid var(--brand);border-color:transparent}
  .hero-card .btn{width:100%;text-align:center}

  /* Stats */
  .stats{padding:0;margin-top:-1px}
  .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:36px 0;border-bottom:1px solid var(--line)}
  .stat{text-align:center}
  .stat b{display:block;font-size:30px;color:var(--brand)}
  .stat span{color:var(--muted);font-size:14px}

  /* Steps */
  .steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
  .step{border:1px solid var(--line);border-radius:var(--radius);padding:24px;background:#fff}
  .num{width:38px;height:38px;border-radius:50%;background:var(--brand);color:#fff;display:grid;place-items:center;font-weight:700;margin-bottom:14px}
  .step h3{font-size:18px;margin-bottom:6px}
  .step p{color:var(--muted);font-size:15px}

  /* Benefits */
  .benefits{background:var(--soft)}
  .ben-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
  .ben{background:#fff;border-radius:var(--radius);padding:26px;border:1px solid var(--line)}
  .ico{font-size:28px;margin-bottom:10px}
  .ben h3{font-size:18px;margin-bottom:6px}
  .ben p{color:var(--muted);font-size:15px}

  /* Categories */
  .cats{display:grid;grid-template-columns:repeat(6,1fr);gap:14px}
  .cat{border:1px solid var(--line);border-radius:var(--radius);padding:22px 10px;text-align:center;font-weight:600;transition:.2s}
  .cat:hover{border-color:var(--brand);transform:translateY(-3px);box-shadow:0 10px 24px rgba(79,70,229,.1)}
  .cat div{font-size:30px;margin-bottom:6px}

  /* Pricing */
  .price-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;align-items:stretch}
  .plan{border:1px solid var(--line);border-radius:var(--radius);padding:28px;background:#fff;display:flex;flex-direction:column}
  .plan.pop{border:2px solid var(--brand);box-shadow:0 16px 40px rgba(79,70,229,.15);position:relative}
  .plan.pop::before{content:"Most popular";position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:var(--brand);color:#fff;font-size:12px;font-weight:700;padding:3px 12px;border-radius:99px}
  .plan h3{margin-bottom:4px}
  .plan .amt{font-size:34px;font-weight:800;margin:10px 0}
  .plan .amt small{font-size:14px;color:var(--muted);font-weight:500}
  .plan ul{list-style:none;margin:14px 0 24px;flex:1}
  .plan li{padding:6px 0;color:var(--muted);font-size:15px}
  .plan li::before{content:"✓ ";color:var(--brand);font-weight:700}

  /* Testimonials */
  .tgrid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
  .quote{border:1px solid var(--line);border-radius:var(--radius);padding:24px;background:#fff}
  .quote p{margin-bottom:16px}
  .who{display:flex;align-items:center;gap:12px;font-size:14px}
  .av{width:42px;height:42px;border-radius:50%;background:#e0e7ff;display:grid;place-items:center;font-weight:700;color:var(--brand-dark)}
  .who span{color:var(--muted);display:block;font-size:13px}

  /* FAQ */
  .faq{max-width:760px;margin:0 auto}
  details{border-bottom:1px solid var(--line);padding:16px 0}
  summary{cursor:pointer;font-weight:600;list-style:none;display:flex;justify-content:space-between}
  summary::after{content:"+";color:var(--brand);font-size:22px;line-height:1}
  details[open] summary::after{content:"–"}
  details p{color:var(--muted);margin-top:10px}

  /* CTA + footer */
  .cta{background:var(--brand);color:#fff;border-radius:24px;padding:56px 24px;text-align:center}
  .cta p{opacity:.85;margin:8px 0 24px}
  .cta .btn{background:#fff;color:var(--brand)}
  footer{background:#0f172a;color:#cbd5e1;margin-top:72px;padding:48px 0 24px}
  .fgrid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:32px;margin-bottom:32px}
  footer h4{color:#fff;margin-bottom:10px;font-size:15px}
  footer a{display:block;font-size:14px;padding:3px 0;color:#94a3b8}
  footer a:hover{color:#fff}
  .copy{border-top:1px solid #1e293b;padding-top:18px;font-size:13px;color:#64748b}

  @media(max-width:900px){
    .menu{display:none}
    .hero-grid,.price-grid,.tgrid,.ben-grid{grid-template-columns:1fr}
    .steps,.stats-grid{grid-template-columns:repeat(2,1fr)}
    .cats{grid-template-columns:repeat(3,1fr)}
    .fgrid{grid-template-columns:1fr 1fr}
    .hero h1{font-size:36px}
    section{padding:52px 0}
  }
</style>


</head>
<body>

<?= view('layouts/header') ?>

<div>
<?= $content ?>
</div>

<?= view('layouts/footer') ?>





<!-- Email Verification Modal -->
<div class="modal fade"
     id="sellerVerifyOtpModal"
     tabindex="-1"
     aria-labelledby="sellerVerifyOtpModalLabel"
     aria-hidden="true"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-body p-4 p-md-5">

                <!-- Close Button -->
                <div class="d-flex justify-content-end">
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <!-- Verification Icon -->
                <div class="verify-icon mx-auto mb-3">✉</div>

                <div class="text-center">
                    <h3 class="fw-bold" id="sellerVerifyOtpModalLabel">
                        Verify your email
                    </h3>

                    <p class="text-muted mb-4">
                        Enter the 6-digit OTP sent to your email address.
                    </p>
                </div>

                <!-- Success Message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <!-- Error Messages -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- OTP Verification Form -->
                 <div id="sellerOtpMessage"></div>
                <form action="<?= site_url('seller/register/verify-otp') ?>"
                      method="post">


                    <div class="mb-3">
                        <label for="sellerOtpInput"
                               class="form-label fw-semibold">
                            Email OTP
                        </label>

                        <input type="text"
                               id="sellerOtpInput"
                               name="otp"
                               class="form-control form-control-lg otp-input"
                               placeholder="000000"
                               inputmode="numeric"
                               pattern="[0-9]{6}"
                               maxlength="6"
                               autocomplete="one-time-code"
                               required>
                    </div>

                    <button type="submit"
                            class="btn btn-primary btn-lg w-100 fw-semibold">
                        Verify OTP &amp; Register
                    </button>

                </form>

                <!-- Resend OTP -->
                <form action="<?= site_url('seller/register/resend-otp') ?>"
                      method="post"
                      class="mt-3">


                    <button type="submit"
                            class="btn btn-outline-secondary w-100">
                        Resend OTP
                    </button>

                </form>

                <div class="text-center mt-4">
                    <a href="<?= site_url('seller/register') ?>"
                       class="text-decoration-none">
                        Back to registration
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .verify-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: #e7f8ef;
        color: #198754;
        font-size: 30px;
    }

    #sellerVerifyOtpModal .modal-content {
        background: #fff;
    }

    #sellerVerifyOtpModal .otp-input {
        min-height: 55px;
        text-align: center;
        font-size: 25px;
        letter-spacing: 8px;
        font-weight: 700;
    }

    #sellerVerifyOtpModal .form-control {
        border-radius: 10px;
    }

    #sellerVerifyOtpModal .btn {
        min-height: 46px;
        border-radius: 10px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const otpInput = document.getElementById('sellerOtpInput');

    if (otpInput) {
        otpInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
        });
    }

    const modalElement = document.getElementById('sellerVerifyOtpModal');

    if (modalElement && typeof bootstrap !== 'undefined') {
        const otpModal = bootstrap.Modal.getOrCreateInstance(modalElement);
        otpModal.show();
    }
});
</script> -->

<script>

$(document).ready(function () {

    $('#sellerSignupForm').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const button = $('#sellerSignupBtn');
        const message = $('#sellerSignupMessage');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        message.empty();

        button.prop('disabled', true)
              .html('Sending OTP...');

        $.ajax({
            url: "<?= site_url('seller/register/send-otp') ?>",
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.status === 'success') {

                    message.html(
                        '<div class="alert alert-success">' +
                        $('<div>').text(response.message).html() +
                        '</div>'
                    );

                    $('#sellerOtpMessage').empty();

                    const modalElement =
                        document.getElementById('sellerVerifyOtpModal');

                    if (modalElement) {
                        bootstrap.Modal
                            .getOrCreateInstance(modalElement)
                            .show();
                    } else {
                        message.append(
                            '<div class="alert alert-warning">' +
                            'OTP sent, but the verification modal was not found.' +
                            '</div>'
                        );
                    }

                } else {

                    let html = '<div class="alert alert-danger">';

                    if (response.errors) {
                        $.each(response.errors, function (key, error) {
                            html += '<div>' +
                                $('<div>').text(error).html() +
                                '</div>';
                        });
                    } else {
                        html += $('<div>').text(
                            response.message || 'Unable to send OTP.'
                        ).html();
                    }

                    html += '</div>';

                    message.html(html);
                }
            },

            error: function (xhr) {

                let errorMessage =
                    'Unable to process your request. Please try again.';

                if (xhr.responseJSON) {
                    errorMessage =
                        xhr.responseJSON.message || errorMessage;

                    if (xhr.responseJSON.errors) {
                        errorMessage = Object.values(
                            xhr.responseJSON.errors
                        ).join('\n');
                    }
                }

                message.html(
                    '<div class="alert alert-danger">' +
                    $('<div>').text(errorMessage).html() +
                    '</div>'
                );
            },

            complete: function () {
                button.prop('disabled', false)
                      .html('Send Email OTP');
            }
        });
    });

});

</script>




</body>
</html>