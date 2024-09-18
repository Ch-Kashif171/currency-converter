<?php

namespace Amkas\CurrencyConverter\Conversion;

use Illuminate\Support\Facades\Cache;

class ConvertRate extends Convert
{

    /**
     * @param string $amount
     * @param string $currency
     * @return string
     */
    public static function convertAmount(string $amount, string $currency = ''): string
    {
        return Cache::rememberForever(self::cacheName($currency), function () use ($amount, $currency) {
            return self::convertRate($amount, $currency);
        });
    }

    /**
     * @throws \Amkas\CurrencyConverter\Exceptions\ConversionException
     */
    public static function convert(string $amount, string $from, $to): string
    {
        return self::convertFrom($amount, $from, $to);
    }

    /**
     * @param string $amount
     * @param string $currency
     * @return string
     * @throws \Amkas\CurrencyConverter\Exceptions\ConversionException
     */
    protected static function convertRate(string $amount, string $currency)
    {
        $defaultRate = self::getDefaultRate();
        $currency = self::getCurrency($currency);
        return self::rateQuery($amount, $currency, $defaultRate);
    }

    /**
     * @param $amount
     * @param $from
     * @param $to
     * @return string
     * @throws \Amkas\CurrencyConverter\Exceptions\ConversionException
     */
    protected static function convertFrom($amount, $from, $to)
    {
        $defaultRate = self::getDefaultRate();
        $fromRate = self::getCurrencyRate($from);
        $toRate = self::getCurrencyRate($to);
        return self::calculateRate($amount, $fromRate, $toRate, $defaultRate);
    }
}
