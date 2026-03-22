<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Админка | Корочки.есть' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Tailwind через CDN для админки -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-slate-50">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
            <div class="p-6 flex items-center gap-2 border-b border-slate-200">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center shadow-lg shadow-orange-200">
                    <span class="text-white font-black text-sm">К.Е</span>
                </div>
                <span class="font-extrabold text-lg tracking-tight text-slate-800 uppercase">Админка</span>
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.applications') }}" class="block px-4 py-2 rounded-xl hover:bg-orange-50 transition {{ request()->routeIs('admin.applications') ? 'bg-orange-100 font-semibold' : '' }}">
                    Заявки
                </a>
                <a href="{{ route('admin.slides') }}" class="block px-4 py-2 rounded-xl hover:bg-orange-50 transition {{ request()->routeIs('admin.slides') ? 'bg-orange-100 font-semibold' : '' }}">
                    Слайдер
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-xl hover:bg-orange-50 transition {{ request()->routeIs('admin.users') ? 'bg-orange-100 font-semibold' : '' }}">
                    Пользователи
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 mt-4 rounded-xl hover:bg-red-50 text-red-500 font-medium transition">
                        Выйти
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-8 overflow-auto">
            {{ $slot }}
        </main>

    </div>

    @livewireScripts
</body>
</html>
