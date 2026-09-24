<?php

namespace App\Http\Controllers;

use App\Services\PayrollService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayRollController extends Controller
{
    public function __construct(protected PayrollService $payroll)
    {
        
    }
    public function index()
    {
        return Inertia::render('Salary/Index',['payrollBatch'=>$this->payroll->get_index()]);
    }

    public function generate(Request $request)
    {
        try {
            $this->payroll::generate($request->month,$request->year);
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(['err'=>$th->getMessage()]);
        } 
    }

    public function show($id)
    {
        return Inertia::render('Salary/View',['payrollBatch'=>$this->payroll->get_show($id)]);
    }
}
