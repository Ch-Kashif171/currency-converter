<?php

namespace Amkas\CurrencyConverter\Conversion\Traits;

use Amkas\CurrencyConverter\Conversion\ResetCache;

trait ResetConversionCache
{
    protected static function booted()
    {
        ResetCache::reset();
    }
}
