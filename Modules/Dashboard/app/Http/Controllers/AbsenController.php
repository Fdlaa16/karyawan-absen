<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Employee;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Dashboard::absen.index');
    }

    public function laporanIndex(Request $request){
        $year = 2024;
        $startMonth = 1;
        $endMonth = 12;
    
        $employees = Employee::with('absens', 'cuti')->get();
    
        return view('Dashboard::laporan.index', [
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
            'employees' => $employees,
            'selectedYear' => $year,
        ]);
    }

    public function search(Request $request)
    {
        $year = $request->input('year');
        $startMonth = $request->input('startMonth');
        $endMonth = $request->input('endMonth');

        $employees = Employee::with('absens', 'cuti')->get();
       
        return view('Dashboard::laporan.index', [
            'employees' => $employees,
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
            'selectedYear' => $year,
        ]);
    }

    public function download(Request $request)
    {
        $year = $request->input('year');
        $startMonth = $request->input('startMonth');
        $endMonth = $request->input('endMonth');

        $employees = Employee::with('absens')->get();

        $pdf = new Dompdf();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $pdf->setOptions($options);

        $html = view('Dashboard::laporan.download', [
            'employees' => $employees,
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
            'selectedYear' => $year,
            ])->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A3', 'portrait');
        $pdf->render();

        $startMonth = str::slug($startMonth);
        $endMonth = Str::slug($endMonth);
            
        $file_name = "Absensi_karyawan.pdf";
        return $pdf->stream($file_name);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard::absen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
