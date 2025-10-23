<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/PriceCalculator.php';

class PriceCalculatorTest extends TestCase
{
    private PriceCalculator $calc;

    protected function setUp(): void
    {
        $this->calc = new PriceCalculator();
    }

    public function testDiscountZeroReturnsSamePrice()
    {
        $this->assertSame(100.00, $this->calc->applyDiscount(100.0, 0));
    }

    public function testDiscountOnePercent()
    {
        $this->assertSame(99.00, $this->calc->applyDiscount(100.0, 1));
    }

    public function testDiscountFiftyPercent()
    {
        $this->assertSame(50.00, $this->calc->applyDiscount(100.0, 50));
    }

    public function testDiscountNinetyNinePercent()
    {
        $this->assertSame(1.00, $this->calc->applyDiscount(100.0, 99));
    }

    public function testDiscountOneHundredPercent()
    {
        $this->assertSame(0.00, $this->calc->applyDiscount(100.0, 100));
    }

    public function testNegativeDiscountThrows()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->applyDiscount(100.0, -1);
    }

    public function testDiscountOver100Throws()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->applyDiscount(100.0, 101);
    }

    public function testZeroPriceThrows()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->applyDiscount(0.0, 10);
    }

    public function testVerySmallPriceWorks()
    {
        $this->assertSame(0.01 * 0.9, round($this->calc->applyDiscount(0.01, 10), 2));
    }
}
