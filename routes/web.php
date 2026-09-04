<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\ReservaController;

Route::get('/', function () {
    return view('home');
});

// --- Cliente ---
Route::get('/cliente', [ClienteController::class, 'index']);
Route::get('/cliente/create', [ClienteController::class, 'create']);
Route::post('/cliente/store', [ClienteController::class, 'store'])->name('cliente.store');
Route::get('/cliente/edit/{id}', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::put('/cliente/update/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
Route::post('/cliente/search', [ClienteController::class, 'search'])->name('cliente.search');

// --- Destino ---
Route::get('/destino', [DestinoController::class, 'index']);
Route::get('/destino/create', [DestinoController::class, 'create']);
Route::post('/destino/store', [DestinoController::class, 'store'])->name('destino.store');
Route::get('/destino/edit/{id}', [DestinoController::class, 'edit'])->name('destino.edit');
Route::put('/destino/update/{id}', [DestinoController::class, 'update'])->name('destino.update');
Route::delete('/destino/{id}', [DestinoController::class, 'destroy'])->name('destino.destroy');
Route::post('/destino/search', [DestinoController::class, 'search'])->name('destino.search');

// --- Reserva ---
Route::get('/reserva', [ReservaController::class, 'index']);
Route::get('/reserva/create', [ReservaController::class, 'create']);
Route::post('/reserva/store', [ReservaController::class, 'store'])->name('reserva.store');
Route::get('/reserva/edit/{id}', [ReservaController::class, 'edit'])->name('reserva.edit');
Route::put('/reserva/update/{id}', [ReservaController::class, 'update'])->name('reserva.update');
Route::delete('/reserva/{id}', [ReservaController::class, 'destroy'])->name('reserva.destroy');
Route::post('/reserva/search', [ReservaController::class, 'search'])->name('reserva.search');
