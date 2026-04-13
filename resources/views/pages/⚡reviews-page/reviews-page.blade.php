<div class="mx-auto w-full max-w-5xl px-4 py-6 lg:px-0">
    <section class="text-center">
        <h1 class="text-3xl font-extrabold text-slate-800 lg:text-4xl">Отзывы пользователей</h1>
        <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-500 lg:text-base">
            На этой странице отображаются только отзывы, прошедшие модерацию.
        </p>
    </section>

    <section class="mt-8 grid gap-4 lg:grid-cols-2">
        @forelse ($reviews as $review)
            <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-slate-800">{{ $review->user?->full_name ?? 'Пользователь' }}</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Курс: {{ $review->application?->course?->title ?? '-' }}
                        </p>
                    </div>
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Опубликован
                    </span>
                </div>

                <p class="mt-4 rounded-xl bg-slate-50 p-3 text-sm text-slate-700">
                    {{ $review->review }}
                </p>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-sm text-slate-500 lg:col-span-2">
                Пока нет опубликованных отзывов
            </div>
        @endforelse
    </section>
</div>
