<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/auth/me', 'AuthController@me');

$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/logout', 'AuthController@logout');
$router->post('/auth/refresh', 'AuthController@refresh');

$router->group(['namespace' => 'V1', 'prefix' => 'v1/{locale}', 'middleware' => ['auth','role.admin','permission']], function($router) {
	$router->get('blog/list', 'BlogController@list');
});