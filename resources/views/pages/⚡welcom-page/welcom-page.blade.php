<div class="flex min-h-full flex-col px-6 py-8 lg:px-12 lg:py-10">

    <section class="mt-4 text-center lg:mt-2 lg:text-left">
        <h1 class="text-3xl font-extrabold leading-tight text-slate-800 lg:text-5xl lg:leading-tight">
            Корочки.есть
        </h1>

        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-slate-500 lg:mx-0 lg:text-base">
            Онлайн-запись на курсы дополнительного профессионального образования
        </p>
    </section>

    <section class="mx-auto mt-8 w-full max-w-4xl">
        <livewire:marketing-slider />
    </section>

    <section class="mx-auto mt-10 grid w-full max-w-2xl gap-4 sm:grid-cols-2">
        <a
            href="/register"
            wire:navigate
            class="w-full rounded-2xl bg-orange-600 py-4 text-center font-semibold text-white shadow-lg shadow-orange-200 transition hover:bg-orange-700"
        >
            Регистрация
        </a>

        <a
            href="{{ route('login') }}"
            wire:navigate
            class="w-full rounded-2xl border border-slate-200 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
        >
            Вход
        </a>
    </section>

    <section class="mt-auto pt-10 text-center lg:pt-14">
        <p class="text-xs text-slate-400 lg:text-sm">
            Образование • Развитие • Возможности
        </p>
    </section>

</div>
