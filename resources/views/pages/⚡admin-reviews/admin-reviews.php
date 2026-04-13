<?php

use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    public string $statusFilter = Review::STATUS_PENDING;

    public array $statuses = [
        Review::STATUS_PENDING,
        Review::STATUS_PUBLISHED,
        Review::STATUS_REJECTED,
    ];

    public function setStatusFilter(string $status): void
    {
        if ($status !== 'all' && ! in_array($status, $this->statuses, true)) {
            return;
        }

        $this->statusFilter = $status;
    }

    public function publish(int $reviewId): void
    {
        $review = Review::query()->find($reviewId);

        if (! $review) {
            session()->flash('error', 'Отзыв не найден.');
            return;
        }

        $review->update([
            'status' => Review::STATUS_PUBLISHED,
            'moderation_note' => null,
            'moderated_at' => now(),
        ]);

        session()->flash('success', 'Отзыв опубликован.');
    }

    public function reject(int $reviewId): void
    {
        $review = Review::query()->find($reviewId);

        if (! $review) {
            session()->flash('error', 'Отзыв не найден.');
            return;
        }

        $review->update([
            'status' => Review::STATUS_REJECTED,
            'moderation_note' => 'Отклонено администратором.',
            'moderated_at' => now(),
        ]);

        session()->flash('success', 'Отзыв отклонен.');
    }

    public function render()
    {
        $query = Review::query()
            ->with(['user:id,full_name,login', 'application.course:id,title'])
            ->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $statusTotals = Review::query()
            ->pluck('status')
            ->countBy();

        return $this->view([
            'reviews' => $query->get(),
            'statusTotals' => $statusTotals,
            'totalReviews' => $statusTotals->sum(),
            'labels' => [
                Review::STATUS_PENDING => 'На модерации',
                Review::STATUS_PUBLISHED => 'Опубликован',
                Review::STATUS_REJECTED => 'Отклонен',
            ],
        ])->layout('layouts::admin', [
            'title' => 'Модерация отзывов',
        ]);
    }
};
