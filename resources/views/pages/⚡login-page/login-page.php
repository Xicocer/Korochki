<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

new class extends Component
{
    public string $identifier = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'identifier' => ['required', 'not_regex:/<[^>]*>/'],
            'password' => ['required'],
        ];
    }

    public function authenticate(): void
    {
        $validated = $this->validate();
        $identifier = trim($validated['identifier']);

        $credentials = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? ['email' => $identifier, 'password' => $validated['password']]
            : ['login' => $identifier, 'password' => $validated['password']];

        if (! Auth::attempt($credentials)) {
            $this->addError('identifier', 'Неверный логин/email или пароль');
            return;
        }

        session()->regenerate();

        if (auth()->user()?->isAdmin()) {
            if (Route::has('admin.applications')) {
                $this->redirectRoute('admin.applications', navigate: true);
                return;
            }

            $this->redirect('/admin', navigate: true);
            return;
        }

        if (Route::has('dashboard')) {
            $this->redirectRoute('dashboard', navigate: true);
            return;
        }

        $this->redirectRoute('home', navigate: true);
    }
};
