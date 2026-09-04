<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Services\PositionService;
use Inertia\Inertia;

class PositionController extends Controller
{
    public function __construct(protected PositionService $position_service)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions =$this->position_service->index();
        return Inertia::render('Position/Index',['departments'=>$positions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dep = $this->position_service->create();
        return Inertia::render('Position/Create',['departments'=>$dep,'levels'=>config('hr.levels')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        return $this->position_service->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pos = $this->position_service->show($id);
        return Inertia::render('Position/View',['position'=>$pos]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pos =$this->position_service->edit($id);
        return Inertia::render('Position/Edit',['position'=>$pos['pos'],'departments'=>$pos['dep'],'levels'=>config('hr.levels')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, string $id)
    {
        $vali_data =$request->validated();
        $this->position_service->update($vali_data,$id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->position_service->delete($id);
        return redirect()->back();
    }
}
