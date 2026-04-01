<?php

use App\Models\MarketingSlide;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public $image = null;
    public bool $is_active = true;
    public int $order = 0;

    public function mount(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'not_regex:/<[^>]*>/'],
            'description' => ['required', 'string', 'max:255', 'not_regex:/<[^>]*>/'],
            'image' => ['required', 'image', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'order' => ['required', 'integer'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $imagePath = $this->image->store('slides', 'public');

        MarketingSlide::query()->create([
            'title' => trim(strip_tags($validated['title'])),
            'description' => trim(strip_tags($validated['description'])),
            'image_path' => $imagePath,
            'is_active' => $validated['is_active'],
            'order' => $validated['order'],
        ]);

        session()->flash('success', 'Слайд добавлен');

        $this->reset(['title', 'description', 'image', 'order']);
        $this->is_active = true;
    }

    public function deleteSlide(int $slideId): void
    {
        $slide = MarketingSlide::query()->find($slideId);

        if (! $slide) {
            session()->flash('error', 'Слайд не найден');
            return;
        }

        Storage::disk('public')->delete($slide->image_path);
        $slide->delete();

        session()->flash('success', 'Слайд удален');
    }

    public function toggleActive(int $slideId): void
    {
        $slide = MarketingSlide::query()->find($slideId);

        if (! $slide) {
            session()->flash('error', 'Слайд не найден');
            return;
        }

        $slide->is_active = ! $slide->is_active;
        $slide->save();
    }

    public function render()
    {
        return $this->view([
            'slides' => MarketingSlide::query()
                ->orderBy('order')
                ->orderBy('id')
                ->get(),
        ])->layout('layouts::admin', [
            'title' => 'Управление слайдером',
        ]);
    }
};
