<?php

use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\OrdersController;
use App\Http\Controllers\System\PermissionsController;
use App\Http\Controllers\System\ProductsController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\RolesController;
use App\Http\Controllers\System\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth'
])->group(function($routes) {

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

        /* Test Bamba Routes */
        Route::get('/productos', ProductsController::class)->name('system.products.index');
        Route::get('/pedidos', OrdersController::class)->name('system.orders.index');
    });
});