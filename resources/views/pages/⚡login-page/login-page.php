<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $identifier = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'max:255', 'not_regex:/<[^>]*>/'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $validated = $this->validate();
        $identifier = trim($validated['identifier']);

        if (RateLimiter::tooManyAttempts($this->throttleKey($identifier), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($identifier));
            $this->addError('identifier', "Слишком много попыток входа. Повторите через {$seconds} сек.");
            return;
        }

        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::query()->where('email', Str::lower($identifier))->first()
            : User::query()->where('login', $identifier)->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey($identifier), 60);
            $this->addError(
                'identifier',
                filter_var($identifier, FILTER_VALIDATE_EMAIL)
                    ? 'Пользователь с таким email не найден.'
                    : 'Пользователь с таким логином не найден.'
            );
            return;
        }

        if (! Hash::check($validated['password'], $user->password)) {
            RateLimiter::hit($this->throttleKey($identifier), 60);
            $this->addError('password', 'Введен неверный пароль.');
            return;
        }

        Auth::login($user);
        session()->regenerate();
        RateLimiter::clear($this->throttleKey($identifier));

        if ($user->isAdmin()) {
            $this->redirectRoute('admin.applications', navigate: true);
            return;
        }

        if (Route::has('dashboard')) {
            $this->redirectRoute('dashboard', navigate: true);
            return;
        }

        $this->redirectRoute('home', navigate: true);
    }

    protected function throttleKey(string $identifier): string
    {
        return sprintf('login:%s|%s', Str::lower($identifier), request()->ip());
    }
};
