<?php

use App\Models\MarketingSlide;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'slides' => $this->slides(),
        ]);
    }

    protected function slides(): Collection
    {
        if (! Schema::hasTable('marketing_slides')) {
            return collect();
        }

        return MarketingSlide::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
};
