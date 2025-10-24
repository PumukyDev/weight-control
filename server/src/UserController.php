<?php

// Traer los archivos necesarios
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/config.php';

class UserController
{
    private $userModel;

    // Constructor
    public function __construct()
    {
        global $pdo;
        $this->userModel = new User($pdo);
    }

    // Método getPdo
    public function getPdo()
    {
        global $pdo;
        return $pdo;
    }

    // Crear un usuario
    public function createUser($name, $surnames, $birth)
    {
        return $this->userModel->createUser($name, $surnames, $birth);
    }

    // Obtener el ID del último usuario añadido
    public function getLastInsertedId()
    {
        return $this->userModel->getLastInsertedId();
    }
}

?>