<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageTitle = $title ?? 'Корочки.есть';
        $metaDescription = $metaDescription ?? 'Личный кабинет для управления заявками и отзывами.';
        $metaKeywords = $metaKeywords ?? 'кабинет, заявки, отзывы, курсы';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="noindex,nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">

<div class="mx-auto flex min-h-screen w-full overflow-hidden bg-white shadow-xl lg:my-6 lg:max-w-7xl lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-2xl lg:shadow-slate-300/40">

    <aside class="hidden w-72 flex-col border-r border-slate-200 bg-slate-50 px-6 py-8 lg:flex">
        <h1 class="mb-10 text-xl font-bold text-slate-800">
            Учебный портал
        </h1>

        <nav class="flex flex-col gap-2">
            <a
                href="{{ route('dashboard') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-600' }}"
            >
                Мои заявки
            </a>

            <a
                href="{{ route('dashboard.reviews') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 transition {{ request()->routeIs('dashboard.reviews') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-600' }}"
            >
                Мои отзывы
            </a>

            <a
                href="{{ route('applications.create') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 transition {{ request()->routeIs('applications.create') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-600' }}"
            >
                Новая заявка
            </a>

            <a
                href="{{ route('reviews.index') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 transition {{ request()->routeIs('reviews.index') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-600' }}"
            >
                Все отзывы
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="mt-2 w-full rounded-2xl px-4 py-3 text-left text-red-500 transition hover:bg-red-50"
                >
                    Выйти
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex flex-1 flex-col">
        <header class="sticky top-0 z-10 border-b border-slate-100 bg-white px-4 py-4 sm:px-6 lg:px-10">
            <h1 class="text-lg font-bold tracking-tight text-slate-800">
                Учебный портал
            </h1>
        </header>

        <main class="flex-1 px-4 py-5 pb-24 sm:px-6 lg:px-10 lg:py-8 lg:pb-8">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 border-t border-slate-200 bg-white/95 px-3 py-3 backdrop-blur lg:hidden">
            <div class="mx-auto grid w-full max-w-md grid-cols-5 items-center gap-1 text-center text-[11px] font-medium">
                <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'text-orange-600' : 'text-slate-500' }}">
                    Заявки
                </a>
                <a href="{{ route('dashboard.reviews') }}" wire:navigate class="{{ request()->routeIs('dashboard.reviews') ? 'text-orange-600' : 'text-slate-500' }}">
                    Мои отзывы
                </a>
                <a href="{{ route('applications.create') }}" wire:navigate class="{{ request()->routeIs('applications.create') ? 'text-orange-600' : 'text-slate-500' }}">
                    Новая
                </a>
                <a href="{{ route('reviews.index') }}" wire:navigate class="{{ request()->routeIs('reviews.index') ? 'text-orange-600' : 'text-slate-500' }}">
                    Отзывы
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500">Выйти</button>
                </form>
            </div>
        </nav>
    </div>
</div>

@livewireScripts
</body>
</html>
