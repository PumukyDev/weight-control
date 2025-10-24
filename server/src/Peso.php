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
        $stmt = $this->pdo->query("SELECT p.*, u.name, u.surnames, u.birth
                                    FROM Pesajes p 
                                    INNER JOIN Users u ON p.id_user = u.id_user
                                    ORDER BY p.fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el peso máximo
    public function getMax()
    {
        $stmt = $this->pdo->query("SELECT p.peso as max_peso, u.name, u.surnames 
                                FROM Pesajes p 
                                INNER JOIN Users u ON p.id_user = u.id_user 
                                ORDER BY p.peso DESC 
                                LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener el peso mínimo
    public function getMin()
    {
        $stmt = $this->pdo->query("SELECT p.peso as min_peso, u.name, u.surnames 
                        FROM Pesajes p 
                        INNER JOIN Users u ON p.id_user = u.id_user 
                        ORDER BY p.peso ASC 
                        LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener el número de pesajes totales

    public function getCount()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Pesajes");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return isset($result['total']) ? (int) $result['total'] : 0;
        } catch (PDOException $e) {
            error_log("Error en getCount: " . $e->getMessage());
            return false;
        }
    }

    // Verificar si el usuario ya tiene un registro hoy
    public function hasWeightToday($id_user)
    {
        $today = date('Y-m-d');
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM Pesajes 
                                     WHERE id_user = ? AND DATE(fecha) = ?");
        $stmt->execute([$id_user, $today]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}

?>