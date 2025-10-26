<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../Peso.php';
require_once __DIR__ . '/../PesoController.php';
require_once __DIR__ . '/../UserController.php';

class PesoTest extends TestCase
{
    private $pesoController;
    private $userController;
    private $userId;
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->pdo->exec("DELETE FROM Pesajes");
        $this->pdo->exec("DELETE FROM Users");

        $this->pesoController = new PesoController();
        $this->userController = new UserController();

        $this->userController->createUser('Alice', 'Smith', '1990-01-01');
        $this->userId = $this->userController->getUserId('Alice', 'Smith', '1990-01-01');
    }

    public function testCreateWeight(): void
    {
        $result = $this->pesoController->createWeight(70, 1.75, date('Y-m-d H:i:s'), $this->userId);
        $this->assertTrue($result);
    }

    public function testWeightNegative(): void
    {
        $result = $this->pesoController->createWeight(-5, 1.75, date('Y-m-d H:i:s'), $this->userId);
        $this->assertFalse($result);
    }

    public function testMinimumWeight(): void
    {
        $result = $this->pesoController->createWeight(0, 1.75, date('Y-m-d H:i:s'), $this->userId);
        $this->assertTrue($result);
    }
}
