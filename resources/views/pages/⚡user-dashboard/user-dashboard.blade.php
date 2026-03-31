<div class="space-y-5">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Мои заявки
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Здесь отображаются все ваши заявки на обучение
        </p>
    </div>

    <div class="space-y-4">

        @forelse($applications as $application)
            <div class="bg-white rounded-3xl shadow-md p-5 border border-slate-100 hover:shadow-lg transition">

                <div class="flex justify-between items-start">

                    <div>
                        <h2 class="font-semibold text-slate-800 text-lg">
                            {{ $application->course->title }}
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Дата начала:
                            {{ $application->start_date->format('d.m.Y') }}
                        </p>
                    </div>

                    <span class="
                        px-3 py-1 rounded-full text-xs font-medium
                        @if($application->status === 'Обучение завершено')
                            bg-green-100 text-green-700
                        @elseif($application->status === 'Новая')
                            bg-yellow-100 text-yellow-700
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
                        {{ $application->payment_method }}
                    </span>
                </div>

                @if($application->status === 'Обучение завершено')
                    <button
                        class="mt-4 w-full py-3 rounded-2xl bg-orange-50 text-orange-600 font-medium hover:bg-orange-100 transition"
                    >
                        Оставить отзыв
                    </button>
                @endif

            </div>

        @empty
            <div class="bg-white rounded-3xl p-8 text-center shadow-sm border border-slate-100">
                <p class="text-slate-500">
                    У вас пока нет заявок
                </p>
            </div>
        @endforelse

    </div>

</div>