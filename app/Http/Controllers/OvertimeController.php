<?php

namespace App\Http\Controllers;

use App\Http\Requests\OvertimeRequest;
use App\Services\OvertimeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OvertimeController extends Controller
{
    public function __construct(protected OvertimeService $overtime_service)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overtimes =$this->overtime_service->index();
        return Inertia::render('Overtime/Index',['overtimes'=>$overtimes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OvertimeRequest $request)
    {
        try {
            $this->overtime_service->store($request->validated());
            return redirect()->back();
        } catch (\Exception $th) {
            return back()->withErrors(['att'=>$th->getMessage()]);
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->overtime_service->update($id,$request->status);
            return redirect()->back();
        } catch (\Exception $th) {
            return back()->withErrors(['ot'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
