<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ComentariosController;

Route::post('login', [UsuariosController::class, 'login']);
Route::post('register', [UsuariosController::class, 'registrar']);
// Ruta para solicitar el restablecimiento (POST)
Route::post('forgot-password', [UsuariosController::class, 'forgotPassword']);

// Ruta para mostrar formulario (GET)
Route::get('reset-password/{token}/{email}', [UsuariosController::class, 'showResetForm'])
     ->name('password.reset');

// Ruta para procesar el restablecimiento (POST)
Route::post('reset-password', [UsuariosController::class, 'resetPassword']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('user', [UsuariosController::class, 'getUserTipo']); // Cambiado de getUserRole a getUserTipo
    Route::post('logout', [UsuariosController::class, 'logout']);

    // Rutas para user y admin
    Route::middleware(['tipo:user,admin'])->group(function () { // Cambiado de role a tipo

        Route::controller(ProductosController::class)->group(function () {
            Route::get('productos', 'index');
            Route::get('producto/{id}', 'show');
        });

        Route::controller(PedidosController::class)->group(function () {
            Route::get('pedidos', 'index');
            Route::post('pedido', 'store');
            Route::get('pedido/{id}', 'show');
        });

        Route::controller(ComentariosController::class)->group(function () {
            Route::post('comentario', 'store');
            Route::get('comentarios/{producto_id}', 'getByProducto');
        });
    });

    // Rutas solo para admin
    Route::middleware(['tipo:admin'])->group(function () { // Cambiado de role a tipo

        Route::controller(ProductosController::class)->group(function () {
            Route::post('crearProducto', 'store');
            Route::put('editarProducto/{id}', 'update');
            Route::delete('eliminarProducto/{id}', 'destroy');
        });

        Route::controller(UsuariosController::class)->group(function () {
            Route::get('usuarios', 'index');
            Route::get('usuario/{id}', 'show');
            Route::put('editarUsuario/{id}', 'update');
            Route::delete('eliminarUsuario/{id}', 'destroy');
        });
    });
});