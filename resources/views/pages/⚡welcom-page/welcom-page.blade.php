<div class="flex min-h-full flex-col px-6 py-8 lg:px-12 lg:py-10">

    <section class="mt-4 text-center lg:mt-2 lg:text-left">
        <h1 class="text-3xl font-extrabold leading-tight text-slate-800 lg:text-5xl lg:leading-tight">
            Корочки.есть
        </h1>

        <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-500 lg:mx-0 lg:text-base">
            Онлайн-запись на курсы дополнительного профессионального образования.
        </p>
    </section>

    <section class="mx-auto mt-8 w-full max-w-4xl">
        <livewire:marketing-slider />
    </section>

    @auth
        <section class="mx-auto mt-10 grid w-full max-w-4xl gap-3 sm:grid-cols-3">
            <a
                href="{{ route('dashboard') }}"
                wire:navigate
                class="w-full rounded-2xl bg-orange-600 py-4 text-center font-semibold text-white shadow-lg shadow-orange-200 transition hover:bg-orange-700"
            >
                Личный кабинет
            </a>

            @if (auth()->user()->isAdmin())
                <a
                    href="{{ route('admin.applications') }}"
                    wire:navigate
                    class="w-full rounded-2xl border border-slate-200 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Админ-панель
                </a>
            @else
                <a
                    href="{{ route('applications.create') }}"
                    wire:navigate
                    class="w-full rounded-2xl border border-slate-200 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Новая заявка
                </a>
            @endif

            <a
                href="{{ route('reviews.index') }}"
                wire:navigate
                class="w-full rounded-2xl border border-slate-200 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Отзывы
            </a>
        </section>
    @else
        <section class="mx-auto mt-10 grid w-full max-w-4xl gap-3 sm:grid-cols-3">
            <a
                href="{{ route('register') }}"
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

            <a
                href="{{ route('reviews.index') }}"
                wire:navigate
                class="w-full rounded-2xl border border-slate-200 py-4 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Отзывы
            </a>
        </section>
    @endauth

    <section class="mt-auto pt-10 text-center lg:pt-14">
        <p class="text-xs text-slate-400 lg:text-sm">
            Образование * Развитие * Возможности
        </p>
    </section>

</div>
