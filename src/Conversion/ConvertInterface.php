<?php

namespace Amkas\CurrencyConverter\Conversion;

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
     * @return int|mixed
     */
    public static function getDefaultRate();

    /**
     * @param string $currency
     * @return string
     */
    public static function cacheName(string $currency);
}
