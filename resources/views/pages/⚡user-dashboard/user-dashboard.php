<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        $applications = auth()->user()
            ->applications()
            ->with('course')
            ->latest()
            ->get();

        return $this->view([
            'applications' => $applications,
        ])->layout('layouts::user', [
            'title' => 'Личный кабинет',
        ]);
    }
};
