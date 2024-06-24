<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingsController extends Controller
{

    /**
     * Show settings Page.
     *
     *  @return \Illuminate\View\View
     */
    public function show(): View
    {
        $this->checkPermission('settings_access');
        return view('admin.settings.show');
    }

    public function index()
    {
        $this->checkPermission('settings_access');
        $settings = Settings::all()->keyBy('id');
        
        return collect([
            'admin_email' => $settings[Settings::ADMIN_EMAIL]->value,
            'address' => $settings[Settings::ADDRESS]->value,
            'email' => $settings[Settings::EMAIL]->value,
            'phone' => $settings[Settings::PHONE]->value,
            'about' => $settings[Settings::ABOUT]->value,
            'gm_share_link' => $settings[Settings::GOOGLE_MAPS_SHARE_LINK]->value,
            'gm_iframe' => $settings[Settings::GOOGLE_MAPS_IFRAME]->value,
            'fb_url' => $settings[Settings::FACEBOOK_URL]->value,
            'insta_url' => $settings[Settings::INSTAGRAM_URL]->value,
            'tw_url' => $settings[Settings::TWITTER_URL]->value,
            'yt_url' => $settings[Settings::YOUTUBE_URL]->value,
            'tiktok_url' => $settings[Settings::TIKTOK_URL]->value,
            'whatsapp' => $settings[Settings::WHATSAPP]->value,
            'global_alert' => $settings[Settings::GLOBAL_ALERT]->value,
            'meta_title' => $settings[Settings::META_TITLE]->value,
            'meta_description' => $settings[Settings::META_DESCRIPTION]->value,
            'keywords' => $settings[Settings::KEYWORDS]->value,
            'google_play_url' => $settings[Settings::GOOGLE_PLAY_URL]->value,
            'app_store_url' => $settings[Settings::APP_STORE_URL]->value,
            'facebook_messenger' => $settings[Settings::FACEBOOK_MESSENGER]->value,
        ]);
    }

    /**
     * Update.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @param  string  $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $key): JsonResponse
    {
        $this->checkPermission('settings_edit');
        $request->validate([
            'value' => ['nullable', 'string'],
        ]);

        Settings::updateByKey($key, $request->value);
        return $this->jsonResponse();
    }
}
