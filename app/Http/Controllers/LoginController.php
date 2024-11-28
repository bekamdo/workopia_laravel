<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller{
    //@desc Show login form
    //@route GET /login
    public function login():View{
        return view('auth.login');
    }

    //@desc Authenticate User
    //@route Post / login
    public function authenticate(Request $request):RedirectResponse{
        $credentials = $request -> validate([
            
            'email' => 'required|string|email|max:100',
            'password' => 'required|string',

        ]);

      // Attempt to authenticate the user
      if(Auth::attempt($credentials)){
        //Regenerate the session to prevent fixation attacks
        $request -> session() -> regenerate();
        return redirect() -> intended(route('home')) -> with('success',"You are now logged in");

      }
      //if auth fails, redirect back with error
      return back() -> withErrors([
        'email' => 'The provided credentials do not match our records'
      ]) -> onlyInput('email');

    }

       //@desc logout user
    //@route POST /logout
    public function logout(Request $request):RedirectResponse{
       Auth::logout();
       $request -> session() -> invalidate();
       $request -> session() -> regenerateToken();
       return redirect("/");
    }

 
}