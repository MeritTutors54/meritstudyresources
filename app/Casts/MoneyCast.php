<?php

namespace App\Casts;

use InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class MoneyCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): Money | null
    {
        if ($value === null) {
            return null;
        }

        $currency = $attributes['currency'] ?? 'GBP';

        if (! $currency instanceof Currency) {
            $currency = new Currency($currency);
        }

        return new Money($value, $currency);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int | null
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Money) {
            return (int) $value->getAmount();
        }

        $currency = $attributes['currency'] ?? 'GBP';
        $currencies = new ISOCurrencies();
        $parser     = new DecimalMoneyParser($currencies);   // handles scale per currency

        try {
            $money = $parser->parse((string) $value, new Currency($currency));
        } catch (\Throwable $e) {
            throw new InvalidArgumentException("[$key] is not a valid money value");
        }


        return (int) $money->getAmount();
    }
}
