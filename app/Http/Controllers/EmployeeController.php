<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    private $emp_service;
    public function __construct(EmployeeService $emp_service)
    {
        $this->emp_service=$emp_service;
    }
    /**
     * Display a listing of the resource.
     */

    public function search(Request $request)
    {
        $emp =$this->emp_service->search($request->search);
        return response()->json(['employees'=>$emp]);
    }

    public function index()
    {
        $employees = Employee::with('department')->get();
        return Inertia::render('Employee/Index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Employee/Create',['department'=>Department::with('headEmp')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request) 
    {
        $vali_emp=$request->validated();
        $this->emp_service->create_user_employee($vali_emp);
        return redirect()->back()->with('success', 'Employee created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('user',
            'department',
            'position',
            'branch',
            'salaryStructure')->find($id);
        return Inertia::render('Employee/View', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $emp =$this->emp_service->edit_emp($id);
        return Inertia::render('Employee/Edit', ['employee' =>$emp['employee'],'department'=>$emp['department'],'position'=>$emp['position'],'branch'=>$emp['branch']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $validated = $request->validated();
        $this->emp_service->emp_update($id,$validated);
        return redirect()->back();
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->emp_service->delete_user_emp($id);
        return redirect()->back()->with('success', 'Employee deleted successfully.');
    }
    
}
