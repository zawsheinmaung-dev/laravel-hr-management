<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxBracket extends Model
{
    /** @use HasFactory<\Database\Factories\TaxBracketFactory> */
    use HasFactory;

    protected $fillable = [
        'min_amount',
        'max_amount',
        'rate_percentage',
        'effective_year',
    ];
}
