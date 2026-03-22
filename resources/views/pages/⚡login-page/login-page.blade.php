<div class="px-6 py-8">

    <h1 class="text-2xl font-extrabold text-slate-800 text-center">
        Вход
    </h1>

    <form wire:submit="login" class="mt-8 space-y-4">

        <div>
            <input wire:model="login"
                   type="text"
                   placeholder="Логин"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">

            @error('login')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input wire:model="password"
                   type="password"
                   placeholder="Пароль"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">

            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-4 rounded-2xl bg-orange-600 text-white font-semibold shadow-lg shadow-orange-200 hover:bg-orange-700 transition">
            Войти
        </button>

    </form>

    <div class="mt-6 text-center">
        <a href="/register"
           wire:navigate
           class="text-sm text-slate-500 hover:text-orange-600 transition">
            Нет аккаунта? Регистрация
        </a>
    </div>

</div>
