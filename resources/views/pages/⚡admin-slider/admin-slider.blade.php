<div class="space-y-6">

    <h1 class="text-2xl font-bold text-slate-800">Управление слайдером</h1>

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
        <h2 class="text-lg font-semibold text-slate-700">Добавить новый слайд</h2>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-600">Заголовок</label>
                <input
                    type="text"
                    wire:model="title"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600">Описание</label>
                <input
                    type="text"
                    wire:model="description"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600">Порядок</label>
                <input
                    type="number"
                    wire:model="order"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                @error('order')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600">Активность</label>
                <select
                    wire:model="is_active"
                    class="mt-1 block w-full rounded-xl border border-slate-200 p-2 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                    <option value="1">Активный</option>
                    <option value="0">Неактивный</option>
                </select>
                @error('is_active')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600">Изображение</label>
                <input type="file" wire:model="image" class="mt-1 block w-full">
                @error('image')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror

                <div wire:loading wire:target="image" class="mt-2 text-sm text-slate-500">
                    Загружаем изображение...
                </div>

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="preview" class="mt-3 h-24 w-40 rounded-lg object-cover">
                @endif
            </div>
        </div>

        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="save"
            class="rounded-xl bg-orange-600 px-4 py-2 font-semibold text-white transition hover:bg-orange-700"
        >
            <span wire:loading.remove wire:target="save">Добавить слайд</span>
            <span wire:loading wire:target="save">Сохраняем...</span>
        </button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white p-4 shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Заголовок</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Описание</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Порядок</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Картинка</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Активность</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-slate-600">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($slides as $slide)
                    <tr wire:key="slide-{{ $slide->id }}" class="hover:bg-slate-50 transition">
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $slide->title }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $slide->description }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $slide->order }}</td>
                        <td class="px-4 py-2">
                            <img
                                src="{{ asset('storage/' . $slide->image_path) }}"
                                alt="{{ $slide->title }}"
                                class="h-16 w-24 rounded-lg object-cover"
                            >
                        </td>
                        <td class="px-4 py-2">
                            <button
                                type="button"
                                wire:click="toggleActive({{ $slide->id }})"
                                class="rounded-xl px-3 py-1 text-sm transition {{ $slide->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}"
                            >
                                {{ $slide->is_active ? 'Активный' : 'Неактивный' }}
                            </button>
                        </td>
                        <td class="px-4 py-2">
                            <button
                                type="button"
                                wire:click="deleteSlide({{ $slide->id }})"
                                wire:confirm="Удалить слайд #{{ $slide->id }}?"
                                class="rounded-xl bg-red-100 px-3 py-1 text-sm text-red-600 transition hover:bg-red-200"
                            >
                                Удалить
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                            Пока нет слайдов
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
