<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Корочки.есть' }}</title>

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
<body class="bg-slate-100 min-h-screen text-slate-800">

    <div class="max-w-md mx-auto min-h-screen bg-white shadow-xl relative overflow-hidden">

        <header class="px-6 py-5 border-b border-slate-100 bg-white sticky top-0 z-10">
            <h1 class="text-lg font-bold tracking-tight text-slate-800">
                Учебный портал
            </h1>
        </header>

        <main class="px-4 py-5 pb-24">
            {{ $slot }}
        </main>

        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <div class="max-w-md mx-auto flex justify-around items-center py-3">

                <a
                    href="{{ route('dashboard') }}"
                    wire:navigate
                    class="flex flex-col items-center gap-1 text-slate-600 hover:text-orange-600 transition"
                >
                    <span class="text-xl">📄</span>
                    <span class="text-xs font-medium">Мои заявки</span>
                </a>

                <a
                    href="{{ route('applications.create') }}"
                    wire:navigate
                    class="flex flex-col items-center gap-1 text-slate-600 hover:text-orange-600 transition"
                >
                    <span class="text-xl">🎓</span>
                    <span class="text-xs font-medium">Курсы</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex flex-col items-center gap-1 text-red-500 hover:text-red-600 transition"
                    >
                        <span class="text-xl">🚪</span>
                        <span class="text-xs font-medium">Выход</span>
                    </button>
                </form>

            </div>
        </nav>

    </div>

    @livewireScripts
</body>
</html>
