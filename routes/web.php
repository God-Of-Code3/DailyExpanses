<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('test');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/main', function () {
    return view('main');
});

Route::get('/statistics', function () {
    return view('statistics');
});

Route::get('/transaction', function () {
    return view('transaction');
});

Route::get('/transactions', function () {
    return view('transactions');
});

Route::get('/forecast', function () {
    return view('forecast');
});

Route::get('/history', function () {
    return view('history');
})->name('history-get');

Route::post('/history', function () {
    return view('history');
})->name('history-post');

Route::post('/login', function () {
    return dd($_POST);
})->name('login-post');