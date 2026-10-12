<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SellerModel;

class LoginAuth extends BaseController
{
    protected SellerModel $sellers;
    protected $layout = 'layouts/default_auth';

    public function __construct()
    {
        $this->sellers = new SellerModel();
    }


    public function login()
    {
        if ($this->session->get('seller_id')) {
            return redirect()->to('/seller/dashboard');
        }

        return $this->view('seller/auth/login');
    }


}