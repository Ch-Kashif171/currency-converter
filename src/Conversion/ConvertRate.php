<?php

namespace Amkas\CurrencyConverter\Conversion;

use App\Models\CurrencyRate;

use Illuminate\Support\Facades\Cache;

class ConvertRate extends Convert
{

    /**
     * @param string $amount
     * @param string $currency
     * @return string
     */
    public static function convert(string $amount, string $currency = ''): string
    {
        return Cache::rememberForever(self::cacheName($currency), function () use ($amount, $currency) {
            return self::convertRate($amount, $currency);
        });
    }

    /**
     * @param string $amount
     * @param string $currency
     * @return string
     */
    protected static function convertRate(string $amount, string $currency)
    {
        $defaultRate = self::getDefaultRate();
        $currency = self::getCurrency($currency);
        $decimal_places = (new self())->amount_decimal_places;

        $currencyQuery = CurrencyRate::query()->where('currency', $currency);
        if ($currencyQuery->exists()) {
            $currencyRate = CurrencyRate::query()->select('currency', 'rate')->where('currency', $currency)->first();

            if ($currencyRate) {
                return number_format((self::getRate($amount, $defaultRate) * $currencyRate->rate), $decimal_places);
            }
        }

        return number_format((self::getRate($amount, (new self())->default_rate) * (new self())->conversion_rate), $decimal_places);
    }
}
