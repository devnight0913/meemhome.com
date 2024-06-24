<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    use ThrottlesLogins;


    /**
     * Show Login form.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        $user = User::where("email", $request->email)->admin()->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, true);
                $request->session()->regenerate();
                return $this->jsonResponse();
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

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(): string
    {
        return 'email';
    }
}
