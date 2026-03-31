<?php

use App\Models\Application;
use Livewire\Component;

new class extends Component
{
    public const COMPLETED_STATUS = 'Обучение завершено';

    public function openReviewModal(int $applicationId): void
    {
        $isCompletedApplication = Application::query()
            ->whereKey($applicationId)
            ->where('user_id', auth()->id())
            ->where('status', self::COMPLETED_STATUS)
            ->exists();

        if (! $isCompletedApplication) {
            return;
        }

        $this->dispatch('open-review-modal', applicationId: $applicationId);
    }

    public function render()
    {
        $applications = auth()->user()
            ->applications()
            ->with([
                'course',
                'reviews' => fn ($query) => $query->where('user_id', auth()->id()),
            ])
            ->latest()
            ->get();

        return $this->view([
            'applications' => $applications,
            'completedStatus' => self::COMPLETED_STATUS,
        ])->layout('layouts::user', [
            'title' => 'Личный кабинет',
        ]);
    }
};
