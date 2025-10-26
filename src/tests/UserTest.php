<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../User.php';
require_once __DIR__ . '/../UserController.php';

class UserTest extends TestCase
{
    private $userController;

    protected function setUp(): void
    {
        global $pdo;

        // Limpiar Pesajes primero para no violar constraints
        $pdo->exec("DELETE FROM Pesajes");
        $pdo->exec("DELETE FROM Users");

        $this->userController = new UserController();
    }

    // ================= VALID TESTS =================
    public function testCreateUser(): void
    {
        $result = $this->userController->createUser('Alice', 'Smith', '1990-01-01');
        $this->assertTrue($result);

        $id = $this->userController->getUserId('Alice', 'Smith', '1990-01-01');
        $this->assertNotNull($id);
    }

    // ================= INVALID TESTS =================
    public function testCreateDuplicateUser(): void
    {
        $this->userController->createUser('Bob', 'Jones', '1985-05-05');
        $result = $this->userController->createUser('Bob', 'Jones', '1985-05-05');
        $this->assertFalse($result);
    }

    public function testGetUserIdNotFound(): void
    {
        $id = $this->userController->getUserId('Charlie', 'Brown', '2000-01-01');
        $this->assertNull($id);
    }

    // ================= BOUNDARY TESTS =================
    public function testMinimumNameLength(): void
    {
        $result = $this->userController->createUser('A', 'B', '2000-01-01');
        $this->assertTrue($result);
    }

    public function testMaximumNameLength(): void
    {
        $longName = str_repeat('A', 50);
        $longSurname = str_repeat('B', 150);
        $result = $this->userController->createUser($longName, $longSurname, '2000-01-01');
        $this->assertTrue($result);
    }
}
