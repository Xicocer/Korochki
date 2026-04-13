<div class="space-y-6">

    <h1 class="text-2xl font-bold text-slate-800">Заявки пользователей</h1>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-2xl border border-slate-100 bg-white p-4 shadow">
        <p class="text-sm font-medium text-slate-600">Фильтр по статусу</p>

        <div class="mt-3 flex flex-wrap gap-2">
            <button
                type="button"
                wire:click="setStatusFilter('all')"
                class="rounded-xl px-4 py-2 text-sm font-medium transition {{ $statusFilter === 'all' ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
            >
                Все
                <span class="ml-1 rounded-lg bg-white/80 px-2 py-0.5 text-xs">{{ $totalApplications }}</span>
            </button>

            @foreach ($statuses as $status)
                <button
                    type="button"
                    wire:click="setStatusFilter('{{ $status }}')"
                    class="rounded-xl px-4 py-2 text-sm font-medium transition {{ $statusFilter === $status ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    {{ $status }}
                    <span class="ml-1 rounded-lg bg-white/80 px-2 py-0.5 text-xs">{{ $statusTotals->get($status, 0) }}</span>
                </button>
            @endforeach
        </div>
    </section>

    <div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Пользователь</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Курс</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Дата начала</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Статус</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($applications as $application)
                    @php($canDelete = in_array($application->status, $deletableStatuses, true))
                    <tr wire:key="admin-application-{{ $application->id }}" class="transition hover:bg-slate-50">
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->user?->full_name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->course?->title ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->start_date?->format('d.m.Y') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <select
                                wire:change="updateStatus({{ $application->id }}, $event.target.value)"
                                class="rounded-xl border border-slate-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300"
                            >
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected($application->status === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            @if ($canDelete)
                                <button
                                    type="button"
                                    wire:click="deleteApplication({{ $application->id }})"
                                    wire:confirm="Удалить заявку #{{ $application->id }}?"
                                    class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-600 transition hover:bg-red-200"
                                >
                                    Удалить
                                </button>
                            @else
                                <span class="text-sm text-slate-400">Недоступно</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">
                            По выбранному фильтру заявок нет
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
