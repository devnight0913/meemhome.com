<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ThrottlesLogins;
    public function show()
    {
        return view("auth.login");
    }

    public function authenticate(LoginRequest $request)
    {


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::where("email", $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, true);
                $request->session()->regenerate();
                if($request->has("next")){
                    return Redirect::route($request->next);
                }
                return Redirect::route("home");
            }
        }


        // if (Auth::attempt($request->only([$this->username(), 'password']), true)) {
        //     /** @var \App\Models\User */
        //     $user = Auth::user();
        //     $request->session()->regenerate();
        //     return $this->jsonResponse();
        // }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.failed')],
        ]);
    }

    public function username(): string
    {
        return 'email';
    }
}
