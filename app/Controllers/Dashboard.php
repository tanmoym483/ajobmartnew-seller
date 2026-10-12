<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SellerModel;

class Dashboard extends BaseController
{
    protected SellerModel $sellers;
    protected $layout = 'layouts/dashboard/default_dashboard';

    public function __construct()
    {
        $this->sellers = new SellerModel();
    }


    public function dashboard()
{
    if (! session()->get('seller_id')) {
        return redirect()->to(site_url('seller/login'));
    }

    return $this->view('seller/dashboard/index', [
        'title'         => 'Seller Dashboard - Ajobmart',
        'totalSales'    => 0,
        'totalOrders'   => 0,
        'totalProducts' => 0,
        'pendingOrders' => 0,
        'recentOrders'  => [],
    ]);
}


}