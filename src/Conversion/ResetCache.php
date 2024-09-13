<?php

namespace Amkas\CurrencyConverter\Conversion;

use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Cache;

class ResetCache
{
    /**
     * @return string
     */
    public static function reset(): string
    {
        try {

            $currencies = CurrencyRate::query()->pluck('currency');
            foreach ($currencies as $currency) {
                Cache::forget(self::cacheName($currency));
            }
            return "The converter cache has been reset successfully!";
        } catch (\Exception $exception) {
            report($exception);
            return "Failed this command";
        }
    }

    /**
     * @param string $currency
     * @return string
     */
    private static function cacheName(string $currency): string
    {
        return ConvertRate::cacheName($currency);
    }
}