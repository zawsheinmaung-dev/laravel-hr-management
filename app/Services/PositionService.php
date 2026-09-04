<?php

namespace App\Services;

use App\Models\Position;
use App\Models\Department;

class PositionService
{
    public function index()
    {
    return Position::with('department')
        ->withCount('employees')->get();
    }

    public function create()
    {
        return Department::all();
    }

    public function store($data)
    {
        Position::create($data);
    }

    public function show($id)
    {
        return Position::with('employees','department.headEmp')->find($id);
    }

    public function edit($id)
    {
        
        $pos=Position::with('department.headEmp','department')->find($id);
        $dep =Department::all();
        return ['pos'=>$pos,'dep'=>$dep];
    }  
    
    public function update($data,$id)
    {
        $pos =Position::find($id);
        $pos->update($data);
        return $pos;
    }

    public function delete($id)
    {
        $pos =Position::find($id);
        $pos->delete();
        return;
    }
}