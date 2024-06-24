<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{

    public function show(){
        return view("password.show");
    }

    public function update(PasswordUpdateRequest $request)
    {
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Invalid Password Provided!'
            ]);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::back()->with('success', 'Password Updated Successfully');
    }
}
