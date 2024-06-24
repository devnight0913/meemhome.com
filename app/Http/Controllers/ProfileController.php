<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\ProfileInformationUpdateRequest;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $areas = Area::active()->orderBy('name', 'ASC')->get();
        return view('profile.show', [
            'user' => $request->user(),
            'areas' => $areas,
        ]);
    }


    public function update(ProfileInformationUpdateRequest $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;

        if (!is_null($request->phone)) {
            $user->phone = $request->phone;
            $user->phone_iso2 = $request->phone_iso2;
            $user->phone_dial_code = $request->phone_dial_code;
        }


        $user->area_id = $request->area;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->contact_email = $request->contact_email;

        if (!is_null($request->contact_phone)) {
            $user->contact_phone = $request->contact_phone;
            $user->contact_phone_iso2 = $request->contact_phone_iso2;
            $user->contact_phone_dial_code = $request->contact_phone_dial_code;
        }
        $user->address = $request->address;
        $user->save();


        if (isset($request->photo)) {
            $user->updateProfilePhoto($request->photo);
        }

        return Redirect::back()->with('success', 'Profile Information Update Successfully!');
    }

    public function destroy(DeleteAccountRequest $request)
    {
        $user = $request->user();
        if (!Hash::check($request->password, $user->password)) {
            return Redirect::back()->with('error', 'Invalid Password Provided!');
        }
        Auth::logout();
        $user->delete();
        return Redirect::route('login')->with('success', 'Account Deleted, Sorry to see you go 😢');
    }
}
