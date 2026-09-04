<?php
namespace App\Services;

use App\Helpers\CodeGenerator;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\Cache;

class DepartmentService 
{
    public function index()
    {
       $dep=Cache::remember('department',
       now()->addMinutes(5),
       fn () =>Department::with('branch')->withCount('employees')->get(),
       ); 
       
       $bch =Cache::remember('branches',now()->addMinutes(5),fn()=>Branch::all());

       return [
        'department'=>$dep,
        'branches'=>$bch
       ];
    }

    public function create()
    {
        $dep =Department::with('parentDep','headEmp','employees')->get();
        $bch=Branch::all();
        return ['dep'=>$dep,'bch'=>$bch];
    }

    public function store($dep_data)
    {
        $this->clear_cache();
        $dep=Department::create($dep_data);
        $dep->code =CodeGenerator::generate('DEP-',$dep->id,3);
        $dep->save();
        return $dep;
    }

    public function show($id)
    {
        $dep =Department::with('parentDep','headEmp')->find($id);
        return $dep;
    }

    public function edit($id)
    {
        $dep =Department::with('parentDep','headEmp')->find($id);
        $deps =Department::all();
        $bch =Branch::all();
        return ['dep'=>$dep,'deps'=>$deps,'bch'=>$bch];
    }

    public function update(array $dep_data,$id)
    {
        $this->clear_cache();
        $dep =Department::find($id);
        $dep->update($dep_data);
        return $dep;
    }

    public function destroy($id)
    {
        $this->clear_cache();
        $dep =Department::find($id);
        if($dep->employees()->exists())
            {
                throw new Exception('In This department can\'t delete');
            }
        $dep->delete();
        return;
    }

    public function clear_cache()
    {
        Cache::forget('department');
        Cache::forget('branches');
    }
}