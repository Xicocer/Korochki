<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Админка | Корочки.есть' }}</title>
    <meta name="robots" content="noindex,nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-slate-100">

<div class="mx-auto flex min-h-screen w-full overflow-hidden bg-white shadow-xl lg:my-6 lg:max-w-7xl lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-slate-300/40">

    <aside class="hidden w-72 shrink-0 border-r border-slate-200 bg-slate-50 p-6 lg:flex lg:flex-col">
        <div class="mb-8 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-600 shadow-lg shadow-orange-200">
                <span class="text-sm font-black text-white">KE</span>
            </div>
            <span class="text-lg font-extrabold uppercase tracking-tight text-slate-800">Админка</span>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.applications') }}" wire:navigate class="rounded-xl px-4 py-2.5 transition {{ request()->routeIs('admin.applications') ? 'bg-orange-100 font-semibold text-orange-700' : 'text-slate-700 hover:bg-orange-50' }}">
                Заявки
            </a>
            <a href="{{ route('admin.reviews') }}" wire:navigate class="rounded-xl px-4 py-2.5 transition {{ request()->routeIs('admin.reviews') ? 'bg-orange-100 font-semibold text-orange-700' : 'text-slate-700 hover:bg-orange-50' }}">
                Отзывы
            </a>
            <a href="{{ route('admin.courses') }}" wire:navigate class="rounded-xl px-4 py-2.5 transition {{ request()->routeIs('admin.courses') ? 'bg-orange-100 font-semibold text-orange-700' : 'text-slate-700 hover:bg-orange-50' }}">
                Курсы
            </a>
            <a href="{{ route('admin.slides') }}" wire:navigate class="rounded-xl px-4 py-2.5 transition {{ request()->routeIs('admin.slides') ? 'bg-orange-100 font-semibold text-orange-700' : 'text-slate-700 hover:bg-orange-50' }}">
                Слайдер
            </a>
            <a href="{{ route('admin.users') }}" wire:navigate class="rounded-xl px-4 py-2.5 transition {{ request()->routeIs('admin.users') ? 'bg-orange-100 font-semibold text-orange-700' : 'text-slate-700 hover:bg-orange-50' }}">
                Пользователи
            </a>
        </nav>

        <div class="mt-auto space-y-2 pt-6">
            <a href="{{ route('home') }}" wire:navigate class="block rounded-xl px-4 py-2.5 text-slate-600 transition hover:bg-slate-100">
                На сайт
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl px-4 py-2.5 text-left text-red-500 transition hover:bg-red-50">
                    Выйти
                </button>
            </form>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 border-b border-slate-100 bg-white/95 px-4 py-4 backdrop-blur sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3">
                <h1 class="text-lg font-bold text-slate-800">{{ $title ?? 'Админка' }}</h1>
                <a href="{{ route('home') }}" wire:navigate class="text-sm text-slate-500 transition hover:text-slate-700 lg:hidden">
                    Сайт
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-auto px-4 py-5 pb-24 sm:px-6 lg:px-8 lg:py-8 lg:pb-8">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 border-t border-slate-200 bg-white/95 px-3 py-3 backdrop-blur lg:hidden">
            <div class="grid grid-cols-5 gap-1 text-center text-[11px] font-medium">
                <a href="{{ route('admin.applications') }}" wire:navigate class="{{ request()->routeIs('admin.applications') ? 'text-orange-600' : 'text-slate-500' }}">
                    Заявки
                </a>
                <a href="{{ route('admin.reviews') }}" wire:navigate class="{{ request()->routeIs('admin.reviews') ? 'text-orange-600' : 'text-slate-500' }}">
                    Отзывы
                </a>
                <a href="{{ route('admin.courses') }}" wire:navigate class="{{ request()->routeIs('admin.courses') ? 'text-orange-600' : 'text-slate-500' }}">
                    Курсы
                </a>
                <a href="{{ route('admin.slides') }}" wire:navigate class="{{ request()->routeIs('admin.slides') ? 'text-orange-600' : 'text-slate-500' }}">
                    Слайдер
                </a>
                <a href="{{ route('admin.users') }}" wire:navigate class="{{ request()->routeIs('admin.users') ? 'text-orange-600' : 'text-slate-500' }}">
                    Люди
                </a>
            </div>
        </nav>
    </div>
</div>

@livewireScripts
</body>
</html>
