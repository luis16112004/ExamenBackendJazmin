<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        // Opción 1: Usar archivo si existe
        $credentialsPath = base_path('firebase_credentials.json');
        
        // Opción 2: Usar variable de entorno (para Railway)
        if (!file_exists($credentialsPath) && env('FIREBASE_CREDENTIALS_JSON')) {
            // Crear archivo temporal desde variable de entorno
            $credentialsPath = sys_get_temp_dir() . '/firebase_credentials.json';
            file_put_contents($credentialsPath, env('FIREBASE_CREDENTIALS_JSON'));
        }

        $factory = (new Factory)
            ->withServiceAccount($credentialsPath)
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function verifyToken(string $token)
    {
        try {
            return $this->auth->verifyIdToken($token);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function guardarVenta(array $datosVenta)
    {
        $nuevaVenta = $this->database->getReference('ventas')->push($datosVenta);
        return $nuevaVenta->getKey();
    }
}