<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');


$routes->get('seller/register', 'SellerAuth::register');
// $routes->post('seller/register', 'SellerAuth::store');

$routes->get('seller/login', 'LoginAuth::login');
$routes->post('seller/login/authenticate', 'SellerAuth::authenticate');

$routes->get('seller/dashboard', 'Dashboard::dashboard');
$routes->get('seller/logout', 'SellerAuth::logout');


// $routes->get('seller/register', 'Seller\Auth::register');
$routes->post('seller/register/send-otp', 'SellerAuth::sendOtp');
// $routes->get('seller/register/verify', 'SellerAuth::verifyPage');
$routes->post('seller/register/verify-otp', 'SellerAuth::verifyOtp');
$routes->post('seller/register/resend-otp', 'SellerAuth::resendOtp');


$routes->get(
    'seller/products/add',
    'SellerProducts::add'
);

$routes->post(
    'seller/products/store',
    'SellerProducts::store'
);

$routes->get('seller/inventory', 'SellerProducts::inventory');

$routes->get('shared-images/(:any)', 'SharedImages::show/$1');

$routes->post(
    'seller/products/shipping-allowance',
    'SellerProducts::shippingAllowance'
);
