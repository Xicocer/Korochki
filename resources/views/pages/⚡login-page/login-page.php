<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public string $login = '';
    public string $password = '';

    protected function rules(): array
    {
        return [
            'login' => ['required'],
            'password' => ['required'],
        ];
    }

    public function login()
    {
        $credentials = $this->validate();

        if (! Auth::attempt($credentials)) {
            $this->addError('login', 'Неверный логин или пароль');
            return;
        }

        session()->regenerate();

        if (auth()->user()?->isAdmin()) {
            return $this->redirect('/admin', navigate: true);
        }

        return $this->redirect('/dashboard', navigate: true);
    }
};
