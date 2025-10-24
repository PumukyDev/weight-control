<?php

// Traer el archivo de configuración
require_once './config.php';

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Verificar si existe un usuario con el mismo nombre y apellidos
    public function checkUserExists($username, $surnames)
    {
        $stmt = $this->pdo->prepare("SELECT id_user FROM Users WHERE name = ? AND surnames = ?");
        $stmt->execute([$username, $surnames]);
        return $stmt->rowCount() > 0;
    }

    // Crear un usuario
    public function createUser($name, $surnames)
    {
        try {
            // Comprobar si el usuario ya existe
            if ($this->checkUserExists($name, $surnames)) {
                return false;
            }

            $stmt = $this->pdo->prepare("INSERT INTO Users (name, surnames) 
                                        VALUES (?, ?)");
            return $stmt->execute([$name, $surnames]);
        } catch (PDOException $e) {
            error_log("Error en createUser: " . $e->getMessage());
            return false;
        }
    }

    // Obtener el id del último usuario añadido
    public function getLastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }
}

?>