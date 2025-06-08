<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvaliacaoController;
Route::get('/', [HomeController::class, 'index']);

Auth::routes();

// Usuário
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/agendar', [UserController::class, 'create']);
    Route::post('/agendar', [UserController::class, 'store']);
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    Route::get('/meus-agendamentos/editar/{id}', [UserController::class, 'edit'])->name('agendamentos.edit');
    Route::put('/meus-agendamentos/atualizar/{id}', [UserController::class, 'update'])->name('agendamentos.update');
    Route::get('/meus-agendamentos', [UserController::class, 'index'])->name('agendamentos.index');

});

// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/admin/confirmar/{id}', [AdminController::class, 'confirm']);
    Route::post('/admin/cancelar/{id}', [AdminController::class, 'cancel']);
    Route::get('/admin/editar/{id}', [AdminController::class, 'edit']);
    Route::put('/admin/atualizar/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/excluir/{id}', [AdminController::class, 'destroy']);
});
