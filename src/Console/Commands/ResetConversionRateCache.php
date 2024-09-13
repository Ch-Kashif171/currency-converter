<?php

namespace Amkas\CurrencyConverter\Console\Commands;

use Amkas\CurrencyConverter\Conversion\ResetCache;
use Illuminate\Console\Command;

class ResetConversionRateCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'converter:reset-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command is to rest the converter's currency rate cache keys";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ResetCache::reset();
        $this->info("The converter cache has been reset successfully!");
    }
}
