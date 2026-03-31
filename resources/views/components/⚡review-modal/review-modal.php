<?php

use App\Models\Application;
use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    public const COMPLETED_STATUS = 'Обучение завершено';

    public ?int $applicationId = null;
    public string $reviewText = '';
    public bool $isOpen = false;

    public function getListeners(): array
    {
        return [
            'open-review-modal' => 'open',
        ];
    }

    protected function rules(): array
    {
        return [
            'reviewText' => ['required', 'string', 'min:5', 'max:1000'],
        ];
    }

    public function open(int $applicationId): void
    {
        $application = Application::query()
            ->whereKey($applicationId)
            ->where('user_id', auth()->id())
            ->first();

        if (! $application || $application->status !== self::COMPLETED_STATUS) {
            return;
        }

        $this->applicationId = $applicationId;
        $this->reviewText = (string) Review::query()
            ->where('application_id', $applicationId)
            ->where('user_id', auth()->id())
            ->value('review');

        $this->resetValidation();
        $this->isOpen = true;
    }

    public function saveReview(): void
    {
        $validated = $this->validate();

        $application = Application::query()
            ->whereKey($this->applicationId)
            ->where('user_id', auth()->id())
            ->first();

        if (! $application || $application->status !== self::COMPLETED_STATUS) {
            $this->close();
            return;
        }

        Review::query()->updateOrCreate(
            [
                'application_id' => $application->id,
                'user_id' => auth()->id(),
            ],
            [
                'review' => $validated['reviewText'],
            ]
        );

        $this->dispatch('review-saved');
        $this->close();
    }

    public function close(): void
    {
        $this->reset(['isOpen', 'applicationId', 'reviewText']);
        $this->resetValidation();
    }

    public function render()
    {
        return $this->view();
    }
};
