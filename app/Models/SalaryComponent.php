<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryComponent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'description'
    ];

    public function salaryComponentItems()
    {
        return $this->hasMany(SalaryStructureItem::class);
    }

    public function salaryStructures()
    {
        return $this->belongsToMany(
            SalaryStructure::class,
            'salary_structure_items',
            'salary_component_id',
            'salary_structure_id'
        )->distinct();
    }
}
