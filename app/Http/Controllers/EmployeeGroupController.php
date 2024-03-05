<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\View;

class EmployeeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $search = $request->input('search');

        $employeeGroups = EmployeeGroup::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5);

        return view('dashboard.employee_group.index', [
            'employeeGroups' => $employeeGroups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.employee_group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = $request->toArray();
        $rules = [
            'name' => 'required'
        ];

        $message = [
            'name.requred' => 'Nama Group karyawan Harus Diisi',
        ];

        $validator = Validator::make($employee, $rules, $message);
        if($validator->fails()){
            return response()->json(array('errors' => $validator->messages()->toArray()), 422);
        }else{
            $employeeGroup = new EmployeeGroup();
            $employeeGroup->name = $request->input('name');
            $employeeGroup->save();
            
            return redirect()->route('employeeGroup.index')->with('success', 'Group karyawan berhasil dibuat.');
        }
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
    public function edit($id)
    {
        $employeeGroup = EmployeeGroup::findOrFail($id);
        return view('dashboard.employee_group.create', compact('employeeGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employeeGroup = EmployeeGroup::find($id);
        
        if(!$employeeGroup){
            return response()->json(['error' => 'Group karyawan Tidak Ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'Nama group karyawan Harus Diisi',
        ]);

          if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 422);
        }

        $employeeGroup->update([
            'name' => $request->input('name'),
        ]);
        
        return redirect()->route('employeeGroup.index')->with('success', 'Group karyawan berhasil diupdate.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employeeGroup = EmployeeGroup::find($id);
        $employeeGroup->delete();

        return redirect()->route('employeeGroup.index')->with('success', 'Group karyawan berhasil dihapus');
    }
}
