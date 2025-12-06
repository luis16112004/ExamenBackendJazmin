<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProviderController;

// Ruta pública para probar rápido (luego le pones el middleware 'firebase')
Route::post('/crear-venta', [ProviderController::class, 'store']);
Route::middleware(['firebase'])->group(function () {
    Route::get('/ventas', function () {
        return response()->json(['mensaje' => 'Si ves esto, tu token de Android es válido']);
    });
}); 