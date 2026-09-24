<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxBracketRequest;
use App\Services\TaxService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxBracketController extends Controller
{
    public function __construct(protected TaxService $tax_service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Tax/Index',['tax_brackets'=>$this->tax_service->index_get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tax/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxBracketRequest $request)
    {
        $this->tax_service->store_tax($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Tax/View',['tax'=>$this->tax_service->tax_view($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Tax/Edit',['tax'=>$this->tax_service->tax_view($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxBracketRequest $request, string $id)
    {
        $this->tax_service->update_tax($id,$request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->tax_service->tax_delete($id);
        return redirect()->back();
    }
}
