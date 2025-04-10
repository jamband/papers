<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property string|null $email
 * @property string|null $password
 * @property bool|null $remember
 */
class LoginRequest extends FormRequest
{
    private AuthManager $auth;
    private RateLimiter $rateLimiter;
    private Dispatcher $event;

    private const int MAX_ATTEMPTS = 5;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(
        AuthManager $auth,
        RateLimiter $rateLimiter,
        Dispatcher $event,
    ): array {
        $this->auth = $auth;
        $this->rateLimiter = $rateLimiter;
        $this->event = $event;

        return [
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!$this->auth->attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        )) {
            $this->rateLimiter->hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $this->rateLimiter->clear($this->throttleKey());
    }

    private function ensureIsNotRateLimited(): void
    {
        if ($this->rateLimiter->tooManyAttempts(
            $this->throttleKey(),
            self::MAX_ATTEMPTS
        )) {
            $this->event->dispatch(new Lockout($this));
            $seconds = $this->rateLimiter->availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    private function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
