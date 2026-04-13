<?php

use App\Models\Course;
use Livewire\Component;

new class extends Component
{
    public string $title = '';
    public string $description = '';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'not_regex:/<[^>]*>/'],
            'description' => ['nullable', 'string', 'max:1000', 'not_regex:/<[^>]*>/'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        Course::query()->create([
            'title' => trim(strip_tags($validated['title'])),
            'description' => trim(strip_tags((string) ($validated['description'] ?? ''))),
        ]);

        session()->flash('success', 'Новый курс добавлен.');
        $this->reset(['title', 'description']);
    }

    public function deleteCourse(int $courseId): void
    {
        $course = Course::query()->withCount('applications')->find($courseId);

        if (! $course) {
            session()->flash('error', 'Курс не найден.');
            return;
        }

        if ($course->applications_count > 0) {
            session()->flash('error', 'Нельзя удалить курс, у которого уже есть заявки.');
            return;
        }

        $course->delete();
        session()->flash('success', 'Курс удален.');
    }

    public function render()
    {
        return $this->view([
            'courses' => Course::query()
                ->withCount('applications')
                ->orderBy('title')
                ->get(),
        ])->layout('layouts::admin', [
            'title' => 'Управление курсами',
        ]);
    }
};
