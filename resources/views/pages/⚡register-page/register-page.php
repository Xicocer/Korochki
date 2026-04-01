<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

new class extends Component
{
    public string $login = '';
    public string $password = '';
    public string $full_name = '';
    public string $phone = '';
    public string $email = '';

    protected function rules(): array
    {
        return [
            'login' => ['required', 'regex:/^[A-Za-z0-9]{6,}$/', 'not_regex:/<[^>]*>/', 'unique:users,login'],
            'password' => ['required', 'min:8'],
            'full_name' => ['required', 'regex:/^[\p{Cyrillic}-]+\s+[\p{Cyrillic}-]+\s+[\p{Cyrillic}-]+$/u', 'not_regex:/<[^>]*>/u'],
            'phone' => ['required', 'regex:/^(\+7|8) \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
            'email' => ['required', 'email', 'not_regex:/<[^>]*>/', 'unique:users,email'],
        ];
    }

    protected function messages(): array
    {
        return [
            'login.regex' => 'Логин должен содержать только латинские буквы и цифры, минимум 6 символов.',
            'full_name.regex' => 'ФИО должно быть в формате: Фамилия Имя Отчество (только кириллица).',
        ];
    }

    public function updatedPhone(string $value): void
    {
        $formatted = $this->normalizePhone($value);

        if ($formatted !== $value) {
            $this->phone = $formatted;
        }
    }

    public function register()
    {
        $this->login = trim($this->login);
        $this->full_name = preg_replace('/\s+/', ' ', trim($this->full_name));
        $this->email = trim(strtolower($this->email));
        $this->phone = $this->normalizePhone($this->phone);
        $validated = $this->validate();
        $validated['login'] = $this->cleanText($validated['login']);
        $validated['full_name'] = $this->cleanText($validated['full_name']);
        $validated['email'] = trim(strtolower($validated['email']));

        User::create([
            'login' => $validated['login'],
            'password' => Hash::make($validated['password']),
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'role' => 'user',
        ]);

        if (Route::has('login')) {
            return $this->redirect(route('login', absolute: false), navigate: true);
        }

        return $this->redirect(route('home', absolute: false), navigate: true);
    }

    protected function normalizePhone(string $value): string
    {
        $raw = trim($value);
        $digits = preg_replace('/\D+/', '', $raw);

        if ($digits === '' || $digits === null) {
            return '';
        }

        $prefix = '+7';
        $national = '';

        if (str_starts_with($raw, '+')) {
            if (str_starts_with($digits, '7')) {
                $national = substr($digits, 1);
            } elseif (str_starts_with($digits, '8')) {
                $national = substr($digits, 1);
            } elseif (str_starts_with($digits, '9')) {
                $national = $digits;
            } else {
                $national = substr($digits, 1);
            }
        } elseif (str_starts_with($digits, '8')) {
            $prefix = '8';
            $national = substr($digits, 1);
        } elseif (str_starts_with($digits, '7')) {
            $national = substr($digits, 1);
        } elseif (str_starts_with($digits, '9')) {
            $national = $digits;
        } else {
            $national = substr($digits, 1);
        }

        $national = substr((string) $national, 0, 10);

        if ($national === '') {
            return $prefix;
        }

        $formatted = $prefix . ' (' . substr($national, 0, 3);

        if (strlen($national) >= 3) {
            $formatted .= ')';
        }

        if (strlen($national) > 3) {
            $formatted .= ' ' . substr($national, 3, 3);
        }

        if (strlen($national) > 6) {
            $formatted .= '-' . substr($national, 6, 2);
        }

        if (strlen($national) > 8) {
            $formatted .= '-' . substr($national, 8, 2);
        }

        return $formatted;
    }

    protected function cleanText(string $value): string
    {
        $value = strip_tags($value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim((string) $value);
    }
};
