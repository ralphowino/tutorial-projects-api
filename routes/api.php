<?php

$api->post('register', 'AuthController@register');
$api->post('login', 'AuthController@login');

$api->group(['middleware' => 'api.auth'], function ($api) {

    $api->get('teams/{slug}/members', 'TeamsController@getMembers');
    $api->post('teams/{slug}/members', 'TeamsController@addMember');
    $api->delete('teams/{slug}/members/{id}', 'TeamsController@removeMember');
    $api->resource('teams', 'TeamsController', ['except' => ['create', 'edit']]);

    $api->group(['middleware' => 'tenant'], function ($api) {
        $api->resource('projects', 'ProjectsController');
    });

});
