<?php

use App\Models\Application;
use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    private const COMPLETED_STATUS = "\u{041e}\u{0431}\u{0443}\u{0447}\u{0435}\u{043d}\u{0438}\u{0435} \u{0437}\u{0430}\u{0432}\u{0435}\u{0440}\u{0448}\u{0435}\u{043d}\u{043e}";

    public function getListeners(): array
    {
        return [
            'review-saved' => '$refresh',
        ];
    }

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
                'reviews' => fn ($query) => $query
                    ->where('user_id', auth()->id())
                    ->latest(),
            ])
            ->latest()
            ->get();

        return $this->view([
            'applications' => $applications,
            'completedStatus' => self::COMPLETED_STATUS,
            'statusLabels' => [
                Review::STATUS_PENDING => 'На модерации',
                Review::STATUS_PUBLISHED => 'Опубликован',
                Review::STATUS_REJECTED => 'Отклонен',
            ],
            'newStatus' => "\u{041d}\u{043e}\u{0432}\u{0430}\u{044f}",
            'rejectedStatus' => "\u{0417}\u{0430}\u{044f}\u{0432}\u{043a}\u{0430} \u{043e}\u{0442}\u{043a}\u{043b}\u{043e}\u{043d}\u{0435}\u{043d}\u{043d}\u{0430}",
        ])->layout('layouts::user', [
            'title' => 'Мои заявки',
        ]);
    }
};
