<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view("auth.forgot-password");
    }

    public function sendResetEmailLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'string', 'max:50']
        ]);
        $response = Password::broker()->sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? Redirect::back()->with('success', trans($response))
            : Redirect::back()->with('error', trans($response));
    }
}
