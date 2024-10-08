<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//splash
$routes->get('/', 'UserController::index');

//register
$routes->get('/register', 'UserController::register');
$routes->post('/user/createuser', 'UserController::createuser');

//login
$routes->get('/login', 'UserController::login');
$routes->post('user/authenticate', 'UserController::authenticate');
$routes->get('/logout', 'UserController::logout');

//dashboard
$routes->get('/admin/admindashboard', 'DashboardController::admin');
$routes->get('/manager/managerdashboard', 'DashboardController::manager');
$routes->get('/photographer/photographerdashboard', 'DashboardController::photographer');
$routes->get('/fbteam/fbteamdashboard', 'DashboardController::fbteam');

//other
$routes->get('/listusers', 'UserController::listUsers');
$routes->get('/deleteuser/(:num)', 'UserController::deleteUser/$1');

//file
$routes->get('/file/download/(:num)', 'FileController::download/$1');
$routes->get('/file/edit/(:num)', 'FileController::edit/$1');
$routes->post('/file/update/(:num)', 'FileController::update/$1');
$routes->get('/file/delete/(:num)', 'FileController::delete/$1');

//upload
$routes->get('/uploadForm', 'FileController::uploadForm');
$routes->post('/upload', 'FileController::upload');

//event
$routes->get('/eventForm', 'EventController::eventForm');
$routes->post('/storeEvent', 'EventController::storeEvent');
$routes->get('/eventlist', 'EventController::eventList');


$routes->post('file/updateStatus', 'FileController::updateStatus');

$routes->get('approved-uploads', 'FileController::approvedUploads');

//profile
$routes->get('/profile', 'UserController::profile');
$routes->post('/updateProfile', 'UserController::updateProfile');



