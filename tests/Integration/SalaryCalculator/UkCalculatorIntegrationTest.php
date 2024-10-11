<?php

declare(strict_types=1);

namespace App\Tests\Integration\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use App\SalaryCalculator\UkCalculator;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UkCalculatorIntegrationTest extends KernelTestCase
{

    /** @dataProvider salaries */
    public function testFromGross(int $salary, int $tax): void
    {
        self::bootKernel();

        $grossSalary = Money::GBP($salary * 100);
        $expectedTax = Money::GBP($tax * 100);

        $result = static::getContainer()->get(UkCalculator::class)->fromGross($grossSalary);
        self::assertInstanceOf(SalaryBreakdown::class, $result);
        self::assertCount(6, $result->getComponents());
        self::assertTrue($result->getComponents()[4]->amount->equals($expectedTax));
    }

    /** @return array<int, array<int, int>> */
    public function salaries(): array
    {
        return [
            [10_000, 1_000],
            [40_000, 11_000],
        ];
    }
}