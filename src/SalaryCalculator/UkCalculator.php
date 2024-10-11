<?php

declare(strict_types=1);

namespace App\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use App\Repository\UkTaxRepository;
use Money\Money;

readonly class UkCalculator implements SalaryCalculatorInterface
{
    public function __construct(
        private UkTaxRepository       $ukTaxRepository,
        private SalaryBreakdownBuilder $salaryBreakdownBuilder,
    )
    {
    }

    public function fromGross(Money $grossSalary): SalaryBreakdown
    {
        $tax = new Money(0, $grossSalary->getCurrency());
        $taxBrackets = $this->ukTaxRepository->findApplicableTaxBrackets($grossSalary);

        $untaxed = (new Money(0, $tax->getCurrency()))->add($grossSalary);
        foreach ($taxBrackets as $bracket) {
            $lowerLimit = new Money($bracket->getMin() * 100, $untaxed->getCurrency());
            $taxableAmount = $untaxed->subtract($lowerLimit);
            $tax = $tax->add($taxableAmount->multiply($bracket->getPercent() / 100));
            $untaxed = $lowerLimit;
        }

        return $this->salaryBreakdownBuilder->buildSalaryBreakdown($grossSalary, $tax);
    }
}
