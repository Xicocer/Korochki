<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @php
        $pageTitle = $title ?? 'Корочки.есть';
        $metaDescription = $metaDescription ?? 'Онлайн-запись на курсы дополнительного профессионального образования.';
        $metaKeywords = $metaKeywords ?? 'курсы, обучение, дополнительное образование, онлайн-запись';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 antialiased">

<div class="mx-auto flex min-h-screen w-full overflow-hidden bg-white shadow-2xl lg:my-6 lg:max-w-7xl lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-slate-300/40">

    <aside class="hidden w-72 flex-col border-r border-slate-200 bg-slate-50 px-6 py-8 lg:flex">

        <a href="/" wire:navigate class="mb-10 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-600 shadow-lg shadow-orange-200">
                <span class="text-sm font-black text-white">К.Е</span>
            </div>
            <span class="text-xl font-extrabold uppercase tracking-tight text-slate-800">Корочки</span>
        </a>

        <nav class="flex flex-col gap-3">

            <a href="/" wire:navigate
               class="flex items-center gap-3 rounded-2xl px-4 py-3 {{ request()->is('/') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                <span>🏠</span>
                <span>Главная</span>
            </a>

            @auth
                <a href="/dashboard" wire:navigate
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 {{ request()->is('dashboard*') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span>📄</span>
                    <span>Заявки</span>
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.applications') }}" wire:navigate
                       class="flex items-center gap-3 rounded-2xl px-4 py-3 {{ request()->is('admin*') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span>⚙️</span>
                        <span>Админ</span>
                    </a>
                @endif
            @endauth

        </nav>

        <div class="mt-auto">

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-red-500 transition hover:bg-red-50">
                        <span>🚪</span>
                        <span>Выход</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" wire:navigate
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 hover:bg-slate-100">
                    <span>🔑</span>
                    <span>Войти</span>
                </a>
            @endauth

        </div>

    </aside>

    <div class="flex flex-1 flex-col">

        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-100 bg-white/90 px-6 py-4 backdrop-blur-md lg:px-10 lg:py-5">

            <div class="flex items-center gap-2 lg:hidden">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-600 shadow-lg shadow-orange-200">
                    <span class="text-xs font-black text-white">К.Е</span>
                </div>
                <span class="text-lg font-extrabold uppercase tracking-tight text-slate-800">Корочки</span>
            </div>

            @auth
                <div class="ml-auto flex items-center gap-3">
                    <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            @endauth

        </header>

        <main class="flex-grow px-4 py-5 lg:px-10 lg:py-8">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 border-t border-slate-100 bg-white/95 px-6 py-3 pb-8 backdrop-blur lg:hidden">
            <div class="mx-auto flex w-full items-center justify-around">

                <a href="/" wire:navigate class="flex flex-col items-center {{ request()->is('/') ? 'text-orange-600' : 'text-slate-400' }}">
                    <span class="text-xl">🏠</span>
                    <span class="mt-1 text-[10px] font-medium">Главная</span>
                </a>

                @auth
                    <a href="/dashboard" wire:navigate class="flex flex-col items-center {{ request()->is('dashboard*') ? 'text-orange-600' : 'text-slate-400' }}">
                        <span class="text-xl">📄</span>
                        <span class="mt-1 text-[10px] font-medium">Заявки</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.applications') }}" wire:navigate class="flex flex-col items-center {{ request()->is('admin*') ? 'text-orange-600' : 'text-slate-400' }}">
                            <span class="text-xl">⚙️</span>
                            <span class="mt-1 text-[10px] font-medium">Админ</span>
                        </a>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" wire:navigate class="flex flex-col items-center text-slate-400">
                        <span class="text-xl">🔑</span>
                        <span class="mt-1 text-[10px] font-medium">Войти</span>
                    </a>
                @endguest

            </div>
        </nav>

    </div>
</div>

@livewireScripts
</body>
</html>
