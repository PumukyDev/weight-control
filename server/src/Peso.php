<?php
// Traer el archivo de configuración
require_once './config.php';

class Peso
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Crear el registro del peso
    public function createWeight($weight, $height, $date, $id_user){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Pesajes (peso, altura, fecha, id_user) 
                                        VALUES (?, ?, ?, ?)");
            return $stmt->execute([$weight, $height, $date, $id_user]);
        } catch (PDOException $e) {
            error_log("Error en createWeight: " . $e->getMessage());
            return false;
        }
    }
}
?>