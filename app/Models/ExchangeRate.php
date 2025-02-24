<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rates_history';

    protected $fillable = [
        'rates',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'rates' => 'array',
            'date' => 'datetime',
        ];
    }
}
