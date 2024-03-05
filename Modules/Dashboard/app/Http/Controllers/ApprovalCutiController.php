<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ApprovalCutiMail;
use App\Mail\RejectCutiMail;
use App\Models\Cuti;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ApprovalCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cutis = Cuti::query()
            ->when($search, function ($query, $search) {
                return $query->where('information', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhereHas('employeeGroup', function ($employeeGroup) use ($search){
                        $employeeGroup->where('name', 'like' , '%' . $search . '%');
                    })
                    ->orWhereHas('shift', function ($shift) use ($search){
                        $shift->where('name', 'like' , '%' . $search . '%');
                    })
                    ->orWhereHas('employee', function ($shift) use ($search){
                        $shift->where('name', 'like' , '%' . $search . '%')
                            ->orWhere('status', 'like' , '%' . $search . '%');
                    });
            })
            ->with([
                'employee'
                ]) 
            ->latest()
            ->paginate(5);

        return view('Dashboard::approval.index', compact('cutis'));
    }

    public function approve($id){
        $cuti = Cuti::with([
            'employee',
            'employee.user'
        ])->findOrFail($id);
        $employee = $cuti->employee;

        if($cuti){
            $cuti->update([
                'status' => 1
            ]);

            $category = $cuti->category;
            $start_at = $cuti->start_at;
            $end_at = $cuti->end_at;
            $information = $cuti->information;
            Mail::to($employee->user->email)->send(new ApprovalCutiMail($category, $start_at, $end_at, $information));
        }
        
        return redirect('/approval-cuti')->with('success', 'Cuti Diterima');;
    }

    public function reject($id){
        $cuti = Cuti::with([
            'employee',
            'employee.user'
        ])->findOrFail($id);
        $employee = $cuti->employee;

        if($cuti){
            $cuti->update([
                'status' => 2
            ]);

            $category = $cuti->category;
            $start_at = $cuti->start_at;
            $end_at = $cuti->end_at;
            $information = $cuti->information;
            Mail::to($employee->user->email)->send(new RejectCutiMail($category, $start_at, $end_at, $information));
        }

        return redirect('/approval-cuti')->with('error', 'Cuti Ditolak');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
