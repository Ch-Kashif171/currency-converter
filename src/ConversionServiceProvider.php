<?php

namespace Amkas\CurrencyConverter;

use Amkas\CurrencyConverter\Console\Commands\ResetConversionRateCache;
use Illuminate\Support\ServiceProvider;

class ConversionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerHelpers();

        $this->publishfiles();
    }

    public function register()
    {
        $this->commands([
            ResetConversionRateCache::class,
        ]);
    }

    protected function publishfiles()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/Models/CurrencyRate.php' => base_path('App/Models/CurrencyRate.php'),
                __DIR__ . '/config/currency_converter.php' => base_path('config/currency_converter.php'),
                __DIR__ . '/database/migrations' => database_path('migrations'),
            ], 'amkas-currency-converter');
        }
    }

    private function registerHelpers()
    {
        if (file_exists($file = __DIR__ .'helpers.php')) {
            require $file;
        }
    }

}
