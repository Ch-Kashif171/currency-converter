<?php

namespace Amkas\CurrencyConverter\Conversion;

use App\Models\CurrencyRate;

use Illuminate\Support\Facades\Cache;

class ConvertRate
{
    use Convert;

    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    private mixed $default_rate;
    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    private mixed $conversion_rate;
    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    private mixed $default_currency;

    /**
     * @var \Illuminate\Container\Container|mixed|object|string
     */
    public mixed $cache_prefix = '';

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
     * @param string $amount
     * @param string $currency
     * @return string
     */
    public static function convert(string $amount, string $currency = ''): string
    {
        return Cache::rememberForever(self::cacheName($currency), function () use ($amount, $currency) {
            return self::convertRate($amount, $currency);
        });
    }

    /**
     * @param string $amount
     * @param string $currency
     * @return string
     */
    protected static function convertRate(string $amount, string $currency)
    {
        $defaultRate = self::getDefaultRate();
        $currency = self::getCurrency($currency);
        $decimal_places = (new self())->amount_decimal_places;

        $currencyQuery = CurrencyRate::query()->where('currency', $currency);
        if ($currencyQuery->exists()) {
            $currencyRate = CurrencyRate::query()->select('currency', 'rate')->where('currency', $currency)->first();

            if ($currencyRate) {
                return number_format((self::getRate($amount, $defaultRate) * $currencyRate->rate), $decimal_places);
            }
        }

        return number_format((self::getRate($amount, (new self())->default_rate) * (new self())->conversion_rate), $decimal_places);
    }
}
