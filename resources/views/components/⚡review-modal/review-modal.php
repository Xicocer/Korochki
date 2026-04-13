<?php

use App\Models\Application;
use App\Models\Review;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

new class extends Component
{
    private const COMPLETED_STATUS = "\u{041e}\u{0431}\u{0443}\u{0447}\u{0435}\u{043d}\u{0438}\u{0435} \u{0437}\u{0430}\u{0432}\u{0435}\u{0440}\u{0448}\u{0435}\u{043d}\u{043e}";

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
            'reviewText' => ['required', 'string', 'min:5', 'max:1000', 'not_regex:/<[^>]*>/'],
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
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 8)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            $this->addError('reviewText', "Слишком много попыток. Повторите через {$seconds} сек.");
            return;
        }

        RateLimiter::hit($this->throttleKey(), 60);
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
                'review' => trim(strip_tags($validated['reviewText'])),
                'status' => Review::STATUS_PENDING,
                'moderation_note' => null,
                'moderated_at' => null,
            ]
        );

        session()->flash('success', 'Отзыв сохранен и отправлен на модерацию.');
        $this->dispatch('review-saved');
        $this->close();
    }

    public function close(): void
    {
        $this->reset(['isOpen', 'applicationId', 'reviewText']);
        $this->resetValidation();
    }

    protected function throttleKey(): string
    {
        return sprintf('review:%s|%s', auth()->id() ?? 'guest', request()->ip());
    }

    public function render()
    {
        return $this->view();
    }
};
