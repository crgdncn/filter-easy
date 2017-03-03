<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->action(
        'SendgridController@form'
    );
});

Route::get('/sendgrid/form', 'SendgridController@form');
Route::post('/sendgrid/send', 'SendgridController@send');
Route::get('/sendgrid/result', 'SendgridController@result');