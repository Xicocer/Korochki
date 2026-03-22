<div class="px-6 py-8">

    <h1 class="text-2xl font-extrabold text-slate-800 text-center">
        Вход
    </h1>

    @if ($errors->any())
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            Проверьте данные и попробуйте ещё раз
        </div>
    @endif

    <form wire:submit="authenticate" class="mt-8 space-y-4">

        <div>
            <input
                wire:model="identifier"
                type="text"
                placeholder="Логин или email"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none"
            >

            @error('identifier')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input
                wire:model="password"
                type="password"
                placeholder="Пароль"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none"
            >

            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="authenticate"
            class="w-full py-4 rounded-2xl bg-orange-600 text-white font-semibold shadow-lg shadow-orange-200 hover:bg-orange-700 transition"
        >
            <span wire:loading.remove wire:target="authenticate">Войти</span>
            <span wire:loading wire:target="authenticate">Входим...</span>
        </button>

    </form>

    <div class="mt-6 text-center">
        <a
            href="{{ route('register') }}"
            wire:navigate
            class="text-sm text-slate-500 hover:text-orange-600 transition"
        >
            Нет аккаунта? Регистрация
        </a>
    </div>

</div>
