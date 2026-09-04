<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{
    private $branch_service;
    public function __construct(BranchService $branch_service)
    {
        $this->branch_service=$branch_service;
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $branches =Branch::with('employees')->get();
        return Inertia::render('Branches/Index',['branches'=>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Branches/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        $bch =$this->branch_service->create($request->validated());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Branches/View',['branch'=>$this->branch_service->show($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Branches/Edit',['branches'=>$this->branch_service->edit($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, string $id)
    {
        $this->branch_service->update($request->validated(),$id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->branch_service->delete($id);
        return redirect()->back();
    }
}
