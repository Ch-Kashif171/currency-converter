<?php

namespace Amkas\CurrencyConverter\Conversion;

use Amkas\CurrencyConverter\Conversion\Interfaces\ConvertInterface;
use Amkas\CurrencyConverter\Exceptions\ConversionException;
use Amkas\CurrencyConverter\Models\CurrencyRate;
use Illuminate\Container\Container;

class Convert implements ConvertInterface
{
    /**
     * @var Container|mixed|object|string
     */
    protected mixed $default_rate;
    /**
     * @var Container|mixed|object|string
     */
    protected mixed $conversion_rate;
    /**
     * @var Container|mixed|object|string
     */
    protected mixed $default_currency;

    /**
     * @var Container|mixed|object|string
     */
    protected mixed $cache_prefix = '';

    /**
     * @var Container|mixed|object|string
     */
    public mixed $amount_decimal_places = '';

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
    public static function getRate($amount, $rate): float|int
    {
        return ($amount / $rate);
    }

    /**
     * @param $currency
     * @return mixed
     */
    public static function getCurrency($currency): mixed
    {
        return ($currency != '' ? $currency : (new self())->default_currency);
    }

    /**
     * @return mixed
     */
    public static function getDefaultRate(): mixed
    {
        $defaultRate = CurrencyRate::query()->where('currency', (new self())->default_currency)->value('rate');
        if ($defaultRate) {
            return $defaultRate;
        }

        return (new self())->default_rate;
    }

    /**
     * @param $from
     * @return mixed
     */
    public static function getCurrencyRate($from): mixed
    {
        $defaultRate = CurrencyRate::query()->where('currency', $from)->value('rate');
        if ($defaultRate) {
            return $defaultRate;
        }

        return (new self())->default_rate;
    }

    /**
     * @param float $amount
     * @param string $currency
     * @param float $defaultRate
     * @return string
     * @throws ConversionException
     */
    public static function rateQuery(float $amount, string $currency, float $defaultRate): string
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
     * @param float$amount
     * @param float $fromRate
     * @param float $toRate
     * @param float $defaultRate
     * @return mixed
     * @throws ConversionException
     */
    public static function calculateRate(float $amount, float $fromRate, float $toRate, float $defaultRate): mixed
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
