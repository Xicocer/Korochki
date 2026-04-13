<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageTitle = $title ?? 'Корочки.есть';
        $metaDescription = $metaDescription ?? 'Онлайн-запись на курсы дополнительного профессионального образования.';
        $metaKeywords = $metaKeywords ?? 'курсы, обучение, онлайн-запись';
        $ogTitle = $ogTitle ?? $pageTitle;
        $ogDescription = $ogDescription ?? $metaDescription;
        $ogType = $ogType ?? 'website';
        $ogUrl = $ogUrl ?? url()->current();
        $ogImage = $ogImage ?? asset('favicon.ico');
        $twitterCard = $twitterCard ?? 'summary';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="index,follow">

    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">

    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @if (! empty($socialSchema))
        <script type="application/ld+json">{!! json_encode($socialSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif

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
<body class="min-h-screen bg-slate-100 antialiased">

<div class="mx-auto flex min-h-screen w-full overflow-hidden bg-white shadow-2xl lg:my-6 lg:max-w-7xl lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-slate-300/40">

    <aside class="hidden w-72 flex-col border-r border-slate-200 bg-slate-50 px-6 py-8 lg:flex">
        <a href="{{ route('home') }}" wire:navigate class="mb-10 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-600 shadow-lg shadow-orange-200">
                <span class="text-sm font-black text-white">KE</span>
            </div>
            <span class="text-xl font-extrabold uppercase tracking-tight text-slate-800">Корочки</span>
        </a>

        <nav class="flex flex-col gap-2">
            <a
                href="{{ route('home') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 {{ request()->routeIs('home', 'welcom-page') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Главная
            </a>

            <a
                href="{{ route('reviews.index') }}"
                wire:navigate
                class="rounded-2xl px-4 py-3 {{ request()->routeIs('reviews.index') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Отзывы
            </a>

            @auth
                <a
                    href="{{ route('dashboard') }}"
                    wire:navigate
                    class="rounded-2xl px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Кабинет
                </a>

                @if (auth()->user()->isAdmin())
                    <a
                        href="{{ route('admin.applications') }}"
                        wire:navigate
                        class="rounded-2xl px-4 py-3 {{ request()->routeIs('admin.*') ? 'bg-orange-50 font-semibold text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}"
                    >
                        Админка
                    </a>
                @endif
            @endauth
        </nav>

        <div class="mt-auto">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-2xl px-4 py-3 text-left text-red-500 transition hover:bg-red-50">
                        Выйти
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="block rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100"
                >
                    Войти
                </a>
            @endauth
        </div>
    </aside>

    <div class="flex flex-1 flex-col">
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-100 bg-white/90 px-4 py-4 backdrop-blur sm:px-6 lg:px-10">
            <a href="{{ route('home') }}" wire:navigate class="text-base font-extrabold uppercase tracking-tight text-slate-800 lg:text-lg">
                Корочки
            </a>

            <div class="flex items-center gap-2">
                @auth
                    <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        {{ auth()->user()->role }}
                    </span>
                @else
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        class="rounded-xl border border-slate-200 px-3 py-1.5 text-sm text-slate-600 transition hover:bg-slate-50"
                    >
                        Войти
                    </a>
                @endauth
            </div>
        </header>

        <main class="flex-grow px-4 py-5 pb-24 sm:px-6 lg:px-10 lg:py-8 lg:pb-8">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 border-t border-slate-100 bg-white/95 px-4 py-3 backdrop-blur lg:hidden">
            <div class="mx-auto flex w-full max-w-md items-center justify-around text-xs font-medium">
                <a href="{{ route('home') }}" wire:navigate class="{{ request()->routeIs('home', 'welcom-page') ? 'text-orange-600' : 'text-slate-500' }}">
                    Главная
                </a>
                <a href="{{ route('reviews.index') }}" wire:navigate class="{{ request()->routeIs('reviews.index') ? 'text-orange-600' : 'text-slate-500' }}">
                    Отзывы
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'text-orange-600' : 'text-slate-500' }}">
                        Кабинет
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate class="text-slate-500">
                        Войти
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</div>

@livewireScripts
</body>
</html>
