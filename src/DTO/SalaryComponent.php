<?php

declare(strict_types=1);

namespace App\DTO;

use Money\Money;

readonly class SalaryComponent
{
    public function __construct(
        public string $name,
        public Money $amount,
    )
    {
    }
}
