<?php

namespace App\Models\Concerns;

trait SearchTrait
{
    public function scopeSearch($query,$q,array $table_columns)
    {
        return $query ->when($q,function ($query ) use ($q,$table_columns){
                $query ->where(function ($query ) use ($q,$table_columns){
                    foreach($table_columns as $tc){
                        $query ->orWhere($tc,'like',"%{$q}%");
                    }
                });
        });
    }
}