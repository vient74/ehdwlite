<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended(route('home'));
           // return redirect('/home');
        }else{
            return view('auth/login');
        }
    }

    public function actionlogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect()->intended(route('home'));
            // return redirect('home');
        }else{
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}