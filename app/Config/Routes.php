<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

$routes->get('admin', 'Admin::index');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/logout', 'Admin::logout');

$routes->get('master/pengguna', 'User::index');
$routes->add('master/pengguna/(:any)', 'User::$1');

