<div class="space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 lg:text-3xl">
                Мои отзывы
            </h1>

            <p class="mt-1 text-sm text-slate-500 lg:text-base">
                Здесь отображаются все ваши отзывы и их текущий статус модерации.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            wire:navigate
            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 sm:w-auto"
        >
            К заявкам
        </a>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        @forelse ($reviews as $review)
            <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-base font-semibold text-slate-800">
                            {{ $review->application?->course?->title ?? 'Курс не найден' }}
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Отзыв от {{ $review->created_at?->format('d.m.Y H:i') }}
                        </p>
                    </div>

                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                        @if ($review->status === 'published') bg-green-100 text-green-700
                        @elseif ($review->status === 'rejected') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700
                        @endif
                    ">
                        {{ $statusLabels[$review->status] ?? 'На модерации' }}
                    </span>
                </div>

                <p class="mt-3 rounded-xl bg-slate-50 p-3 text-sm text-slate-700">
                    {{ $review->review }}
                </p>

                @if ($review->status === 'rejected' && $review->moderation_note)
                    <p class="mt-3 text-xs text-red-600">
                        Причина: {{ $review->moderation_note }}
                    </p>
                @endif
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-sm text-slate-500 lg:col-span-2">
                У вас пока нет отзывов
            </div>
        @endforelse
    </div>

</div>
