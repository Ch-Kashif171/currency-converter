<?php

namespace Amkas\CurrencyConverter;

use Amkas\CurrencyConverter\Conversion\ConvertRate;

class Currency
{
    /**
     * @param $amount
     * @param $currency
     * @return string
     */
    public static function convert($amount, $currency = '')
    {
        return ConvertRate::convert($amount, $currency);
    }
}
