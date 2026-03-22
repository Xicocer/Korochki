<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
<body class="h-full bg-slate-50 antialiased">
    
    <div class="mx-auto min-h-full max-w-[430px] bg-white shadow-2xl shadow-slate-200 flex flex-col relative">
        
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 py-4 flex justify-between items-center">
            <a href="/" wire:navigate class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center shadow-lg shadow-orange-200">
                    <span class="text-white font-black text-xs">К.Е</span>
                </div>
                <span class="font-extrabold text-lg tracking-tight text-slate-800 uppercase">Корочки</span>
            </a>

            @auth
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-bold py-1 px-2 bg-slate-100 rounded-full text-slate-500 uppercase tracking-widest">
                        {{ auth()->user()->role }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                </div>
            @endauth
        </header>

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <nav class="sticky bottom-0 bg-white border-t border-slate-100 px-6 py-3 pb-8 flex justify-around items-center">
            <a href="/" wire:navigate class="flex flex-col items-center {{ request()->is('/') ? 'text-orange-600' : 'text-slate-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span class="text-[10px] font-medium mt-1">Главная</span>
            </a>
            
            @auth
                <a href="/dashboard" wire:navigate class="flex flex-col items-center {{ request()->is('dashboard*') ? 'text-orange-600' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    <span class="text-[10px] font-medium mt-1">Заявки</span>
                </a>
                
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.applications') }}" wire:navigate class="flex flex-col items-center {{ request()->is('admin*') ? 'text-orange-600' : 'text-slate-400' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    <span class="text-[10px] font-medium mt-1">Админ</span>
                </a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" wire:navigate class="flex flex-col items-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    <span class="text-[10px] font-medium mt-1">Войти</span>
                </a>
            @endguest
        </nav>
    </div>

</body>
</html>
