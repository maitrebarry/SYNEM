<?php

namespace App\Providers;

use App\Models\MilitantMessage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        if (! $this->app->runningInConsole()) {
            $this->ensureDefaultSuperAdminExists();
        }

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

    private function ensureDefaultSuperAdminExists(): void
    {
        if (!User::where('email', 'barrymoustapha908@gmail.com')->exists()) {
            User::create([
                'name' => 'Moustapha BARRY',
                'email' => 'barrymoustapha908@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]);
        }
    }
}
