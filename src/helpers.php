<?php

use Amkas\CurrencyConverter\Conversion\ConvertRate;

if (!function_exists('convertRate')) {
    function convertAmount($amount, $currency = '')
    {
        return ConvertRate::convertAmount($amount, $currency);
    }
}

if (!function_exists('amount')) {
    function amount($amount)
    {

        return new class($amount) {

            public function __construct(private $amount, private $from = '', private $to = '')
            {
            }

            public function from($from)
            {
                $this->from = $from;
                return $this;
            }

            public function to($to)
            {
                $this->to = $to;
                return $this;
            }

            function convert()
            {
                return ConvertRate::convert($this->amount, $this->from, $this->to);
            }

        };
    }
}
