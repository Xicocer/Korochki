<?php

use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'reviews' => Review::query()
                ->where('user_id', auth()->id())
                ->with(['application.course:id,title'])
                ->latest()
                ->get(),
            'statusLabels' => [
                Review::STATUS_PENDING => 'На модерации',
                Review::STATUS_PUBLISHED => 'Опубликован',
                Review::STATUS_REJECTED => 'Отклонен',
            ],
        ])->layout('layouts::user', [
            'title' => 'Мои отзывы',
        ]);
    }
};
