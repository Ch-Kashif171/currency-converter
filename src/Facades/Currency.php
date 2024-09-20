<?php

namespace Amkas\CurrencyConverter\Facades;

use Amkas\CurrencyConverter\CurrencyConverter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static float convertAmount(float $amount, string $currency)
 * @method static CurrencyConverter amount(float $amount)
 */

class Currency extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'currency';
    }
}
