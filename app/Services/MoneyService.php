<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

final class MoneyService
{
    public static function convertToReadableMoney(Money $money): float
    {
        $currencies = new ISOCurrencies();
        $formatter  = new DecimalMoneyFormatter($currencies);

        return $formatter->format($money);
    }

    public static function parseMoney(string $money, string $currency): Money
    {
        $currencies = new ISOCurrencies();
        $parser     = new DecimalMoneyParser($currencies);   // handles scale per currency

        return $parser->parse($money, new Currency($currency));
    }
}
