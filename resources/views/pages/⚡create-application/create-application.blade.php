<div class="mx-auto mt-2 w-full max-w-5xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800 lg:text-3xl">Создание заявки</h1>
        <p class="mt-1 text-sm text-slate-500 lg:text-base">Выберите курс карточкой, затем заполните форму в модальном окне</p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="space-y-3 rounded-3xl border border-slate-100 bg-white p-5 shadow-md lg:p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-base font-semibold text-slate-800 lg:text-lg">Доступные курсы</h2>

            @error('course_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid gap-3 md:grid-cols-2">
            @forelse ($courses as $course)
                <button
                    type="button"
                    wire:click="openForm({{ $course->id }})"
                    class="rounded-2xl border border-slate-200 p-4 text-left transition hover:border-orange-300 hover:bg-orange-50/40"
                >
                    <h3 class="font-semibold text-slate-800">{{ $course->title }}</h3>

                    @if ($course->description)
                        <p class="mt-2 text-sm text-slate-500">{{ $course->description }}</p>
                    @endif

                    <p class="mt-3 text-xs font-medium uppercase tracking-wide text-orange-600">
                        Оформить заявку
                    </p>
                </button>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500 md:col-span-2">
                    Курсы пока не добавлены
                </div>
            @endforelse
        </div>
    </section>

    @if ($isFormModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 px-4 py-6 lg:px-8" wire:click="closeForm">
            <div
                class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl lg:p-7"
                wire:click.stop
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Новая заявка</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Курс:
                            <span class="font-medium text-slate-700">{{ $selectedCourse?->title ?? 'Не выбран' }}</span>
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeForm"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                        aria-label="Закрыть"
                    >
                        ✕
                    </button>
                </div>

                <form wire:submit="submit" class="mt-5 space-y-5">
                    <input type="hidden" wire:model="course_id">

                    <div x-data>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Дата начала обучения</label>

                        <div class="flex items-center gap-2">
                            <input
                                x-ref="dateInput"
                                type="date"
                                wire:model.live="start_date"
                                min="{{ $today }}"
                                class="w-full rounded-xl border border-slate-200 p-3 focus:outline-none focus:ring-2 focus:ring-orange-300"
                            >

                            <button
                                type="button"
                                @click="$refs.dateInput.showPicker?.()"
                                class="rounded-xl border border-slate-200 px-3 py-3 text-sm text-slate-600 transition hover:bg-slate-50"
                            >
                                Календарь
                            </button>
                        </div>

                        @error('start_date')
                            <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Способ оплаты</label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" wire:model.live="payment_method" value="cash" class="hidden">
                                <div class="rounded-xl border border-slate-200 p-3 text-center transition hover:border-orange-400 {{ $payment_method === 'cash' ? 'border-orange-300 bg-orange-50' : '' }}">
                                    Наличные
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" wire:model.live="payment_method" value="transfer" class="hidden">
                                <div class="rounded-xl border border-slate-200 p-3 text-center transition hover:border-orange-400 {{ $payment_method === 'transfer' ? 'border-orange-300 bg-orange-50' : '' }}">
                                    Переводом
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            wire:click="closeForm"
                            class="rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-200"
                        >
                            Отмена
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="submit"
                            class="rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
                        >
                            <span wire:loading.remove wire:target="submit">Отправить заявку</span>
                            <span wire:loading wire:target="submit">Отправляем...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
