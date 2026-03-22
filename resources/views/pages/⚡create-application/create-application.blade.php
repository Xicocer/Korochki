<div class="max-w-md mx-auto mt-6 space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">Оформить заявку</h1>
        <p class="text-sm text-slate-500 mt-1">Выберите курс и параметры обучения</p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="submit" class="space-y-5 rounded-3xl border border-slate-100 bg-white p-6 shadow-md">

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Курс</label>
            <select
                wire:model="course_id"
                class="w-full rounded-xl border border-slate-200 p-3 focus:outline-none focus:ring-2 focus:ring-orange-300"
            >
                <option value="">-- Выберите курс --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
            @error('course_id')
                <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Дата начала обучения</label>
            <input
                type="date"
                wire:model="start_date"
                class="w-full rounded-xl border border-slate-200 p-3 focus:outline-none focus:ring-2 focus:ring-orange-300"
            >
            @error('start_date')
                <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Способ оплаты</label>
            <div class="flex gap-3">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" wire:model="payment_method" value="cash" class="hidden">
                    <div class="rounded-xl border border-slate-200 p-3 text-center transition hover:border-orange-400 {{ $payment_method === 'cash' ? 'border-orange-300 bg-orange-50' : '' }}">
                        Наличными
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" wire:model="payment_method" value="transfer" class="hidden">
                    <div class="rounded-xl border border-slate-200 p-3 text-center transition hover:border-orange-400 {{ $payment_method === 'transfer' ? 'border-orange-300 bg-orange-50' : '' }}">
                        По номеру телефона
                    </div>
                </label>
            </div>
            @error('payment_method')
                <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="submit"
            class="w-full rounded-2xl bg-orange-600 py-3 font-semibold text-white transition hover:bg-orange-700"
        >
            <span wire:loading.remove wire:target="submit">Отправить заявку</span>
            <span wire:loading wire:target="submit">Отправляем...</span>
        </button>

    </form>

</div>
