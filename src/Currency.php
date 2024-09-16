<?php

namespace Amkas\CurrencyConverter;

use Amkas\CurrencyConverter\Conversion\ConvertRate;

class Currency
{

    public function __construct(private $amount = 0, private $from = '', private $to = ''){}

    /**
     * @param $amount
     * @param $currency
     * @return string
     */
    public static function convertAmount($amount, $currency = '')
    {
        return ConvertRate::convertAmount($amount, $currency);
    }

    /**
     * @param $amount
     * @return Currency
     */
    public static function amount($amount)
    {
        return new Currency($amount);
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     * @throws Exceptions\ConversionException
     */
    public function convert()
    {
        return ConvertRate::convert($this->amount, $this->from, $this->to);
    }

}
