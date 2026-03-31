<div class="flex flex-col min-h-full px-6 py-8">

    {{-- Hero --}}
    <section class="text-center mt-6">
        <h1 class="text-3xl font-extrabold text-slate-800 leading-tight">
            Корочки.есть
        </h1>

        <p class="mt-3 text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
            Онлайн-запись на курсы дополнительного профессионального образования
        </p>
    </section>

    {{-- Место под будущий slider --}}
    <section class="mt-8">
        <livewire:marketing-slider />
    </section>

    {{-- Кнопки --}}
    <section class="mt-10 flex flex-col gap-4">

        <a href="/register"
           wire:navigate
           class="w-full py-4 rounded-2xl bg-orange-600 text-white text-center font-semibold shadow-lg shadow-orange-200 hover:bg-orange-700 transition">
            Регистрация
        </a>

        <a href="{{ route('login') }}"
           wire:navigate
           class="w-full py-4 rounded-2xl border border-slate-200 text-slate-700 text-center font-semibold hover:bg-slate-50 transition">
            Вход
        </a>

    </section>

    {{-- Нижний блок --}}
    <section class="mt-auto pt-10 text-center">
        <p class="text-xs text-slate-400">
            Образование • Развитие • Возможности
        </p>
    </section>

</div>
