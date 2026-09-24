<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructureItem extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'salary_component_id',
        'salary_structure_id',
        'calculation_type',
        'amount',
        'percentage',
        'effective_date'
    ];
    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function salaryComponent()
    {
        return $this->belongsTo(SalaryComponent::class);
    }
}
