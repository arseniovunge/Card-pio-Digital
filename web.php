<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginWeb']);
Route::get('/logout', [AuthController::class, 'logoutWeb'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Após login, redirecionar para dashboard
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/
Route::resource('categorias', CategoriaController::class)->middleware('web');
