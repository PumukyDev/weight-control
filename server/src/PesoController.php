<?php

// Traer los archivos necesarios
require_once __DIR__ . '/Peso.php';
require_once __DIR__ . '/config.php';

class PesoController
{
    private $pesoModel;

    // Constructor
    public function __construct()
    {
        global $pdo;
        $this->pesoModel = new Peso($pdo);
    }

    // Método getPdo
    public function getPdo()
    {
        global $pdo;
        return $pdo;
    }

    // Crear un nuevo registro de peso
    public function createWeight($weight, $height, $date, $id_user)
    {
        return $this->pesoModel->createWeight($weight, $height, $date, $id_user);
    }
}

?>