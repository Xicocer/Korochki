<div class="space-y-6 px-4 py-6">

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
                    <tr wire:key="admin-application-{{ $application->id }}" class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->user?->full_name ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->course?->title ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $application->start_date?->format('d.m.Y') ?? '—' }}</td>
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
                                <span class="text-sm text-slate-400">Нельзя удалить</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                            Пока нет заявок
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
