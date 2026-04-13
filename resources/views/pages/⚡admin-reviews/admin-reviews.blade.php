<div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Модерация отзывов</h1>

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
                <span class="ml-1 rounded-lg bg-white/80 px-2 py-0.5 text-xs">{{ $totalReviews }}</span>
            </button>

            @foreach ($statuses as $status)
                <button
                    type="button"
                    wire:click="setStatusFilter('{{ $status }}')"
                    class="rounded-xl px-4 py-2 text-sm font-medium transition {{ $statusFilter === $status ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    {{ $labels[$status] }}
                    <span class="ml-1 rounded-lg bg-white/80 px-2 py-0.5 text-xs">{{ $statusTotals->get($status, 0) }}</span>
                </button>
            @endforeach
        </div>
    </section>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm" wire:key="admin-review-{{ $review->id }}">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            {{ $review->user?->full_name ?? $review->user?->login ?? 'Пользователь' }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Курс: {{ $review->application?->course?->title ?? '-' }}
                        </p>
                    </div>

                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                        @if ($review->status === 'published') bg-green-100 text-green-700
                        @elseif ($review->status === 'rejected') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700
                        @endif
                    ">
                        {{ $labels[$review->status] ?? 'На модерации' }}
                    </span>
                </div>

                <p class="mt-3 rounded-xl bg-slate-50 p-3 text-sm text-slate-700">
                    {{ $review->review }}
                </p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <button
                        type="button"
                        wire:click="publish({{ $review->id }})"
                        class="rounded-xl bg-green-100 px-4 py-2 text-sm font-semibold text-green-700 transition hover:bg-green-200"
                    >
                        Опубликовать
                    </button>

                    <button
                        type="button"
                        wire:click="reject({{ $review->id }})"
                        class="rounded-xl bg-red-100 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-200"
                    >
                        Отклонить
                    </button>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-slate-100 bg-white p-8 text-center text-sm text-slate-500 shadow-sm">
                По выбранному фильтру отзывов нет
            </div>
        @endforelse
    </div>
</div>
