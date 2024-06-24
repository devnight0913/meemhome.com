<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfilePhotoController extends Controller
{
    public function destroy(): RedirectResponse
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $user->deleteProfilePhoto();
        return Redirect::back()->with('success', 'Profile Photo Removed.');
    }
}
