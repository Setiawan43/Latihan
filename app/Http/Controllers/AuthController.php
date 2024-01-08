<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use resources\views\profile;

class AuthController extends Controller
{
    public function register(){
        return view('auth/register');
    }

    public function registerSave(Request $request){
        Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ])->validate();

        user::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('login');
    }

    public function login(){
        return view('auth/login');
    }

    public function loginAction(Request $request){
        Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ])->validate();

        if(!Auth::attempt($request->only ('email', 'password'),$request->boolean('Remember'))){
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function profile(){
        return view('profile');
    }

    public function arif_data(){
        return view('arif_data');
    }
    
}