<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeparmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $department_service)
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dep =$this->department_service->index();
        return Inertia::render('Deperment/Index',['departments'=>$dep['department'],'branches'=>$dep['branches']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dep= $this->department_service->create();
        return Inertia::render('Deperment/Create',['deparments'=>$dep['dep'],'branch'=>$dep['bch']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeparmentRequest $request)
    {
        $vali_dep =$request->validated();
        $this->department_service->store($vali_dep);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dep = $this->department_service->show($id);
        return Inertia::render('Deperment/View',['deparment'=>$dep]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dep = $this->department_service->edit($id);
        return Inertia::render('Deperment/Edit',['department'=>$dep['dep'],'departments'=>$dep['deps'],'branches'=>$dep['bch']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeparmentRequest $request, string $id)
    {
        $vali_dep=$request->validated();
        $this->department_service->update($vali_dep,$id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $this->department_service->destroy($id);
        return redirect()->back();
    }
}
