<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryComponentRequest;
use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureItem;
use App\Services\SalaryService;
use App\Services\SalaryStructureService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SalaryStructureController extends Controller
{
    public function __construct(protected SalaryStructureService $salary_structure_service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('SalaryStructure/Index', ['salaries' => $this->salary_structure_service->get_index()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salary_comp = SalaryStructureItem::with('salaryComponent')->get();
        return Inertia::render('SalaryStructure/Create', ['salarycomp' => $salary_comp]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:salary_structures,name'],
            'description' => ['required', 'max:255', 'string'],
            'select_componet_item' => ['nullable', 'array']
        ]);
        $itmes = $data['select_componet_item'];
        unset($data['select_componet_item']);
        $this->salary_structure_service->store_items($data, $itmes);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salary_structure = SalaryStructure::with(
            'salaryStructureItems.salaryComponent'
        )->findOrFail($id);
        $salary_comp =SalaryStructureItem::with('salaryComponent')->get();
        return Inertia::render('SalaryStructure/Edit', ['salary' => $salary_structure,'salary_comp'=>$salary_comp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $vali_data = $request->validate([
            'name' => ['required', 'string', Rule::unique('salary_structures','name')->ignore($id)],
            'description' => ['required', 'max:255', 'string'],
            'select_componet_item' => ['required', 'array','min:1']
        ]);
        $structure=Arr::only($vali_data,['name','description']);
        $items =$vali_data['select_componet_item'];
        $this->salary_structure_service->update_comp($id,$structure,$items);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->salary_service->delete_salary($id);
        return redirect()->back();
    }
}
