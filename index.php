<?php
session_start();

require 'core/Controller.php';
require 'core/Model.php';
require 'core/View.php';
require 'core/Router.php';
require 'core/Database.php';
require 'core/Middleware.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
function autoload_classes($class)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
    $file = __DIR__ . '/models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
    $file = __DIR__ . '/vendor/midtrans/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('autoload_classes');


$router = new Router('tiket'); // Menentukan base path /tiket
$router->get('register', 'Auth\\AuthController@showRegisterForm');
$router->post('register', 'Auth\\AuthController@register');
$router->get('login', 'Auth\\AuthController@showLoginForm');
$router->post('login', 'Auth\\AuthController@login');
$router->get('logout', 'Auth\\AuthController@logout');

$router->get('admin/dashboard', 'Admin\\DashboardController@index');

$router->get('admin/manage-event/list', 'Admin\\ManageEventController@index');
$router->get('admin/manage-event/create', 'Admin\\ManageEventController@create');
$router->post('admin/manage-event/store', 'Admin\\ManageEventController@store');
$router->get('admin/manage-event/edit/{id}', 'Admin\\ManageEventController@edit');
$router->post('admin/manage-event/update/{id}', 'Admin\\ManageEventController@update');
$router->get('admin/manage-event/delete/{id}', 'Admin\\ManageEventController@delete');

$router->get('admin/manage-event/create-ticket/{id}', 'Admin\\ManageEventController@createTiketForm');
$router->post('admin/manage-event/create-ticket/{id}', 'Admin\\ManageEventController@createTiket');
$router->get('admin/manage-event/ticket-detail/{id}', 'Admin\\ManageEventController@tiketDetail');
$router->get('admin/manage-event/edit-ticket/{id}', 'Admin\\ManageEventController@editTiket');
$router->post('admin/manage-event/update-ticket/{id}', 'Admin\\ManageEventController@updateTiket');


$router->get('admin/manage-user', 'Admin\\ManageUserController@index');
$router->post('admin/manage-user/store', 'Admin\\ManageUserController@store');
$router->post('admin/manage-user/delete', 'Admin\\ManageUserController@delete');
$router->get('admin/manage-user/update', 'Admin\\ManageUserController@update');


$router->get('admin/manage-payment', 'Admin\\ManagePaymentController@index');
$router->get('admin/laporan', 'Admin\\LaporanController@index');
$router->post('admin/laporan/report', 'Admin\\LaporanController@report');



$router->get('admin/redeem-ticket', 'Admin\\RedeemTicketController@index');
$router->post('admin/redeem-ticket', 'Admin\\RedeemTicketController@redeem');



$router->get('', 'App\\HomeController@index');
$router->get('event/detail/{id}', 'App\\EventController@index');

$router->get('order/ticket/{id}', 'App\\EventController@order');

$router->post('payment/create-transaction', 'App\\PaymentController@createTransaction');
$router->post('payment/create-transaction/pending', 'App\\PaymentController@pendingTransaction');
$router->post('payment/create-transaction/success', 'App\\PaymentController@successTransaction');
$router->get('payment/create-transaction/update-status/{}', 'App\\PaymentController@updataStatusTransaction');

$router->get('profil', 'App\\HomeController@profil');
$router->post('update-profil', 'App\\HomeController@updateProfil');
$router->get('ticket-saya', 'App\\HomeController@tiketSaya');
$router->get('ticket-saya/detail-ticket/{id}', 'App\\HomeController@detailTiketSaya');


$router->dispatch();
