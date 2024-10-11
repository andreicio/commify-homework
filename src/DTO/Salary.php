<?php

declare(strict_types=1);

namespace App\DTO;

use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

readonly class Salary
{
    public function __construct(
        #[Assert\Choice(['GBP', 'RON'])]
        public string $currency,

        #[Assert\Type('digit', 'Amount has to be a positive number with no decimal digits')]
        public string $amount,
    )
    {
    }
}
