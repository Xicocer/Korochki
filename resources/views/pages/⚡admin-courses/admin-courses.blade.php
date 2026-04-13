<div class="space-y-6">
    <h1 class="text-2xl font-bold text-slate-800">Управление курсами</h1>

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

    <form wire:submit="save" class="space-y-4 rounded-2xl border border-slate-100 bg-white p-6 shadow">
        <h2 class="text-lg font-semibold text-slate-700">Добавить новый курс</h2>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-600">Название курса</label>
                <input
                    type="text"
                    wire:model.live.debounce.250ms="title"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600">Описание</label>
                <textarea
                    rows="3"
                    wire:model.live.debounce.250ms="description"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                ></textarea>
                @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="save"
            class="rounded-xl bg-orange-600 px-4 py-2 font-semibold text-white transition hover:bg-orange-700"
        >
            <span wire:loading.remove wire:target="save">Добавить курс</span>
            <span wire:loading wire:target="save">Сохраняем...</span>
        </button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white p-4 shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Название</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Описание</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Заявок</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($courses as $course)
                    <tr wire:key="admin-course-{{ $course->id }}">
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $course->title }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $course->description ?: '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $course->applications_count }}</td>
                        <td class="px-4 py-2">
                            <button
                                type="button"
                                wire:click="deleteCourse({{ $course->id }})"
                                wire:confirm="Удалить курс {{ $course->title }}?"
                                class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-600 transition hover:bg-red-200"
                            >
                                Удалить
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                            Пока нет курсов
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
