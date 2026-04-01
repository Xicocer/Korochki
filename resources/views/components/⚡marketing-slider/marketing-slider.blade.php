<div>
    @if ($slides->isEmpty())
        <div class="flex h-56 items-center justify-center rounded-3xl border border-dashed border-slate-300 bg-slate-100 px-6 text-center text-sm text-slate-400 shadow-inner md:h-64 lg:h-72">
            Маркетинговые слайды появятся здесь
        </div>
    @else
        <div
            x-data="{
                current: 0,
                total: {{ $slides->count() }},
                timer: null,
                next() {
                    if (this.total < 2) return
                    this.current = (this.current + 1) % this.total
                },
                prev() {
                    if (this.total < 2) return
                    this.current = (this.current - 1 + this.total) % this.total
                },
                start() {
                    if (this.total < 2 || this.timer) return
                    this.timer = setInterval(() => this.next(), 5000)
                },
                stop() {
                    if (! this.timer) return
                    clearInterval(this.timer)
                    this.timer = null
                },
                init() {
                    this.start()
                }
            }"
            @mouseenter="stop()"
            @mouseleave="start()"
            class="relative h-56 overflow-hidden rounded-3xl bg-slate-100 shadow-xl shadow-orange-100/60 md:h-64 lg:h-72"
        >
            @foreach ($slides as $index => $slide)
                <article
                    x-cloak
                    x-show="current === {{ $index }}"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-[1.02]"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-[0.98]"
                    class="absolute inset-0"
                    wire:key="marketing-slide-{{ $slide->id }}"
                >
                    <img
                        src="{{ $slide->image_url }}"
                        alt="{{ $slide->title }}"
                        class="h-full w-full object-cover"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/40 to-slate-900/5"></div>

                    <div class="absolute inset-x-0 bottom-0 p-5 text-white lg:p-7">
                        <h3 class="text-lg font-bold leading-tight lg:text-2xl">
                            {{ $slide->title }}
                        </h3>

                        <p class="mt-1 line-clamp-2 text-sm text-white/85 lg:text-base">
                            {{ $slide->description }}
                        </p>
                    </div>
                </article>
            @endforeach

            @if ($slides->count() > 1)
                <button
                    type="button"
                    @click="prev(); stop(); start()"
                    class="absolute left-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-lg text-slate-700 shadow-lg transition hover:bg-white lg:h-12 lg:w-12 lg:text-xl"
                    aria-label="Previous slide"
                >
                    &larr;
                </button>

                <button
                    type="button"
                    @click="next(); stop(); start()"
                    class="absolute right-3 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-lg text-slate-700 shadow-lg transition hover:bg-white lg:h-12 lg:w-12 lg:text-xl"
                    aria-label="Next slide"
                >
                    &rarr;
                </button>

                <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 items-center gap-2 rounded-full bg-slate-950/25 px-3 py-2 backdrop-blur-sm">
                    @foreach ($slides as $index => $slide)
                        <button
                            type="button"
                            @click="current = {{ $index }}; stop(); start()"
                            class="h-2.5 rounded-full transition"
                            :class="current === {{ $index }} ? 'w-6 bg-white' : 'w-2.5 bg-white/45'"
                            aria-label="Go to slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
