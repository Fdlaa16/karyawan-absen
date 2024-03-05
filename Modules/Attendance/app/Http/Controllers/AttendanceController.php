<?php

namespace Modules\Attendance\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Cuti;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $absens = Absen::where('date', Carbon::now()->format('Y-m-d'))->get();

        return view('attendance::index', [
            'absens' => $absens    
        ]);
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
    public function store(Request $request)
    {
        $cuti = Cuti::where('employee_id', $request->input('employee_id'))
        ->whereDate('start_at', '<=', Carbon::now()->format('Y-m-d'))
        ->whereDate('end_at', '>=', Carbon::now()->format('Y-m-d'))
        ->first();
        
        if ($cuti) {
            return redirect('/attendance-index')->with('gagal', 'Maaf, Anda sedang dalam masa cuti!');
        }
        
        $employee = Employee::find($request->input('employee_id'));
        
        if ($employee == null) {
            return redirect('/attendance-index')->with('gagal', 'Kamu sudah tidak terdata lagi disini.');
        }

        $absen = Absen::where([
            'employee_id' => $request->input('employee_id'),
            'date' => Carbon::now()->format('Y-m-d')
        ])->first();
    
        if ($absen) {
            return redirect('/attendance-index')->with('gagal', 'Absen sudah dilakukan hari ini!');
        }
    
        Absen::create([
            'employee_id' => $request->input('employee_id'),
            'date' => Carbon::now()->format('Y-m-d')
        ]);
    
        return redirect('/attendance-index')->with('success', 'Absen berhasil!');
    }
    
    
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('attendance::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('attendance::edit');
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
