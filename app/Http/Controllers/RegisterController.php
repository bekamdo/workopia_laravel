<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller{
    //desc Show register form
    //@route Get /register
    public function register():View{
        return view('auth.register');
    }

     //desc Show register form
    //@route Get /register
    public function store(Request $request):RedirectResponse{
        $validatedData = $request -> validate([
            'name' =>  'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ]);
        //harsh the password
        $validatedData['password'] = Hash::make($validatedData['password']);
        //create user
        $user = User::create($validatedData);

        return redirect() -> route('login') -> with('success','You are registered you can log in');
    }
}
