<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ComentariosController;

Route::post('login', [UsuariosController::class, 'login']);
Route::post('register', [UsuariosController::class, 'registrar']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('user', [UsuariosController::class, 'getUserRole']);
    Route::post('logout', [UsuariosController::class, 'logout']);

    // Rutas para user y admin
    Route::middleware(['role:user,admin'])->group(function () {

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
    Route::middleware(['role:admin'])->group(function () {

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
