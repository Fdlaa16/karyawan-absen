<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeGroup;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\View;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $search = $request->input('search');

        $shifts = Shift::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5);

        return view('Dashboard::shift.index', [
            'shifts' => $shifts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard::shift.create');
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
            'name.requred' => 'Nama shift Harus Diisi',
        ];

        $validator = Validator::make($employee, $rules, $message);
        if($validator->fails()){
            return response()->json(array('errors' => $validator->messages()->toArray()), 422);
        }else{
            $shift = new Shift();
            $shift->name = $request->input('name');
            $shift->save();
            
            return redirect()->route('shift.index')->with('success', 'Shift berhasil dibuat.');
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
        $shift = Shift::findOrFail($id);
        return view('Dashboard::shift.create', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);
        
        if(!$shift){
            return response()->json(['error' => 'Shift Tidak Ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'Nama Shift Harus Diisi',
        ]);

          if($validator->fails()){
            return response()->json(['error' => $validator->messages()], 422);
        }

        $shift->update([
            'name' => $request->input('name'),
        ]);
        
        return redirect()->route('shift.index')->with('success', 'Shift berhasil diupdate.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shift = Shift::find($id);
        $shift->delete();

        return redirect()->route('shift.index')->with('success', 'Shift berhasil dihapus');
    }
}
