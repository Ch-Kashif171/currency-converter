<?php

namespace Amkas\CurrencyConverter\Conversion;

use Amkas\CurrencyConverter\Exceptions\ConversionException;
use Illuminate\Support\Facades\Cache;

class ConvertRate extends Convert
{

    /**
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public static function convertAmount(float $amount, string $currency = ''): string
    {
        return Cache::rememberForever(self::cacheName($currency), static function () use ($amount, $currency) {
            return self::convertRate($amount, $currency);
        });
    }

    /**
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return string
     * @throws ConversionException
     */
    public static function convert(float $amount, string $from, string$to): string
    {
        return self::convertFrom($amount, $from, $to);
    }

    /**
     * @param float $amount
     * @param string $currency
     * @return string
     * @throws ConversionException
     */
    protected static function convertRate(float $amount, string $currency): string
    {
        $defaultRate = self::getDefaultRate();
        $currency = self::getCurrency($currency);
        return self::rateQuery($amount, $currency, $defaultRate);
    }

    /**
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return string
     * @throws ConversionException
     */
    protected static function convertFrom(float $amount, string $from, string $to): string
    {
        $defaultRate = self::getDefaultRate();
        $fromRate = self::getCurrencyRate($from);
        $toRate = self::getCurrencyRate($to);
        return self::calculateRate($amount, $fromRate, $toRate, $defaultRate);
    }
}
