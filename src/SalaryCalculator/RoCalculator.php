<?php

declare(strict_types=1);

namespace App\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use App\DTO\SalaryComponent;
use App\SalaryCalculator\SalaryCalculatorInterface;
use Money\Money;

class RoCalculator implements SalaryCalculatorInterface
{

    public function fromGross(Money $grossSalary): SalaryBreakdown
    {
//        $tax = $this->calculateTax($gross);

        $breakdown = new SalaryBreakdown();
        $breakdown->addSalaryComponent(new SalaryComponent('Gross Annual Salary', $grossSalary));
        $breakdown->addSalaryComponent(new SalaryComponent('Gross Monthly Salary', $grossSalary->divide(12)));
//        $breakdown->addSalaryComponent(new SalaryComponent('Net Annual Salary', $gross->subtract($tax)));
//        $breakdown->addSalaryComponent(new SalaryComponent('Net Monthly Salary', $gross->subtract($tax)->divide(12)));
//        $breakdown->addSalaryComponent(new SalaryComponent('Annual Tax Paid', $tax));
//        $breakdown->addSalaryComponent(new SalaryComponent('Monthly Tax Paid', $tax->divide(12)));

        return $breakdown;
    }
}
