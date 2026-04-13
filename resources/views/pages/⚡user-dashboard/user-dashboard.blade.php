<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800 lg:text-3xl">
            Мои заявки
        </h1>

        <p class="mt-1 text-sm text-slate-500 lg:text-base">
            Здесь вы можете отслеживать заявки и оставлять отзывы после завершения обучения.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-2">

        @forelse ($applications as $application)
            @php($isCompleted = $application->status === $completedStatus)
            @php($review = $application->reviews->first())

            <article
                wire:key="dashboard-application-{{ $application->id }}"
                @if ($isCompleted)
                    wire:click="openReviewModal({{ $application->id }})"
                    class="h-full cursor-pointer rounded-3xl border border-slate-100 bg-white p-5 shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
                @else
                    class="h-full rounded-3xl border border-slate-100 bg-white p-5 shadow-md transition hover:shadow-lg"
                @endif
            >

                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            {{ $application->course->title }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Дата начала: {{ $application->start_date->format('d.m.Y') }}
                        </p>
                    </div>

                    <span class="
                        rounded-full px-3 py-1 text-xs font-medium
                        @if ($application->status === $completedStatus)
                            bg-green-100 text-green-700
                        @elseif ($application->status === $newStatus)
                            bg-yellow-100 text-yellow-700
                        @elseif ($application->status === $rejectedStatus)
                            bg-red-100 text-red-700
                        @else
                            bg-slate-100 text-slate-600
                        @endif
                    ">
                        {{ $application->status }}
                    </span>
                </div>

                <div class="mt-4 text-sm text-slate-500">
                    Способ оплаты:
                    <span class="font-medium text-slate-700">
                        {{ $application->payment_method === 'cash' ? 'Наличные' : 'Переводом' }}
                    </span>
                </div>

                @if ($isCompleted)
                    <div class="mt-4 rounded-2xl bg-orange-50 px-4 py-3 text-sm font-medium text-orange-700">
                        {{ $review ? 'Нажмите, чтобы отредактировать отзыв' : 'Нажмите, чтобы оставить отзыв' }}
                    </div>
                @endif

                @if ($review)
                    <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-sm text-slate-700">
                            {{ $review->review }}
                        </p>

                        <div class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                            @if ($review->status === 'published') bg-green-100 text-green-700
                            @elseif ($review->status === 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700
                            @endif
                        ">
                            {{ $statusLabels[$review->status] ?? 'На модерации' }}
                        </div>
                    </div>
                @endif

            </article>

        @empty
            <div class="rounded-3xl border border-slate-100 bg-white p-8 text-center shadow-sm xl:col-span-2">
                <p class="text-slate-500">
                    У вас пока нет заявок.
                </p>
            </div>
        @endforelse

    </div>

    <livewire:review-modal />

</div>
