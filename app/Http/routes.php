<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
require_once __DIR__ . '/../../vendor/autoload.php';

Route::get('/', function () {
    return view('welcome');
});
Route::get('spell', 'Spell@index');
Route::get('spell/index', 'Spell@index');
Route::get('spell/random', 'Spell@random');
Route::resource('spell', 'Spell', ['only' => ['index', 'random']]);