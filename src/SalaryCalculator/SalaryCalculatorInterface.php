<?php

declare(strict_types=1);

namespace App\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use Money\Money;

interface SalaryCalculatorInterface
{
    public function fromGross(Money $grossSalary): SalaryBreakdown;
}