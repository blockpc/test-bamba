<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\System\ChangePasswordController;
use App\Http\Controllers\System\PageHomeController;
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

Route::middleware([
    'web',
])->group(function () {

    Route::get('/', PageHomeController::class)->name('home');
    Route::get('/cambiar-password/{token}', ChangePasswordController::class)->name('password.reset');
    
    Route::middleware([
        'guest'
    ])->group(function() {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::get('/registro', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/registro', [RegisteredUserController::class, 'store']);
    });

    Route::middleware([
        'auth'
    ])->group(function($routes) {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    });
});
