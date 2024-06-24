<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Show about page.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('about.show', [
            'about' => Settings::getAboutValue()
        ]);
    }
}
