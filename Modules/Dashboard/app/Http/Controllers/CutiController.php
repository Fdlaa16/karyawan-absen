<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CutiController extends Controller
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

        return view('Dashboard::cuti.index', compact('cutis'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('dashboard::cuti.create', [
            'employees' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = $request->toArray();
        $rules = [
            'employee_id' => 'required',
            'category' => 'required',
            'information' => 'required',
            'start_at' => 'required|date',
            'end_at' => [
                'required',
                'date',
                'after_or_equal:start_at', 
            ],
        ];
    
        $messages = [
            'employee_id.required' => 'Karyawan Harus Diisi',
            'category.required' => 'Kategori Harus Diisi',
            'information.required' => 'Keterangan Harus Diisi',
            'start_at.required' => 'Tanggal mulai Harus Diisi',
            'end_at.required' => 'Tanggal Berakhir Harus Diisi',
            'end_at.after_or_equal' => 'Tanggal Berakhir harus setelah atau sama dengan Tanggal Mulai',
        ];
    
        $validator = Validator::make($employee, $rules, $messages);
    
        if ($validator->fails()) {
            $errors = $validator->messages()->toArray();
            return redirect()->route('cuti.create')
                ->withErrors($errors)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian formulir. Silakan periksa kembali.');
        }
    
        // Check overlapping leave
        $existingLeave = Cuti::where('employee_id', $request->input('employee_id'))
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_at', [$request->input('start_at'), $request->input('end_at')])
                    ->orWhereBetween('end_at', [$request->input('start_at'), $request->input('end_at')]);
            })
            ->exists();
    
        if ($existingLeave) {
            return redirect()->route('cuti.index')
                ->withInput()
                ->with('error', 'Cuti dengan rentang waktu yang tumpang tindih sudah ada.');
        }
    
        $cuti = new Cuti();
        $cuti->employee_id = $request->input('employee_id');
        $cuti->category = $request->input('category');
        $cuti->information = $request->input('information');
        $cuti->start_at = $request->input('start_at');
        $cuti->end_at = $request->input('end_at');
        $cuti->save();  
    
        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dibuat.');
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
        $cutis = Cuti::all();
        return view('dashboard.employee.create', compact('cutis'));
   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = $request->all();
        $rules = [
            'employee_id' => 'required',
            'category' => 'required',
            'information' => 'required',
            'start_at' => 'required|date',
            'end_at' => [
                'required',
                'date',
                'after_or_equal:start_at', 
            ],
        ];

        $messages = [
            'employee_id.required' => 'Karyawan Harus Diisi',
            'category.required' => 'Kategori Harus Diisi',
            'information.required' => 'Keterangan Harus Diisi',
            'start_at.required' => 'Tanggal mulai Harus Diisi',
            'end_at.required' => 'Tanggal Berakhir Harus Diisi',
            'end_at.after_or_equal' => 'Tanggal Berakhir harus setelah atau sama dengan Tanggal Mulai',
        ];

        $validator = Validator::make($employee, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('cuti.edit', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian formulir. Silakan periksa kembali.');
        } else {
            $cuti = Cuti::find($id);
            $cuti->employee_id = $request->input('employee_id');
            $cuti->category = $request->input('category');
            $cuti->information = $request->input('information');
            $cuti->start_at = $request->input('start_at');
            $cuti->end_at = $request->input('end_at');
            $cuti->save();  

            return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
