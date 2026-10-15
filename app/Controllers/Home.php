<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $layout = 'layouts/default';

    public function index()
    {
        return $this->view('welcome_message');
    }
}
