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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('new_ticket', 'TicketsController@create');
Route::post('new_ticket', 'TicketsController@store');


// Route::get('tickets', 'TicketsController@create');
Route::get('/tickets', 'TicketsController@index');
Route::get('/tickets/{ticket_id?}', 'TicketsController@show');
// Route::get('/ticket/{slug?}/edit','TicketsController@edit');
// Route::post('/ticket/{slug?}/edit','TicketsController@update');
// Route::get('/ticket/{slug?}/delete','TicketsController@destroy');
// Route::post('/ticket/{slug?}/delete','TicketsController@destroy');

