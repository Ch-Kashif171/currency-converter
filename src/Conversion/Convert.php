<?php

namespace Amkas\CurrencyConverter\Conversion;

use App\Models\CurrencyRate;

class Convert implements ConvertInterface
{
    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    protected mixed $default_rate;
    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    protected mixed $conversion_rate;
    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    protected mixed $default_currency;

    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    protected mixed $cache_prefix = '';

    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    public mixed $amount_decimal_places = '';

    /**
     * @param string $default_currency
     */
    public function __construct()
    {
        $this->cache_prefix = 'convert_rate_';
        $this->default_rate = config('currency_converter.default_rate') ?? '1.000';
        $this->conversion_rate = config('currency_converter.conversion_rate') ?? '1.000';
        $this->default_currency = config('currency_converter.default_currency') ?? '1.000';
        $this->amount_decimal_places = config('currency_converter.amount_decimal_places') ?? '3';
    }

    /**
     * @param $amount
     * @param $rate
     * @return float|int
     */
    public static function getRate($amount, $rate)
    {
        return ($amount / $rate);
    }

    /**
     * @param $currency
     * @return \Illuminate\Container\Container|mixed|object|string
     */
    public static function getCurrency($currency)
    {
        return ($currency != '' ? $currency : (new self())->default_currency);
    }

    /**
     * @return int|mixed
     */
    public static function getDefaultRate()
    {
        $defaultRate = CurrencyRate::query()->where('currency', (new self())->default_currency)->value('rate');
        if ($defaultRate) {
            return $defaultRate;
        }

        return (new self())->default_rate;
    }

    /**
     * @param string $currency
     * @return string
     */
    public static function cacheName(string $currency): string
    {
        return (new self())->cache_prefix . $currency;
    }
}
