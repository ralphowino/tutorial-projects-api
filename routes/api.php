<?php

$api->post('register', 'AuthController@register');
$api->post('login', 'AuthController@login');

$api->group(['middleware' => 'api.auth'], function ($api) {
    $api->get('projects', function () {
        return response([['name' => 'Sample Project 1'], ['name' => 'Sample Project 2']]);
    });
});
