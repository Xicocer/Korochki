<?php

use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'reviews' => Review::query()
                ->where('status', Review::STATUS_PUBLISHED)
                ->with(['user:id,full_name', 'application.course:id,title'])
                ->latest('moderated_at')
                ->get(),
        ])->layout('layouts::app', [
            'title' => 'Отзывы пользователей',
            'metaDescription' => 'Опубликованные отзывы пользователей платформы.',
            'metaKeywords' => 'отзывы, курсы, обучение',
            'ogTitle' => 'Отзывы пользователей | Корочки.есть',
            'ogDescription' => 'Здесь отображаются только опубликованные после модерации отзывы.',
        ]);
    }
};
