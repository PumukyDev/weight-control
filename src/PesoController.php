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

    // Obtener todos los pesos
    public function index()
    {
        $pesos = $this->pesoModel->index();
        return $pesos;
    }

    // Obtener el peso máximo
    public function getMax(){
        return $this->pesoModel->getMax();
    }

    // Obtener el peso mínimo
    public function getMin(){
        $min = $this->pesoModel->getMin();
        return $min;
    }

    // Obtener el número de pesajes totales
    public function getCount()
    {
        return $this->pesoModel->getCount();
    }

    // Verificar si el usuario ya registró peso hoy
    public function hasWeightToday($id_user)
    {
        return $this->pesoModel->hasWeightToday($id_user);
    }

    // Calcular IMC
    public function calculateIMC($weight, $height)
    {
        return $this->pesoModel->calculateIMC($weight, $height);
    }
}

?>