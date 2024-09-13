<?php

namespace Amkas\CurrencyConverter\Conversion;

trait ResetConversionCache
{
    protected static function booted()
    {
        ResetCache::reset();
    }
}
