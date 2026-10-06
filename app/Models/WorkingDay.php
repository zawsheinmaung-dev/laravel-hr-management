<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = [
        'name',
        'shift_id',
        'is_working'
    ];
}
