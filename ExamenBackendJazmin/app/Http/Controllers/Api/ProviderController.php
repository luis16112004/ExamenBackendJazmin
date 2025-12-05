<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class ProviderController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function store(Request $request)
    {
        // 1. Validar que nos envíen datos
        $request->validate([
            'producto' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer'
        ]);

        // 2. Preparar los datos
        $datos = [
            'producto' => $request->producto,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'fecha' => now()->toDateTimeString(),
            // 'usuario_uid' => $request->firebase_uid // Si quisieras guardar quién lo vendió
        ];

        // 3. Guardar en Firebase usando el servicio
        $idVenta = $this->firebaseService->guardarVenta($datos);

        return response()->json([
            'mensaje' => 'Venta guardada con éxito en Firebase',
            'id_firebase' => $idVenta
        ], 201);
    }
}