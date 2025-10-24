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
    public function createWeight($weight, $height, $date, $id_user)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Pesajes (peso, altura, fecha, id_user) 
                                        VALUES (?, ?, ?, ?)");
            return $stmt->execute([$weight, $height, $date, $id_user]);
        } catch (PDOException $e) {
            error_log("Error en createWeight: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los pesos
    public function index()
    {
        $stmt = $this->pdo->query("SELECT p.*, u.name, u.surnames 
                                    FROM Pesajes p 
                                    INNER JOIN Users u ON p.id_user = u.id_user
                                    ORDER BY p.fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el peso máximo
    public function getMax(){
        $stmt = $this->pdo->query("SELECT p.peso as max_peso, u.name, u.surnames 
                                FROM Pesajes p 
                                INNER JOIN Users u ON p.id_user = u.id_user 
                                ORDER BY p.peso DESC 
                                LIMIT 1");
                return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener el peso mínimo
    public function getMin(){
        $stmt = $this->pdo->query("SELECT p.peso as min_peso, u.name, u.surnames 
                        FROM Pesajes p 
                        INNER JOIN Users u ON p.id_user = u.id_user 
                        ORDER BY p.peso ASC 
                        LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>