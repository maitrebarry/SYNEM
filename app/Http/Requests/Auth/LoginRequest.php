<?php

namespace App\Http\Requests\Auth;

use App\Models\LoginAttempt;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 900;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(), self::LOCKOUT_SECONDS);
            RateLimiter::hit($this->ipThrottleKey(), self::LOCKOUT_SECONDS);
            $this->logAttempt('failed');

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        RateLimiter::clear($this->ipThrottleKey());
        $this->logAttempt('success');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (
            ! RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS)
            && ! RateLimiter::tooManyAttempts($this->ipThrottleKey(), self::MAX_ATTEMPTS)
        ) {
            return;
        }

        event(new Lockout($this));

        $this->logAttempt('blocked');

        $seconds = max(
            RateLimiter::availableIn($this->throttleKey()),
            RateLimiter::availableIn($this->ipThrottleKey()),
        );

        throw ValidationException::withMessages([
            'email' => 'Vous avez dépassé le nombre de tentatives autorisées. Veuillez réessayer dans quelques minutes.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }

    public function ipThrottleKey(): string
    {
        return 'ip|'.$this->ip();
    }

    private function logAttempt(string $status): void
    {
        if (! Schema::hasTable('login_attempts')) {
            return;
        }

        LoginAttempt::create([
            'ip_address' => $this->ip(),
            'email_tente' => Str::lower((string) $this->input('email')),
            'attempt_time' => now(),
            'status' => $status,
        ]);
    }
}
