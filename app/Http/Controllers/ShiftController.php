<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftAssignRequest;
use App\Models\Shifts;
use App\Services\ShiftService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShiftController extends Controller
{
    public function __construct(protected ShiftService $shift_service)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shift =$this->shift_service->index();
        return Inertia::render('Shift/Index',['shifts'=>$shift]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Shift/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Shifts::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shift =$this->shift_service->edit($id);
        return Inertia::render('Shift/View',['shift'=>$shift['shift'],'assignments'=>$shift['assig']]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shift =$this->shift_service->edit($id);
        return Inertia::render('Shift/Edit',['shift'=>$shift['shift'],'assignments'=>$shift['assig']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->shift_service->shift_delete($id);
        } catch (\Exception $th) {
            return back()->withErrors(['shift'=> $th->getMessage()]);
        }
    }

    public function shift_assign(ShiftAssignRequest $request)
    {
        try {
            $this->shift_service->shift_assign($request->validated());
        } catch (\Exception $th) {
            return back()->withErrors(['employee_id'=> $th->getMessage()]);
        }
    }

    public function shift_assign_delete($id)
    {
        try {
            $this->shift_service->shift_assign_delete($id);
            return back();
        } catch (\Exception $th) {
            return back()->withErrors(['shift'=>$th->getMessage()]);
        }
    }
}
