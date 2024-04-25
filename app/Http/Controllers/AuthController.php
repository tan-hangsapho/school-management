<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public  function index(){
        return view('login');
    }




    public function login(Request $request){
       $credentials= $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|max:12'
        ]);
        
      
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
   ]);
    }


    public function destroy()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }

}
