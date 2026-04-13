<?php

use App\Models\Application;
use App\Models\Course;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

new class extends Component
{
    public string $course_id = '';
    public string $start_date = '';
    public string $payment_method = 'cash';
    public bool $isFormModalOpen = false;

    protected function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'payment_method' => ['required', 'in:cash,transfer'],
        ];
    }

    public function openForm(int $courseId): void
    {
        if (! Course::query()->whereKey($courseId)->exists()) {
            return;
        }

        $this->course_id = (string) $courseId;
        $this->start_date = '';
        $this->payment_method = 'cash';
        $this->isFormModalOpen = true;
        $this->resetValidation();
    }

    public function closeForm(): void
    {
        $this->isFormModalOpen = false;
        $this->resetValidation();
    }

    public function submit(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 10)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());
            $this->addError('course_id', "Слишком много попыток отправки. Повторите через {$seconds} сек.");
            return;
        }

        RateLimiter::hit($this->throttleKey(), 60);
        $validated = $this->validate();

        Application::create([
            'user_id' => auth()->id(),
            'course_id' => (int) $validated['course_id'],
            'start_date' => $validated['start_date'],
            'payment_method' => $validated['payment_method'],
        ]);

        session()->flash('success', 'Заявка успешно отправлена.');

        $this->reset(['course_id', 'start_date', 'isFormModalOpen']);
        $this->payment_method = 'cash';
    }

    protected function throttleKey(): string
    {
        return sprintf('create-application:%s|%s', auth()->id() ?? 'guest', request()->ip());
    }

    public function render()
    {
        $courses = Course::query()
            ->orderBy('title')
            ->get(['id', 'title', 'description']);

        return $this->view([
            'courses' => $courses,
            'selectedCourse' => $courses->firstWhere('id', (int) $this->course_id),
            'today' => now()->toDateString(),
        ])->layout('layouts::user', [
            'title' => 'Создание заявки',
        ]);
    }
};
