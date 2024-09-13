<?php

namespace Amkas\CurrencyConverter\Conversion;

use App\Models\CurrencyRate;

trait Convert
{
    /**
     * @param $amount
     * @param $rate
     * @return float|int
     */
    protected static function getRate($amount, $rate)
    {
        return ($amount / $rate);
    }

    /**
     * @param $currency
     * @return \Illuminate\Container\Container|mixed|object|string
     */
    protected static function getCurrency($currency)
    {
        return ($currency != '' ? $currency : (new self())->default_currency);
    }

    /**
     * @return int|mixed
     */
    protected static function getDefaultRate()
    {
        $defaultRate = CurrencyRate::query()->where('currency', (new self())->default_currency)->value('rate');
        if ($defaultRate) {
            return $defaultRate;
        }

        return (new self())->default_rate;
    }

    /**
     * @param string $currency
     * @return string
     */
    public static function cacheName(string $currency): string
    {
        return (new self())->cache_prefix . $currency;
    }
}
