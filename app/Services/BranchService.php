<?php

namespace App\Services;

use App\Helpers\CodeGenerator;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\Employee;

class BranchService{

    

    public function create($data)
    {   
        $bch =Branch::create($data);
        $bch->code=CodeGenerator::generate('RB-',$bch->id,3);
        $bch->save();
        return $bch;
    }
    public function show($id)
    {
        return Branch::with('employees','departments','manager')->findOrFail($id);
    }

    public function edit($id)
    {
        return Branch::with('manager')->findOrFail($id);
    }

    public function update($request,$id)
    {
        $bch =Branch::find($id);
        $bch->update($request);
        return $bch;
    }

    public function delete($id)
    {
        $bch = Branch::find($id);
        $bch->delete();
    }

    
}