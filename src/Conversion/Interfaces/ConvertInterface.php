<?php

namespace Amkas\CurrencyConverter\Conversion\Interfaces;

use Amkas\CurrencyConverter\Exceptions\ConversionException;

interface ConvertInterface
{
    /**
     * @param $amount
     * @param $rate
     * @return float|int
     */
    public static function getRate($amount, $rate): float|int;

    /**
     * @param $currency
     * @return mixed
     */
    public static function getCurrency($currency): mixed;

    /**
     * @param $from
     * @return mixed
     */
    public static function getCurrencyRate($from): mixed;

    /**
     * @param float $amount
     * @param string $currency
     * @param float $defaultRate
     * @return string
     */
    public static function rateQuery(float $amount, string $currency, float $defaultRate): string;

    /**
     * @param float $amount
     * @param float $fromRate
     * @param float $toRate
     * @param float $defaultRate
     * @return mixed
     * @throws ConversionException
     */
    public static function calculateRate(float $amount, float $fromRate, float $toRate, float $defaultRate): mixed;

    /**
     * @return mixed
     */
    public static function getDefaultRate(): mixed;

    /**
     * @param string $currency
     * @return string
     */
    public static function cacheName(string $currency): string;
}
