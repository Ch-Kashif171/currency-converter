<?php

namespace Amkas\CurrencyConverter\Facades;

use Amkas\CurrencyConverter\CurrencyConverter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static integer|string convertAmount(integer|string $amount, string $currency)
 * @method static CurrencyConverter amount(integer|string $amount)
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
