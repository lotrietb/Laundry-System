<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {
		return \App\User::all();
    }]);

  $api->group(['middleware' => 'api.auth'], function ($api) {
    $api->post('pickup/store', 'App\Api\V1\Controllers\LaundryPickupController@store');
    $api->get('pickup', 'App\Api\V1\Controllers\LaundryPickupController@index');
    $api->get('pickup/{id}', 'App\Api\V1\Controllers\LaundryPickupController@show');
    $api->put('pickup/{id}', 'App\Api\V1\Controllers\LaundryPickupController@update');
    $api->delete('pickup/{id}', 'App\Api\V1\Controllers\LaundryPickupController@destroy');
  });
});



