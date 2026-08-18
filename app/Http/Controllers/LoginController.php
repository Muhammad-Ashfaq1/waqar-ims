<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    function Authenticate(Request $request){

       $validator = Validator::make($request->all(), [
            'email' =>'required|email',
            'password' => 'required|min:6'
            ]);
        if ($validator->passes()){
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
                toastr()->closeButton(true)->addSuccess('Welcome to Inventory Management System');
                return redirect('dashboard');
            }
            else{
                toastr()->error('Email or Password is incorrect.');
                return redirect()->route('login');
            }
        }
        else{
            toastr()->error('Enter email or password in correct format');
            return redirect()->route('login');
        }

    }
    function Logout(){
        Auth::logout();
        return redirect()->route('login');
    }

}
