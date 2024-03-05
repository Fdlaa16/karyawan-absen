<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Models\Shift;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $search = $request->input('search');

        $employees = Employee::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('employeeGroup', function ($employeeGroup) use ($search){
                        $employeeGroup->where('name', 'like' , '%' . $search . '%');
                    })
                    ->orWhereHas('shift', function ($shift) use ($search){
                        $shift->where('name', 'like' , '%' . $search . '%');
                    });
            })
            ->with('employeeGroup', 'shift') 
            ->latest()
            ->paginate(5);

        $employeeQR = [];

        foreach ($employees as $employee) {
            $employeeQR[$employee->id] = QrCode::size(100)->generate(route('employee.edit', $employee));
        }
        return view('dashboard.employee.index', [
            'employees' => $employees,
            'employeeQR' => $employeeQR
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shifts = Shift::all();
        $employeeGroups = EmployeeGroup::all();
        return view('dashboard.employee.create', [
            'shifts' => $shifts,
            'employeeGroups' => $employeeGroups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = $request->toArray();
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'address' => 'required',
            'shift' => 'required',
            'employeeGroup' => 'required',
            'status' => 'required',
        ];

        $message = [
            'email.required' => 'Email employee Harus Diisi',
            'password.required' => 'Password Harus Diisi',
            'name.requred' => 'Nama Karyawan Harus Diisi',
            'date_of_birth.requred' => 'Tanggal Lahir Harus Diisi',
            'place_of_birth.requred' => 'Tempat Lahir Harus Diisi',
            'address.required' => 'Alamat Harus Diisi',
            'shift.requred' => 'Shift Harus Diisi',
            'employeeGroup.required' => 'Grup Karyawan Harus Diisi',
            'status.requred' => 'Status Karyawan Harus Diisi',
        ];

        $validator = Validator::make($employee, $rules, $message);
        if($validator->fails()){
            return response()->json(array('errors' => $validator->messages()->toArray()), 422);
        }else{
            $user = new User();
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            $employee = new Employee();
            $employee->name = $request->input('name');
            $employee->user_id = $user->id;
            $employee->date_of_birth = $request->input('date_of_birth');
            $employee->place_of_birth = $request->input('place_of_birth');
            $employee->address = $request->input('address');
            $employee->shift_id = $request->input('shift');
            $employee->employee_group_id = $request->input('employeeGroup');
            $employee->status = $request->input('status');
            $employee->save();    

            return redirect()->route('employee.index')->with('success', 'Karyawan berhasil dibuat.');
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
        $employee = Employee::findOrFail($id);

        $employeeQr = QrCode::size(100)->generate(route('employee.edit', $employee));
        $shifts = Shift::all();
        $employeeGroups = EmployeeGroup::all();
        return view('dashboard.employee.create', compact('employee', 'shifts', 'employeeGroups', 'employeeQr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        
        if(!$employee){
            return response()->json(['error' => 'Karyawan Tidak Ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'address' => 'required',
            'shift' => 'required',
            'employeeGroup' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nama Karyawan Harus Diisi',
            'date_of_birth.required' => 'Tanggal Lahir Harus Diisi',
            'place_of_birth.required' => 'Tempat Lahir Harus Diisi',
            'address.required' => 'Alamat Harus Diisi',
            'shift.required' => 'Shift Harus Diisi',
            'employeeGroup.required' => 'Grup Karyawan Harus Diisi',
            'status.required' => 'Status Karyawan Harus Diisi',
        ]);

          if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 422);
        }

        $employee->update([
            'name' => $request->input('name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'place_of_birth' => $request->input('place_of_birth'),
            'address' => $request->input('address'),
            'shift_id' => $request->input('shift'),
            'employee_group_id' => $request->input('employeeGroup'),  // Perubahan di sini
            'status' => $request->input('status'),
        ]);
        
        return redirect()->route('employee.index')->with('success', 'Karyawan berhasil diupdate.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->user()->delete();
        $employee->delete();

        return redirect('/employee')->with('success', 'Karyawan berhasil dihapus');
    }
}
