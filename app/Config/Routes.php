<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/FastprintAPI', 'FastprintAPI::index');
$routes->get('/', 'ProdukController::index');
$routes->get('/add', 'ProdukController::create');
$routes->post('/store', 'ProdukController::store');
$routes->get('/edit/(:num)', 'ProdukController::edit/$1');
$routes->post('/update/(:num)', 'ProdukController::update/$1');
$routes->get('/delete/(:num)', 'ProdukController::delete/$1');
