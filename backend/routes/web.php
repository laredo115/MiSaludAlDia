<?php

use App\Http\Controllers\MedicamentoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TomaController;
use App\Http\Controllers\CitaController;

Route::get('/', function () {
    return redirect()->route(Auth::check() ? 'panel' : 'login');
});

Route::middleware('auth')->group(function () {
    Route::view('/panel', 'panel')->name('panel');

    Route::get('/medicamentos', [MedicamentoController::class, 'index'])
        ->name('medicamentos.index');

    Route::post('/medicamentos', [MedicamentoController::class, 'store'])
        ->name('medicamentos.store');

    Route::delete('/medicamentos/{medicamento}', [MedicamentoController::class, 'destroy'])
        ->whereNumber('medicamento')
        ->name('medicamentos.destroy');

        Route::post('/medicamentos/{medicamento}/tomas', [TomaController::class, 'store'])
    ->whereNumber('medicamento')
    ->name('tomas.store');


});Route::get('/citas', [CitaController::class, 'index'])
    ->name('citas.index');

Route::post('/citas', [CitaController::class, 'store'])
    ->name('citas.store');

Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])
    ->whereNumber('cita')
    ->name('citas.destroy');