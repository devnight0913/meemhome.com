<?php

namespace App\Providers;

use App\View\Composers\CatalogComposer;
use App\View\Composers\ContactComposer;
use App\View\Composers\SeoComposer;
use App\View\Composers\SocialMediaAndLinksComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(["layouts.navbar", "home.show"], CatalogComposer::class);
        View::composer("layouts.app", SeoComposer::class);
        View::composer("layouts.footer", ContactComposer::class);
        View::composer(["layouts.footer", "layouts.info-navbar"], SocialMediaAndLinksComposer::class);
    }
}
