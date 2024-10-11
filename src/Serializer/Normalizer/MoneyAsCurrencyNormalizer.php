<?php

namespace App\Serializer\Normalizer;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MoneyAsCurrencyNormalizer implements NormalizerInterface
{
    private IntlMoneyFormatter $moneyFormatter;

    public function __construct()
    {
        $currencies = new ISOCurrencies();

        $numberFormatter = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
        $this->moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
    }

    /**
     * @param Money $object
     * @param array<string, string> $context
     */
    public function normalize($object, string $format = null, array $context = []): string
    {
        return $this->moneyFormatter->format($object);
    }

    /**
     * @param array<string, string> $context
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Money;
    }

    /**
     * @return array<string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Money::class => true,
        ];
    }
}
