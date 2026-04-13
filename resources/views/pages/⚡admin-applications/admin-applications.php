<?php

use App\Models\Application;
use Livewire\Component;

new class extends Component
{
    private const STATUS_NEW = "\u{041d}\u{043e}\u{0432}\u{0430}\u{044f}";
    private const STATUS_IN_PROGRESS = "\u{0418}\u{0434}\u{0435}\u{0442} \u{043e}\u{0431}\u{0443}\u{0447}\u{0435}\u{043d}\u{0438}\u{0435}";
    private const STATUS_COMPLETED = "\u{041e}\u{0431}\u{0443}\u{0447}\u{0435}\u{043d}\u{0438}\u{0435} \u{0437}\u{0430}\u{0432}\u{0435}\u{0440}\u{0448}\u{0435}\u{043d}\u{043e}";
    private const STATUS_REJECTED = "\u{0417}\u{0430}\u{044f}\u{0432}\u{043a}\u{0430} \u{043e}\u{0442}\u{043a}\u{043b}\u{043e}\u{043d}\u{0435}\u{043d}\u{043d}\u{0430}";

    public array $statuses = [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
        self::STATUS_REJECTED,
    ];

    public array $deletableStatuses = [
        self::STATUS_COMPLETED,
        self::STATUS_REJECTED,
    ];

    public string $statusFilter = 'all';

    public function setStatusFilter(string $status): void
    {
        if ($status !== 'all' && ! in_array($status, $this->statuses, true)) {
            return;
        }

        $this->statusFilter = $status;
    }

    public function updateStatus(int $applicationId, string $newStatus): void
    {
        if (! in_array($newStatus, $this->statuses, true)) {
            session()->flash('error', 'Недопустимый статус заявки.');
            return;
        }

        $application = Application::query()->find($applicationId);

        if (! $application) {
            session()->flash('error', 'Заявка не найдена.');
            return;
        }

        $application->status = $newStatus;
        $application->save();

        session()->flash('success', "Статус заявки #{$application->id} обновлен.");
    }

    public function deleteApplication(int $applicationId): void
    {
        $application = Application::query()->find($applicationId);

        if (! $application) {
            session()->flash('error', 'Заявка не найдена.');
            return;
        }

        if (! in_array($application->status, $this->deletableStatuses, true)) {
            session()->flash('error', 'Удалять можно только завершенные или отклоненные заявки.');
            return;
        }

        $application->delete();
        session()->flash('success', "Заявка #{$applicationId} удалена.");
    }

    public function render()
    {
        $query = Application::query()
            ->with(['user:id,full_name', 'course:id,title'])
            ->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $statusTotals = Application::query()->pluck('status')->countBy();

        return $this->view([
            'applications' => $query->get(),
            'statusTotals' => $statusTotals,
            'totalApplications' => $statusTotals->sum(),
        ])->layout('layouts::admin', [
            'title' => 'Заявки пользователей',
        ]);
    }
};
