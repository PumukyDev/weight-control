<?php

namespace App;

use InvalidArgumentException;

class PriceCalculator
{
    public function applyDiscount(float $price, int $discount): float
    {
        if ($price <= 0) {
            throw new InvalidArgumentException("price must be > 0");
        }
        if ($discount < 0 || $discount > 100) {
            throw new InvalidArgumentException("discount must be between 0 and 100");
        }
        $final = $price * (1 - $discount / 100);
        return round($final, 2);
    }
}
