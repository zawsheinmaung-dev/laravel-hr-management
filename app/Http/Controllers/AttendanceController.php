<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\AtendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(protected AtendanceService $attendace_service)
    {
        
    }
    public function index()
    {
        $att =$this->attendace_service->index();
        return Inertia::render('Attendace/Index',['attendances'=>$att]);
    }

    public function show( $id)
    {
        return Inertia::render('Attendace/View',['attendance'=>$this->attendace_service->show($id)]);
    }

    public function check_in(Request $request)
    {
        try {
            $this->attendace_service->check_in($request->ip());
            return redirect()->back();
        } catch (\Exception $th) {
            return redirect()->back()->withErrors(['shift'=>$th->getMessage()]);
        }
    }

    public function check_out(Request $request)
    {
       try {
             $this->attendace_service->check_out();
             return redirect()->back();
       } catch (\Exception $th) {
         return back()->withErrors(['check_out'=>$th->getMessage()]);
       }
    }
}
