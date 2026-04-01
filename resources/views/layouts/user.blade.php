<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @php
        $pageTitle = $title ?? 'Корочки.есть';
        $metaDescription = $metaDescription ?? 'Личный кабинет пользователя для управления заявками и обучением.';
        $metaKeywords = $metaKeywords ?? 'личный кабинет, заявки, курсы, обучение';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="noindex,nofollow">

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
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">

<div class="mx-auto flex min-h-screen w-full overflow-hidden bg-white shadow-xl lg:my-6 lg:max-w-7xl lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-2xl lg:shadow-slate-300/40">

    <aside class="hidden w-72 flex-col border-r border-slate-200 bg-slate-50 px-6 py-8 lg:flex">
        <h1 class="mb-10 text-xl font-bold text-slate-800">
            Учебный портал
        </h1>

        <nav class="flex flex-col gap-3">

            <a
                href="{{ route('dashboard') }}"
                wire:navigate
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-700 transition hover:bg-orange-50 hover:text-orange-600"
            >
                <span class="text-xl">📄</span>
                <span class="font-medium">Мои заявки</span>
            </a>

            <a
                href="{{ route('applications.create') }}"
                wire:navigate
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-700 transition hover:bg-orange-50 hover:text-orange-600"
            >
                <span class="text-xl">🎓</span>
                <span class="font-medium">Курсы</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-red-500 transition hover:bg-red-50"
                >
                    <span class="text-xl">🚪</span>
                    <span class="font-medium">Выход</span>
                </button>
            </form>

        </nav>
    </aside>

    <div class="flex flex-1 flex-col">

        <header class="sticky top-0 z-10 border-b border-slate-100 bg-white px-6 py-5 lg:px-10">
            <h1 class="text-lg font-bold tracking-tight text-slate-800">
                Учебный портал
            </h1>
        </header>

        <main class="flex-1 px-4 py-5 pb-24 sm:px-6 lg:px-10 lg:py-8 lg:pb-8">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 border-t border-slate-200 bg-white/95 px-4 py-3 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] backdrop-blur lg:hidden">
            <div class="mx-auto flex w-full max-w-md items-center justify-around py-1">

                <a
                    href="{{ route('dashboard') }}"
                    wire:navigate
                    class="flex flex-col items-center gap-1 text-slate-600 transition hover:text-orange-600"
                >
                    <span class="text-xl">📄</span>
                    <span class="text-xs font-medium">Мои заявки</span>
                </a>

                <a
                    href="{{ route('applications.create') }}"
                    wire:navigate
                    class="flex flex-col items-center gap-1 text-slate-600 transition hover:text-orange-600"
                >
                    <span class="text-xl">🎓</span>
                    <span class="text-xs font-medium">Курсы</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex flex-col items-center gap-1 text-red-500 transition hover:text-red-600"
                    >
                        <span class="text-xl">🚪</span>
                        <span class="text-xs font-medium">Выход</span>
                    </button>
                </form>

            </div>
        </nav>

    </div>
</div>

@livewireScripts
</body>
</html>
