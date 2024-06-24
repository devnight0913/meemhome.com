<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Admin\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * Handle a login request to the application.
     *
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        if (
            method_exists($this, "hasTooManyLoginAttempts") &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::whereEmail($request->email)->first();
        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([
                "email" => [Lang::get("auth.failed")],
            ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $tokenObj = $user->createToken('accessToken');
        $token = $tokenObj->accessToken;

        return $this->jsonResponse([
            "access_token" => $token,
            "user" => $user,
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user('api');
        $user->token()->delete();

        return $this->jsonResponse([], Response::HTTP_NO_CONTENT);
    }


    /**
     * Handle a registration request for the application
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::USER,
        ]);

        $tokenObj = $user->createToken('accessToken');
        $token = $tokenObj->accessToken;

        $this->notifyAdmins($user);

        return $this->jsonResponse([
            "access_token" => $token,
            "user" => $user,
        ]);
    }


    /**
     * Notify admins.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function notifyAdmins(User $user)
    {
        $users = User::admin()->get();
        foreach ($users as $user) {
            $user->notify(new UserRegisteredNotification($user));
        }
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
