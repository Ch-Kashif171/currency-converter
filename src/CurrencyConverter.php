<?php

namespace Amkas\CurrencyConverter;

use Amkas\CurrencyConverter\Conversion\ConvertRate;
use JetBrains\PhpStorm\Pure;

class CurrencyConverter
{
    /**
     * @param float $amount
     * @param string $from
     * @param string $to
     */
    public function __construct(private float $amount = 0.00, private string $from = '', private string $to = ''){}

    /**
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public static function convertAmount(float $amount, string $currency = ''): string
    {
        return ConvertRate::convertAmount($amount, $currency);
    }

    /**
     * @param float $amount
     * @return CurrencyConverter
     */
    #[Pure] public static function amount(float $amount): CurrencyConverter
    {
        return new CurrencyConverter($amount);
    }

    /**
     * @param $from
     * @return $this
     */
    public function from($from): static
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function to($to): static
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     * @throws Exceptions\ConversionException
     */
    public function convert(): string
    {
        return ConvertRate::convert($this->amount, $this->from, $this->to);
    }

}
