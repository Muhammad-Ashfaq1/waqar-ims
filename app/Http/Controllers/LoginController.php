<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function Authenticate(Request $request)
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            toastr()->error('Enter email or password in correct format');

            return redirect()->route('login')->withInput($request->only('email', 'remember'));
        }

        $remember = $request->boolean('remember');

        if (Auth::attempt($request->only('email', 'password'), $remember)) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                toastr()->error('Your account is inactive. Contact Super Admin.');

                return redirect()->route('login')->withInput($request->only('email', 'remember'));
            }

            $request->session()->regenerate();
            toastr()->closeButton(true)->addSuccess('Welcome to Inventory Management System');

            return redirect()->intended('dashboard');
        }

        toastr()->error('Email or Password is incorrect.');

        return redirect()->route('login')->withInput($request->only('email', 'remember'));
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
