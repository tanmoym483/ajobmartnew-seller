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

$routes->get(
    'seller/products/subcategories/(:num)',
    'SellerProducts::subcategories/$1'
);

$routes->get(
    'seller/products/category-attributes/(:num)',
    'SellerProducts::getCategoryAttributes/$1'
);

$routes->get('seller/products', 'SellerProducts::index');
$routes->get('seller/products/list-data', 'SellerProducts::listData');


$routes->get(
    'seller/products/product-types/(:num)',
    'SellerProducts::productTypes/$1'
);

$routes->get(
    'seller/hsn/search',
    '\App\Controllers\HsnLookup::search'
);

$routes->post(
    'seller/inventory/update-stock',
    'SellerProducts::updateStock'
);


$routes->get(
    'seller/products/draft/(:num)',
    'SellerProducts::getDraft/$1'
);

$routes->get(
    'seller/products/check-sku',
    'SellerProducts::checkSku'
);

$routes->get('seller/orders', 'Orders::index');
// $routes->get('seller/orders/details/(:num)', 'Orders::details/$1');
// $routes->post('seller/orders/update-status', 'Orders::updateStatus');


$routes->get('seller/orders', 'Orders::index');
$routes->get('seller/orders/list-data', 'Orders::listData');

$routes->post('seller/orders/mark-shipped', 'Orders::markShipped');
$routes->post('seller/orders/mark-delivered', 'Orders::markDelivered');

// These two controller actions still need to be implemented.
$routes->post('seller/orders/generate-label', 'Orders::generateLabel');
$routes->get('seller/orders/label/(:num)', 'Orders::viewLabel/$1');
