<?php

use Amkas\Ch\Conversion\ConvertRate;

if (!function_exists('convertRate')) {

    function convertRate($amount, $currency = '')
    {
        return ConvertRate::convert($amount, $currency);
    }
}
