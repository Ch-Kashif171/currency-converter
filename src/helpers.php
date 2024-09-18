<?php

use Amkas\CurrencyConverter\Conversion\ConvertRate;
use Amkas\CurrencyConverter\CurrencyConverter;

if (!function_exists('convertRate')) {
    function convertAmount($amount, $currency = '')
    {
        return ConvertRate::convertAmount($amount, $currency);
    }
}

if (!function_exists('amount')) {
    function amount($amount) {
        return new CurrencyConverter($amount);
    }
}
