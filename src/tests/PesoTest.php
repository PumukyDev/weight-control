<?php
use PHPUnit\Framework\TestCase;

// Tener instalada esta librería: composer require --dev phpunit/phpunit

require_once __DIR__ . '/../src/Peso.php';

class PesoTest extends TestCase
{
    private $pdoMock;
    private $peso;

    protected function setUp(): void
    {
        // Crear un mock de PDO (no usa la base de datos real)
        $this->pdoMock = $this->createMock(PDO::class);
        $this->peso = new Peso($this->pdoMock);
    }

    // ===== TESTS DE CAJA BLANCA (estructura interna) =====

    /**
     * Test: calculateIMC con valores válidos
     * Caja blanca: verifica la fórmula peso / (altura^2)
     */
    public function testCalculateIMCWithValidValues()
    {
        $weight = 70;
        $height = 1.75;
        $expectedIMC = 70 / (1.75 * 1.75); // 22.86

        $result = $this->peso->calculateIMC($weight, $height);

        $this->assertEquals($expectedIMC, $result, '', 0.01);
    }

    /**
     * Test: calculateIMC con altura cero
     * Caja blanca: verifica la validación interna
     */
    public function testCalculateIMCWithZeroHeight()
    {
        $result = $this->peso->calculateIMC(70, 0);
        $this->assertEquals(0, $result);
    }

    /**
     * Test: calculateIMC con altura negativa
     * Caja blanca: verifica la validación interna
     */
    public function testCalculateIMCWithNegativeHeight()
    {
        $result = $this->peso->calculateIMC(70, -1.75);
        $this->assertEquals(0, $result);
    }

    // ===== TESTS DE CAJA NEGRA (entrada/salida) =====

    /**
     * Test: calculateIMC - Persona con bajo peso
     * Caja negra: entrada conocida → salida esperada
     */
    public function testCalculateIMCUnderweight()
    {
        $result = $this->peso->calculateIMC(50, 1.75);
        $this->assertLessThan(18.5, $result); // IMC < 18.5 = bajo peso
    }

    /**
     * Test: calculateIMC - Persona con peso normal
     * Caja negra: entrada conocida → salida esperada
     */
    public function testCalculateIMCNormalWeight()
    {
        $result = $this->peso->calculateIMC(70, 1.75);
        $this->assertGreaterThanOrEqual(18.5, $result);
        $this->assertLessThan(25, $result); // 18.5 <= IMC < 25 = peso normal
    }

    /**
     * Test: calculateIMC - Persona con sobrepeso
     * Caja negra: entrada conocida → salida esperada
     */
    public function testCalculateIMCOverweight()
    {
        $result = $this->peso->calculateIMC(85, 1.75);
        $this->assertGreaterThanOrEqual(25, $result);
        $this->assertLessThan(30, $result); // 25 <= IMC < 30 = sobrepeso
    }

    /**
     * Test: calculateIMC - Persona con obesidad
     * Caja negra: entrada conocida → salida esperada
     */
    public function testCalculateIMCObese()
    {
        $result = $this->peso->calculateIMC(100, 1.75);
        $this->assertGreaterThanOrEqual(30, $result); // IMC >= 30 = obesidad
    }

    // ===== TESTS DE VALORES LÍMITE =====

    /**
     * Test: Valor mínimo positivo de altura
     */
    public function testCalculateIMCWithMinimalHeight()
    {
        $result = $this->peso->calculateIMC(70, 0.01);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * Test: Peso cero
     */
    public function testCalculateIMCWithZeroWeight()
    {
        $result = $this->peso->calculateIMC(0, 1.75);
        $this->assertEquals(0, $result);
    }

    // ===== TESTS CON MOCK DE BASE DE DATOS =====

    /**
     * Test: hasWeightToday retorna true cuando hay registro
     * Mock: simula que la BD devuelve count = 1
     */
    public function testHasWeightTodayReturnsTrue()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['count' => 1]);

        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->peso->hasWeightToday(1);
        $this->assertTrue($result);
    }

    /**
     * Test: hasWeightToday retorna false cuando no hay registro
     * Mock: simula que la BD devuelve count = 0
     */
    public function testHasWeightTodayReturnsFalse()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['count' => 0]);

        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->peso->hasWeightToday(1);
        $this->assertFalse($result);
    }

    /**
     * Test: createWeight con peso negativo retorna false
     * Caja negra: validación de entrada
     */
    public function testCreateWeightWithNegativeWeight()
    {
        $result = $this->peso->createWeight(-10, 1.75, '2025-10-24', 1);
        $this->assertFalse($result);
    }

    /**
     * Test: createWeight con altura cero retorna false
     * Caja negra: validación de entrada
     */
    public function testCreateWeightWithZeroHeight()
    {
        $result = $this->peso->createWeight(70, 0, '2025-10-24', 1);
        $this->assertFalse($result);
    }

    /**
     * Test: createWeight con altura negativa retorna false
     * Caja negra: validación de entrada
     */
    public function testCreateWeightWithNegativeHeight()
    {
        $result = $this->peso->createWeight(70, -1.75, '2025-10-24', 1);
        $this->assertFalse($result);
    }
}
?>