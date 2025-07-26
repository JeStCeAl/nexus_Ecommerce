<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ComentariosController;

// 🔐 Autenticación pública
Route::post('login', [UsuariosController::class, 'login']);
Route::post('register', [UsuariosController::class, 'registrar']);

// 🔄 Recuperación de contraseña
Route::post('forgot-password', [UsuariosController::class, 'forgotPassword']);
Route::get('reset-password/{token}/{email}', [UsuariosController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [UsuariosController::class, 'resetPassword']);

// 🔒 Rutas protegidas por JWT
Route::middleware(['jwt.auth'])->group(function () {

    // 👤 Perfil de usuario autenticado
    Route::get('me', fn(Request $request) => response()->json($request->user()));
    Route::get('user', [UsuariosController::class, 'getUserTipo']); // Tipo de usuario (USER/ADMIN)
    Route::post('logout', [UsuariosController::class, 'logout']);
    Route::put('editarPerfil', [UsuariosController::class, 'editarPerfil']); // ✅ Editar perfil del usuario autenticado

    // 🟢 Rutas disponibles para usuarios y administradores
    Route::middleware(['tipo:user,admin'])->group(function () {

        // 📦 Productos
        Route::controller(ProductosController::class)->group(function () {
            Route::get('productos', 'index');
            Route::get('producto/{id}', 'show');
        });

        // 🛒 Pedidos
        Route::controller(PedidosController::class)->group(function () {
            Route::get('pedidos', 'index');
            Route::post('pedido', 'store');
            Route::get('pedido/{id}', 'show');
        });

        // 💬 Comentarios
        Route::controller(ComentariosController::class)->group(function () {
            Route::post('comentario', 'store');
            Route::get('comentarios/{producto_id}', 'getByProducto');
        });
    });

    // 🔴 Rutas exclusivas para administradores
    Route::middleware(['tipo:admin'])->group(function () {

        // 📦 CRUD de productos
        Route::controller(ProductosController::class)->group(function () {
            Route::post('crearProducto', 'store');
            Route::put('editarProducto/{id}', 'update');
            Route::delete('eliminarProducto/{id}', 'destroy');
        });

        // 👥 CRUD de usuarios
        Route::controller(UsuariosController::class)->group(function () {
            Route::get('usuarios', 'index');
            Route::get('usuario/{id}', 'show');
            Route::put('editarUsuario/{id}', 'update');
            Route::delete('eliminarUsuario/{id}', 'destroy');
        });
    });
});
