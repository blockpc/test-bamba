<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\System\ChangePasswordController;
use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\PageHomeController;
use App\Http\Controllers\System\PermissionsController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\RolesController;
use App\Http\Controllers\System\UsersController;
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
    });

    Route::middleware([
        'auth'
    ])->group(function($routes) {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::prefix('sistema')->group(function() {
            Route::get('/', function () {
                return redirect(route('dashboard'));
            });

            Route::get('/perfil-usuario', ProfileController::class)
                ->name('profile');

            Route::get('/dashboard', DashboardController::class)
                ->name('dashboard');
            
            Route::get('/usuarios', [UsersController::class, 'index'])
                ->name('users');

            Route::get('/roles', RolesController::class)
                ->name('roles.index');

            Route::get('/permisos', PermissionsController::class)
                ->name('permissions.index');
        });
    });
});
