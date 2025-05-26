<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    RestauranteController,
    AdminController,
    MesaController,
    CategoriaController,
    ItemController
};
// Autenticação (rotas públicas)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);
// ROTAS PROTEGIDAS - todas exigem login
Route::middleware('admin.auth')->group(function () {
    // restaurantes (CRUD completo)
    Route::apiResource('restaurantes', RestauranteController::class);
    // admins (CRUD completo)
    Route::apiResource('admins', AdminController::class);
    // mesas
    Route::apiResource('mesas', MesaController::class);
    // categorias
    Route::apiResource('categorias', CategoriaController::class);
    // itens do cardápio
    Route::apiResource('items', ItemController::class);
});

Route::get('/mesa/{id}', [MesaController::class, 'cardapio']);
