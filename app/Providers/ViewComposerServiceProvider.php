<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Topbar;
use App\Models\Footer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share topbar and footer data with site views only
        View::composer('site-web.*', function ($view) {
            $view->with('sharedTopbar', Topbar::first());
            $view->with('sharedFooter', Footer::first());
        });
    }
}
