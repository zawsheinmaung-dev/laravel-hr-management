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
            $this->payroll->generate($request->month,$request->year);
            return redirect()->back();
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(['err'=>$th->getMessage()]);
        } 
    }

    public function approved($id)
    {
        try {
            $this->payroll->payroll_approved($id);
            return redirect()->back();
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(['err',$th->getMessage()]);
        }
    }

    public function isPaid($id)
    {
        try {
            $this->payroll->payroll_paid($id);
            return redirect()->back();
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(['err',$th->getMessage()]);
        }
    }

    public function employeeView($id)
    {
        return Inertia::render('Salary/EmpSalary',['payroll'=>$this->payroll->employeeView($id)]);
    }

    public function payslip($id)
    {
        return Inertia::render('Salary/Payslip',['payslip'=>$this->payroll->payslipView($id)]);
    }

    public function show($id)
    {
        return Inertia::render('Salary/View',['payrollBatch'=>$this->payroll->get_show($id)]);
    }
}
