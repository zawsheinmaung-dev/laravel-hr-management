<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use App\Models\Leavetype;
use App\Services\LeaveService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveController extends Controller
{
    public function __construct(protected LeaveService $leave_service)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave =$this->leave_service->get_index();
        return Inertia::render('Leave/Index',['leavetypes'=>$leave['leavetype'],'leaverequests'=>$leave['leaveRequest']]);
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
    public function store(LeaveRequest $request)
    {
        try {
            $this->leave_service->leave_store($request->validated());
            return redirect()->back()->with('success','Leave request successfully');
        } catch (\Exception $th) {
            return back()->withErrors(['leave'=>$th->getMessage()]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
