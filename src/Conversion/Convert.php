<?php

namespace Amkas\CurrencyConverter\Conversion;

use Amkas\CurrencyConverter\Conversion\Interfaces\ConvertInterface;
use Amkas\CurrencyConverter\Exceptions\ConversionException;
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
     * @param $from
     * @return \Illuminate\Container\Container|mixed|object|string
     */
    public static function getCurrencyRate($from)
    {
        $defaultRate = CurrencyRate::query()->where('currency', $from)->value('rate');
        if ($defaultRate) {
            return $defaultRate;
        }

        return (new self())->default_rate;
    }

    /**
     * @param $amount
     * @param $currency
     * @param $defaultRate
     * @return string
     */
    public static function rateQuery($amount, $currency, $defaultRate)
    {
        try {
            $decimal_places = (new self())->amount_decimal_places;

            $currencyQuery = CurrencyRate::query()->where('currency', $currency);
            if ($currencyQuery->exists()) {
                $currencyRate = CurrencyRate::query()->select('currency', 'rate')->where('currency', $currency)->first();

                if ($currencyRate) {
                    return number_format((self::getRate($amount, $defaultRate) * $currencyRate->rate), $decimal_places);
                }
            }

            return number_format((self::getRate($amount, (new self())->default_rate) * (new self())->conversion_rate), $decimal_places);
        } catch (\Exception $e) {
            throw new ConversionException($e->getMessage());
        }
    }

    /**
     * @param $amount
     * @param $fromRate
     * @param $toRate
     * @param $defaultRate
     * @return mixed|string
     * @throws ConversionException
     */
    public static function calculateRate($amount, $fromRate, $toRate, $defaultRate)
    {
        try {
            if ($amount <= 0) {
                throw new ConversionException("The given amount must be greater than 0");
            }
            $decimal_places = (new self())->amount_decimal_places;
            $rate = ($defaultRate / $fromRate) * $toRate;
            return number_format($rate * $amount, $decimal_places);
        } catch (\Exception $e) {
            throw new ConversionException($e->getMessage());
        }

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
