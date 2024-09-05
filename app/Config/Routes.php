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