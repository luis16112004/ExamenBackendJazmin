<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProviderController;

// Ruta para registrar ventas
Route::post('/ventas', [ProviderController::class, 'store']);

// Si después necesitas proteger con middleware:
// Route::middleware('firebase.token')->group(function () {
//     Route::post('/ventas', [ProviderController::class, 'store']);
// });