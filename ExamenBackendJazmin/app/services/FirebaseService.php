<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));
        
        // Configuramos Auth y Database al mismo tiempo
        $factory = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL')); // <--- Importante

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    // Método para verificar token (ya lo tenías)
    public function verifyToken(string $token)
    {
        try {
            return $this->auth->verifyIdToken($token);
        } catch (\Throwable $e) {
            return null;
        }
    }

    // NUEVO: Método para guardar una venta
    public function guardarVenta(array $datosVenta)
    {
        // Esto creará una entrada en la colección 'ventas' con un ID único
        $nuevaVenta = $this->database->getReference('ventas')->push($datosVenta);
        return $nuevaVenta->getKey(); // Retorna el ID generado
    }
}