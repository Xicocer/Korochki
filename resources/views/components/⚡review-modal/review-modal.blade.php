<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 px-4" wire:click="close">
            <div
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                wire:click.stop
            >
                <h2 class="text-xl font-bold text-slate-800">
                    Оставить отзыв
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Поделитесь впечатлением о пройденном курсе
                </p>

                <textarea
                    wire:model="reviewText"
                    rows="5"
                    placeholder="Ваш отзыв..."
                    class="mt-4 w-full resize-none rounded-xl border border-slate-200 p-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300"
                ></textarea>

                @error('reviewText')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <div class="mt-5 flex justify-end gap-2">
                    <button
                        type="button"
                        wire:click="close"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200"
                    >
                        Отмена
                    </button>

                    <button
                        type="button"
                        wire:click="saveReview"
                        wire:loading.attr="disabled"
                        wire:target="saveReview"
                        class="rounded-xl bg-orange-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-700"
                    >
                        <span wire:loading.remove wire:target="saveReview">Сохранить</span>
                        <span wire:loading wire:target="saveReview">Сохраняем...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
