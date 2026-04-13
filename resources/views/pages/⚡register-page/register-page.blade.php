<div class="mx-auto w-full max-w-xl px-6 py-8 lg:max-w-3xl lg:py-10">

    <h1 class="text-center text-2xl font-extrabold text-slate-800 lg:text-3xl">
        Регистрация
    </h1>

    <form wire:submit="register" class="mt-8 space-y-4 md:grid md:grid-cols-2 md:gap-4 md:space-y-0">

        <div>
            <input
                wire:model.live.debounce.250ms="login"
                type="text"
                placeholder="Логин"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >
            @error('login')
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

        <div>
            <input
                wire:model.live.debounce.250ms="full_name"
                type="text"
                placeholder="Фамилия Имя Отчество"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >
            @error('full_name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div
            x-data="{
                phone: $wire.entangle('phone').live,
                formatPhone() {
                    const raw = this.phone ?? ''
                    const digits = raw.replace(/\D/g, '')

                    if (!digits.length) {
                        this.phone = ''
                        return
                    }

                    let prefix = '+7'
                    let national = ''

                    if (raw.trim().startsWith('+')) {
                        if (digits.startsWith('7') || digits.startsWith('8')) {
                            national = digits.slice(1)
                        } else if (digits.startsWith('9')) {
                            national = digits
                        } else {
                            national = digits.slice(1)
                        }
                    } else if (digits.startsWith('8')) {
                        prefix = '8'
                        national = digits.slice(1)
                    } else if (digits.startsWith('7')) {
                        national = digits.slice(1)
                    } else if (digits.startsWith('9')) {
                        national = digits
                    } else {
                        national = digits.slice(1)
                    }

                    national = national.slice(0, 10)

                    let formatted = prefix

                    if (national.length) {
                        formatted += ` (${national.slice(0, 3)}`
                    }

                    if (national.length >= 3) {
                        formatted += ')'
                    }

                    if (national.length > 3) {
                        formatted += ` ${national.slice(3, 6)}`
                    }

                    if (national.length > 6) {
                        formatted += `-${national.slice(6, 8)}`
                    }

                    if (national.length > 8) {
                        formatted += `-${national.slice(8, 10)}`
                    }

                    this.phone = formatted
                }
            }"
        >
            <input
                x-model="phone"
                x-on:input="formatPhone()"
                type="text"
                inputmode="tel"
                autocomplete="tel"
                placeholder="+7/8 (XXX) XXX-XX-XX"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >
            @error('phone')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="md:col-span-2">
            <input
                wire:model.live.debounce.250ms="email"
                type="email"
                placeholder="Email"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:ring-2 focus:ring-orange-500"
            >
            @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="register"
            class="w-full rounded-2xl bg-orange-600 py-4 font-semibold text-white shadow-lg shadow-orange-200 transition hover:bg-orange-700 md:col-span-2"
        >
            <span wire:loading.remove wire:target="register">Создать аккаунт</span>
            <span wire:loading wire:target="register">Сохраняем...</span>
        </button>

    </form>

    <div class="mt-6 text-center">
        <a
            href="{{ route('login') }}"
            wire:navigate
            class="text-sm text-slate-500 transition hover:text-orange-600"
        >
            Уже зарегистрированы? Вход
        </a>
    </div>

</div>
