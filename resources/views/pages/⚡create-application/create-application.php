<?php

use App\Models\Application;
use App\Models\Course;
use Livewire\Component;

new class extends Component
{
    public string $course_id = '';
    public string $start_date = '';
    public string $payment_method = 'cash';

    protected function rules(): array
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'payment_method' => ['required', 'in:cash,transfer'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        Application::create([
            'user_id' => auth()->id(),
            'course_id' => (int) $validated['course_id'],
            'start_date' => $validated['start_date'],
            'payment_method' => $validated['payment_method'],
        ]);

        session()->flash('success', 'Заявка успешно отправлена');

        $this->reset(['course_id', 'start_date']);
        $this->payment_method = 'cash';
    }

    public function render()
    {
        return $this->view([
            'courses' => Course::query()
                ->orderBy('title')
                ->get(['id', 'title']),
        ])->layout('layouts::user', [
            'title' => 'Оформление заявки',
        ]);
    }
};
