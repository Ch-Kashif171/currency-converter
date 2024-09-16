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
    public static function getRate($amount, $rate);

    /**
     * @param $currency
     * @return \Illuminate\Container\Container|mixed|object|string
     */
    public static function getCurrency($currency);

    /**
     * @param $from
     * @return mixed
     */
    public static function getCurrencyRate($from);

    /**
     * @param $amount
     * @param $currency
     * @param $defaultRate
     * @return mixed
     */
    public static function rateQuery($amount, $currency, $defaultRate);

    /**
     * @param $amount
     * @param $fromRate
     * @param $toRate
     * @param $defaultRate
     * @return mixed|string
     * @throws ConversionException
     */
    public static function calculateRate($amount, $fromRate, $toRate, $defaultRate);

    /**
     * @return int|mixed
     */
    public static function getDefaultRate();

    /**
     * @param string $currency
     * @return string
     */
    public static function cacheName(string $currency);
}
