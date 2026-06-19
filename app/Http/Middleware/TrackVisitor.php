<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    private const COOKIE_NAME = 'synem_visitor_tracked';
    private const COOKIE_LIFETIME_MINUTES = 1440;

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldTrack($request) && Schema::hasTable('visitors') && ! $request->cookies->has(self::COOKIE_NAME)) {
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'visited_at' => now(),
            ]);

            Cookie::queue(Cookie::make(
                self::COOKIE_NAME,
                (string) now()->timestamp,
                self::COOKIE_LIFETIME_MINUTES,
            ));
        }

        return $next($request);
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return false;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        if ($request->is('administration') || $request->is('administration/*')) {
            return false;
        }

        if ($request->is('connexion') || $request->is('login') || $request->is('register')) {
            return false;
        }

        if ($request->is('forgot-password') || $request->is('reset-password/*') || $request->is('verify-email/*')) {
            return false;
        }

        if ($request->is('test-*') || $request->is('up')) {
            return false;
        }

        return true;
    }
}