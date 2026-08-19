<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'mobile'        => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $user = auth()->user();
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => trim($request->first_name . ' ' . $request->last_name),
            'mobile'     => $request->mobile,
        ];

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $user->update($data);

        toastr()->closeButton(true)->addSuccess('Profile updated successfully.');
        return redirect()->route('profile');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user()->fresh();

        // Check current password FIRST before any other validation
        if (! Hash::check($request->current_password, $user->password)) {
            toastr()->closeButton(true)->addError('Current password is incorrect.');
            return redirect()->to(route('profile') . '?tab=password');
        }

        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        toastr()->closeButton(true)->addSuccess('Password changed successfully.');
        return redirect()->route('profile');
    }
}
