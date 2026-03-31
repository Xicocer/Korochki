<div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Управление пользователями</h1>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white p-4 shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Логин</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">ФИО</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Телефон</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Роль</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($users as $user)
                    <tr wire:key="admin-user-{{ $user->id }}">
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->login }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->full_name }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->phone }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->role }}</td>
                        <td class="px-4 py-2">
                            <button
                                type="button"
                                wire:click="deleteUser({{ $user->id }})"
                                wire:confirm="Удалить пользователя {{ $user->login }}?"
                                class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-600 transition hover:bg-red-200"
                            >
                                Удалить
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                            Нет пользователей для отображения
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
