<?php

namespace App\View\Composers;

use App\Models\Settings;
use Illuminate\View\View;

class ContactComposer
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
            'address' => $this->settings->getAddressValue(),
            'gmShareLink' => $this->settings->getGoogleMapsShareLinkValue(),
            'phone' => $this->settings->getPhoneValue(),
            'email' => $this->settings->getEmailValue(),
        ]);
    }
}
