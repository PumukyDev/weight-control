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
    public function checkUserExists($username, $surnames, $birth)
    {
        $stmt = $this->pdo->prepare("SELECT id_user FROM Users WHERE name = ? AND surnames = ? AND birth = ?");
        $stmt->execute([$username, $surnames, $birth]);
        return $stmt->rowCount() > 0;
    }

    // Crear un usuario
    public function createUser($name, $surnames, $birth)
    {
        try {
            // Comprobar si el usuario ya existe
            if ($this->checkUserExists($name, $surnames, $birth)) {
                return false;
            }

            $stmt = $this->pdo->prepare("INSERT INTO Users (name, surnames, birth) 
                                        VALUES (?, ?, ?)");
            return $stmt->execute([$name, $surnames, $birth]);
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