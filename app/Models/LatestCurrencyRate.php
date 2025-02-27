<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LatestCurrencyRate extends Model
{
    protected $table = 'latest_currency_rates';

    protected $fillable = [
        'currency',
        'rate',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:4',
            'date' => 'datetime',
        ];
    }
}
