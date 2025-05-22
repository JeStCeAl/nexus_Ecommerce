<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\DetallesController;
use App\Http\Controllers\ComentariosController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando']);
});

// Rutas públicas (registro y login)
Route::post('/register', [UsuariosController::class, 'registrar']);
Route::post('/login', [UsuariosController::class, 'login']);

// Rutas protegidas con JWT
Route::middleware(['auth:api'])->group(function () {

    Route::post('/logout', [UsuariosController::class, 'logout']);
    Route::get('/user/role', [UsuariosController::class, 'getUserRole']);

    // Rutas accesibles para usuarios comunes (user o admin)
    Route::middleware(['role:user,admin'])->group(function () {

        // Productos (ver productos disponibles)
        Route::get('/productos', [ProductosController::class, 'index']);
        Route::get('/productos/{id}', [ProductosController::class, 'show']);

        // Pedidos
        Route::get('/pedidos', [PedidosController::class, 'index']);
        Route::post('/pedidos', [PedidosController::class, 'store']);
        Route::get('/pedidos/{id}', [PedidosController::class, 'show']);

        // Comentarios
        Route::post('/comentarios', [ComentariosController::class, 'store']);
        Route::get('/comentarios/{producto_id}', [ComentariosController::class, 'getByProducto']);
    });

    // Rutas exclusivas para admin
    Route::middleware(['role:admin'])->group(function () {

        // Gestión de productos
        Route::post('/productos', [ProductosController::class, 'store']);
        Route::put('/productos/{id}', [ProductosController::class, 'update']);
        Route::delete('/productos/{id}', [ProductosController::class, 'destroy']);

        // Gestión de usuarios (opcional)
        Route::get('/usuarios', [UsuariosController::class, 'index']);
        Route::get('/usuarios/{id}', [UsuariosController::class, 'show']);
        Route::put('/usuarios/{id}', [UsuariosController::class, 'update']);
        Route::delete('/usuarios/{id}', [UsuariosController::class, 'destroy']);
    });

});
