<div class="px-6 py-8">

    <h1 class="text-2xl font-extrabold text-slate-800 text-center">
        Регистрация
    </h1>

    <form wire:submit="register" class="mt-8 space-y-4">

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

        <div>
            <input wire:model="full_name"
                   type="text"
                   placeholder="ФИО"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
            @error('full_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                        if (digits.startsWith('7')) {
                            national = digits.slice(1)
                        } else if (digits.startsWith('8')) {
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
            <input x-model="phone"
                   x-on:input="formatPhone()"
                   type="text"
                   inputmode="tel"
                   autocomplete="tel"
                   placeholder="Введите номер телефона"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
            @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <input wire:model="email"
                   type="email"
                   placeholder="Email"
                   class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-orange-500 outline-none">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-4 rounded-2xl bg-orange-600 text-white font-semibold shadow-lg shadow-orange-200 hover:bg-orange-700 transition">
            Зарегистрироваться
        </button>

    </form>

    <div class="mt-6 text-center">
        <a href="/login"
           wire:navigate
           class="text-sm text-slate-500 hover:text-orange-600 transition">
            Уже зарегистрированы? Вход
        </a>
    </div>

</div>
