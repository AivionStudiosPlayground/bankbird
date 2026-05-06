@if(config('app.demo_mode', false))
    <div
        x-data="{ visible: true }"
        x-show="visible"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 max-h-16"
        x-transition:leave-end="opacity-0 max-h-0"
        class="relative z-50 w-full overflow-hidden"
        style="background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%); border-bottom: 1px solid #d97706;"
    >
        <div class="flex items-center justify-center gap-x-3 px-6 py-2.5 text-sm font-medium text-amber-900">
            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <span>
                <strong>Demo-modus</strong> &mdash; Je bekijkt een live voorbeeld van BankBird met nep-data. Wijzigingen zijn uitgeschakeld.
            </span>
            <button
                @click="visible = false"
                class="absolute right-4 top-1/2 -translate-y-1/2 rounded p-0.5 opacity-70 transition hover:opacity-100"
                aria-label="Sluiten"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif
