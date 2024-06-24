<?php

namespace App\View\Composers;

use App\Models\Settings;
use Illuminate\View\View;

class SocialMediaAndLinksComposer
{

    /**
     * The settings modal implementation.
     *
     * @var \App\Models\Settings
     */
    protected $settings;

    /**
     * Create a new seo composer.
     *
     * @param  \App\Models\Settings  $users
     * @return void
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'phoneValue' => $this->settings->getPhoneValue(),
            'emailValue' => $this->settings->getEmailValue(),
            'youtubeUrl' => $this->settings->getYouTubeUrlValue(),
            'facebookUrl' => $this->settings->getFacebookUrlValue(),
            'twitterUrl' => $this->settings->getTwitterUrlValue(),
            'instagramUrl' => $this->settings->getInstagramUrlValue(),
            'tiktokUrl' => $this->settings->getTikTokUrlValue(),
            // 'whatsapp' => $this->settings->getWhatsappValue(),
            'googlePlayUrl' => $this->settings->getGooglePlayUrlValue(),
            'appStoreUrl' => $this->settings->getAppStoreUrlValue(),
        ]);
    }
}
