<?php
namespace App\Helpers;

class CodeGenerator
{
    public static function generate(string $name,int $id,int $pad)
    {
        return $name . str_pad($id,$pad,'0',STR_PAD_LEFT);
    }
}