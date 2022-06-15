<?php

use Illuminate\Support\Str;

/** @var \Laravel\Lumen\Routing\Router $router */

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

// Generate Key Application 
$router->get('/key', function () {
    return Str::random(32);
});



$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

$router->group(['middleware' => 'auth'], function() use ($router){

    //pegawai
    $router->group(['prefix' => 'masterPegawai', 'namespace' => 'masterDesa'], function () use ($router){
        $router->get('/pegawai', 'PegawaiController@index');
        $router->post('/pegawai', 'PegawaiController@store');
        $router->get('/pegawai/{id}', 'PegawaiController@show');
        $router->post('/pegawai/{id}', 'PegawaiController@update');
        $router->delete('/pegawai/{id}', 'PegawaiController@destroy');
    
    });

    //pejabat

    $router->group(['prefix' => 'masterJabatan', 'namespace' => 'masterDesa'], function() use ($router){
        $router->get('/jabatan', 'JabatanController@index');
        $router->post('/jabatan', 'JabatanController@store');
        $router->get('/jabatan/{id}', 'JabatanController@show');
        $router->post('/jabatan/{id}', 'JabatanController@update');
        $router->delete('/jabatan/{id}', 'JabatanController@destroy');

    
    });

    //dusun
    $router->group(['prefix' => 'masterKampung', 'namespace' => 'masterDesa'], function() use ($router){
        $router->get('/kampung', 'KampungController@index');
        $router->post('/kampung', 'KampungController@store');
        $router->get('/kampung/{id}', 'KampungController@show');
        $router->post('/kampung/{id}', 'KampungController@update');
        $router->delete('/kampung/{id}', 'KampungController@destroy');

    });
    
    
});




