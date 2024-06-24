<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public const DEFAULT_STRING_LENGTH = 190;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(self::DEFAULT_STRING_LENGTH);
        Paginator::useBootstrapFive();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        $this->adminDirective();
    }


    protected function adminDirective()
    {
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });
    }
}
