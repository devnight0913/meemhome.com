<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all()->keyBy('id');

        return collect([
            'address' => $settings[Settings::ADDRESS]->value,
            'email' => $settings[Settings::EMAIL]->value,
            'phone' => $settings[Settings::PHONE]->value,
            'about' => $settings[Settings::ABOUT]->value,
            'gm_share_link' => $settings[Settings::GOOGLE_MAPS_SHARE_LINK]->value,
            'fb_url' => $settings[Settings::FACEBOOK_URL]->value,
            'insta_url' => $settings[Settings::INSTAGRAM_URL]->value,
            'tw_url' => $settings[Settings::TWITTER_URL]->value,
            'yt_url' => $settings[Settings::YOUTUBE_URL]->value,
            'tiktok_url' => $settings[Settings::TIKTOK_URL]->value,
            'whatsapp' => $settings[Settings::WHATSAPP]->value,
            'global_alert' => $settings[Settings::GLOBAL_ALERT]->value,
        ]);
    }
}
