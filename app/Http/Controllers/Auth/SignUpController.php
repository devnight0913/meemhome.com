<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class SignUpController extends Controller
{
    public function show()
    {
        return view("auth.signup");
    }
    public function create(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::USER,
        ]);
        Auth::login($user);
        $this->notifyUsers($user);
        return Redirect::route('home');
    }


    /**
     * Notify admins.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function notifyUsers(User $user)
    {
        $users = User::admin()->get();
        foreach ($users as $user) {
            $user->notify(new UserRegisteredNotification($user));
        }
    }
}
