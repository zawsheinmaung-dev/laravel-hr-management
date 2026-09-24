<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryComponentRequest;
use App\Services\SalaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class SalaryComponentController extends Controller
{
    public function __construct(protected SalaryService $salary_service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Payroll/Index',['salarys'=>$this->salary_service->get_index()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Payroll/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryComponentRequest $request)
    {
        $data =$request->validated();
        $component=Arr::only($data,['name','type','description']);
        $structure=Arr::only($data,['structure_name','structure_description']);
        $items=$data['selected_items'];
        $this->salary_service->store_salary($component,$structure,$items);
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
        return Inertia::render('Payroll/Edit',['salary'=>$this->salary_service->edit_salary($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryComponentRequest $request, string $id)
    {
        $data =$request->validated();
        $component=Arr::only($data,['name','type','description']);
        $structure=Arr::only($data,['structure_id','structure_name','structure_description']);
        $items=$data['selected_items'];
        $this->salary_service->update_salary($id,$component,$structure,$items);
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
