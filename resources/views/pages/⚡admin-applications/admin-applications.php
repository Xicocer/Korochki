<?php

use App\Models\Application;
use Livewire\Component;

new class extends Component
{
    public array $statuses = [
        'Новая',
        'Идет обучение',
        'Обучение завершено',
        'Заявка отклоненна',
    ];

    public array $deletableStatuses = [
        'Обучение завершено',
        'Заявка отклоненна',
    ];

    public function mount(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    public function updateStatus(int $applicationId, string $newStatus): void
    {
        if (! in_array($newStatus, $this->statuses, true)) {
            session()->flash('error', 'Недопустимый статус заявки');
            return;
        }

        $application = Application::query()->find($applicationId);

        if (! $application) {
            session()->flash('error', 'Заявка не найдена');
            return;
        }

        $application->status = $newStatus;
        $application->save();

        session()->flash('success', "Статус заявки #{$application->id} обновлен");
    }

    public function deleteApplication(int $applicationId): void
    {
        $application = Application::query()->find($applicationId);

        if (! $application) {
            session()->flash('error', 'Заявка не найдена');
            return;
        }

        if (! in_array($application->status, $this->deletableStatuses, true)) {
            session()->flash('error', 'Удалять можно только отклоненные или завершенные заявки');
            return;
        }

        $application->delete();

        session()->flash('success', "Заявка #{$applicationId} удалена");
    }

    public function render()
    {
        return $this->view([
            'applications' => Application::query()
                ->with(['user:id,full_name', 'course:id,title'])
                ->latest()
                ->get(),
        ])->layout('layouts::admin', [
            'title' => 'Заявки пользователей',
        ]);
    }
};
