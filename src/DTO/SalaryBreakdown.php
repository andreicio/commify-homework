<?php

declare(strict_types=1);

namespace App\DTO;

class SalaryBreakdown
{
    /** @var SalaryComponent[] */
    private array $components = [];

    public function addSalaryComponent(SalaryComponent $component): void
    {
        $this->components[] = $component;
    }

    public function getComponents(): array
    {
        return $this->components;
    }
}
