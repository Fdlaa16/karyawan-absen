<?php

namespace Modules\Dashboard\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function create()
    {
        return view('Dashboard::login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email'=>'required|email',
            'password'=>'required' 
        ]);
        
        if(Auth::attempt($attributes)){
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Gagal Login, Data user tidak ditemukan');
    }
    
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'Kamu Berhasil Logout.']);
    }

    public function profile(){
        return view('Dashboard::profile');
    }

    public function update(Request $request){
        $user = Auth::user()->id;

        if($request["password"] != $request["password2"]){
            return redirect('/user-profile')->with('error', 'Password Tidak Sama');
        }

        User::where('id',Auth::user()->id)
            ->update([
            'password' => bcrypt($request['password'])
        ]);
        
        return redirect('/profile')->with('success', 'Password Berhasil Diubah');
 
    }
}
