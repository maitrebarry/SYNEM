<?php

namespace App\Providers;

use App\Models\MilitantMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.administration', function ($view) {
            $notifications = MilitantMessage::with('militant')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $view->with('militantNotifications', $notifications)
                ->with('pendingMilitantMessagesCount', MilitantMessage::where('status', 'pending')->count());
        });
    }
}
