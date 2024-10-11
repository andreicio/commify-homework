<?php

declare(strict_types=1);

namespace App\Tests\Unit\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use App\Entity\UkTax;
use App\Repository\UkTaxRepository;
use App\SalaryCalculator\SalaryBreakdownBuilder;
use App\SalaryCalculator\UkCalculator;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UkCalculatorTest extends TestCase
{
    private UkTaxRepository|MockObject $repositoryMock;
    private SalaryBreakdownBuilder|MockObject $builderMock;
    private UkCalculator $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = $this->createMock(UkTaxRepository::class);
        $this->builderMock = $this->createMock(SalaryBreakdownBuilder::class);

        $this->sut = new UkCalculator($this->repositoryMock, $this->builderMock);
    }

    /**
     * @dataProvider salaries
     * @param UkTax[] $taxBrackets
     */
    public function testFromGross(int $salary, int $tax, array $taxBrackets): void
    {
        $grossSalary = Money::GBP($salary * 100);
        $expectedTax = Money::GBP($tax * 100);

        $this->repositoryMock->expects($this->once())->method('findApplicableTaxBrackets')
            ->with($grossSalary)->willReturn($taxBrackets);

        $breakdownMock = $this->createMock(SalaryBreakdown::class);
        $this->builderMock->expects($this->once())->method('buildSalaryBreakdown')
            ->with($grossSalary, $expectedTax)->willReturn($breakdownMock);

        $result = $this->sut->fromGross($grossSalary);
        self::assertSame($result, $breakdownMock);
    }

    /** @return array<int, array<int, int>> */
    public function salaries(): array
    {
        $taxBrackets = [
            (new UkTax())->setMin(20_000)->setPercent(40),
            (new UkTax())->setMin(5_000)->setMax(20_000)->setPercent(20),
            (new UkTax())->setMin(0)->setMax(5_000)->setPercent(0),
        ];
        return [
            [10_000, 1_000, array_slice($taxBrackets, 1)],
            [40_000, 11_000, $taxBrackets],
        ];
    }
}
