<?php

declare(strict_types=1);

namespace App\SalaryCalculator;

use App\DTO\SalaryBreakdown;
use App\DTO\SalaryComponent;
use Money\Money;

class SalaryBreakdownBuilder
{
    public function buildSalaryBreakdown(Money $grossSalary, Money $tax): SalaryBreakdown
    {
        $breakdown = new SalaryBreakdown();
        $breakdown->addSalaryComponent(new SalaryComponent('Gross Annual Salary', $grossSalary));
        $breakdown->addSalaryComponent(new SalaryComponent('Gross Monthly Salary', $grossSalary->divide(12)));
        $breakdown->addSalaryComponent(new SalaryComponent('Net Annual Salary', $grossSalary->subtract($tax)));
        $breakdown->addSalaryComponent(new SalaryComponent('Net Monthly Salary', $grossSalary->subtract($tax)->divide(12)));
        $breakdown->addSalaryComponent(new SalaryComponent('Annual Tax Paid', $tax));
        $breakdown->addSalaryComponent(new SalaryComponent('Monthly Tax Paid', $tax->divide(12)));

        return $breakdown;
    }
}