<?php

namespace App\View\Composers;

use App\Models\Settings;
use Illuminate\View\View;

class SeoComposer
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
            'metaTitle' => $this->settings->getMetaTitleValue(),
            'metaDescription' => $this->settings->getMetaDescriptionValue(),
            'keywords' => $this->settings->getKeywordsValue(),
            'email' => $this->settings->getEmailValue(),
            'whatsapp' => $this->settings->getWhatsappValue(),
            'facebookMessenger' => $this->settings->getFacebookMessengerValue(),
        ]);
    }
}
