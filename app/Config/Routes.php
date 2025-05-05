<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API Routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Authentication Routes
    $routes->post('auth/login', 'Auth::login');
    $routes->post('auth/register', 'Auth::register');
    $routes->get('auth/profile', 'Auth::profile');
    $routes->post('auth/refresh', 'Auth::refresh');
    
    // User API Routes
    $routes->get('users', 'Users::index');
    $routes->get('users/(:num)', 'Users::show/$1');
    $routes->post('users', 'Users::create');
    $routes->put('users/(:num)', 'Users::update/$1');
    $routes->delete('users/(:num)', 'Users::delete/$1');
    
    // Product API Routes
    $routes->get('products', 'Products::index');
    $routes->get('products/(:num)', 'Products::show/$1');
    $routes->post('products', 'Products::create');
    $routes->put('products/(:num)', 'Products::update/$1');
    $routes->delete('products/(:num)', 'Products::delete/$1');
});
