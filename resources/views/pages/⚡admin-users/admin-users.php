<?php

use App\Models\User;
use Livewire\Component;

new class extends Component
{
    public function mount(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    public function deleteUser(int $userId): void
    {
        $authUser = auth()->user();
        $user = User::query()->find($userId);

        if (! $user) {
            session()->flash('error', 'Пользователь не найден');
            return;
        }

        if ($user->id === $authUser?->id || $user->role === 'admin') {
            session()->flash('error', 'Этого пользователя удалить нельзя');
            return;
        }

        $user->delete();

        session()->flash('success', 'Пользователь удален');
    }

    public function render()
    {
        return $this->view([
            'users' => User::query()
                ->where('role', '!=', 'admin')
                ->orderBy('id')
                ->get(['id', 'login', 'full_name', 'email', 'phone', 'role']),
        ])->layout('layouts::admin', [
            'title' => 'Управление пользователями',
        ]);
    }
};
