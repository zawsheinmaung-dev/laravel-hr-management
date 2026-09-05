<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    /** @use HasFactory<\Database\Factories\LeavetypeFactory> */
    use HasFactory;

    public function leaveBalance()
    {
        return $this->hasMany(leaveBalance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
