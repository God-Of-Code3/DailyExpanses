<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

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

// Route::get('/login', [UserController::class, 'login'])->name('login-get');

// Страница регистрации - отображение и обработка
Route::get('/register', [UserController::class, 'register'])->name('register-get');
Route::post('/register', [UserController::class, 'handleRegister'])->name('register-post');

// Страница авторизации - отображение и обработка
Route::get('/login', [UserController::class, 'login'])->name('login-get');
Route::post('/login', [UserController::class, 'handleLogin'])->name('login-post');

// Главная страница
Route::get('/main', [UserController::class, 'main'])->middleware('auth')->name('main-get');
Route::post('/main', [TransactionController::class, 'createTransaction'])->middleware('auth')->name('main-post');

// Страница транзакции, удаление и редактирование транзакции
Route::get('/transaction/{transaction_id}', [TransactionController::class, 'transaction'])->middleware('auth')->name('transaction-get');
Route::get('/transaction/{transaction_id}/remove', [TransactionController::class, 'removeTransaction'])->middleware('auth')->name('transaction-get-remove');

Route::post('/transaction', [TransactionController::class, 'editTransaction'])->middleware('auth')->name('transaction-post');

// Страница истории
Route::get('/history', [UserController::class, 'history'])->middleware('auth')->name('history-get');
Route::post('/history', [UserController::class, 'history'])->middleware('auth')->name('history-post');

// Route::get('/main', function () {
//     return view('main');
// })->name('main-get');

Route::get('/statistics', function () {
    return view('statistics');
})->name('statistics-post');

// Route::get('/transaction', function () {
//     return view('transaction');
// })->name('transaction-get');

Route::get('/transactions', function () {
    return view('transactions');
});

Route::get('/forecast', function () {
    return view('forecast');
})->name('forecast-get');

// Route::get('/history', function () {
//     return view('history');
// })->name('history-get');

// Route::post('/history', function () {
//     return view('history');
// })->name('history-post');

Route::get('/export', function () {
    return view('export');
})->name('export-get');