<?php

namespace App\Models;

use Amkas\CurrencyConverter\Conversion\ResetConversionCache;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use ResetConversionCache;

    protected $fillable = [
        'currency', 'rate'
    ];
}
