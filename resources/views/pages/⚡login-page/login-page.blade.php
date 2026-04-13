<div class="mx-auto w-full max-w-md px-6 py-8 lg:max-w-lg lg:py-10">

    <h1 class="text-center text-2xl font-extrabold text-slate-800 lg:text-3xl">
        Вход
    </h1>

    <form wire:submit="authenticate" class="mt-8 space-y-4">

        <div>
            <input
                wire:model.live.debounce.250ms="identifier"
                type="text"
                placeholder="Логин или email"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >

            @error('identifier')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input
                wire:model.live.debounce.250ms="password"
                type="password"
                placeholder="Пароль"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >

            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="authenticate"
            class="w-full rounded-2xl bg-orange-600 py-4 font-semibold text-white shadow-lg shadow-orange-200 transition hover:bg-orange-700"
        >
            <span wire:loading.remove wire:target="authenticate">Войти</span>
            <span wire:loading wire:target="authenticate">Проверяем...</span>
        </button>

    </form>

    <div class="mt-6 text-center">
        <a
            href="{{ route('register') }}"
            wire:navigate
            class="text-sm text-slate-500 transition hover:text-orange-600"
        >
            Нет аккаунта? Зарегистрируйтесь
        </a>
    </div>

</div>
