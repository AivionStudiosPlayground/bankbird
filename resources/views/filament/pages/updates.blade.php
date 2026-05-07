<x-filament-panels::page>
    @php
        $current = $this->getCurrentVersion();
        $releaseDate = $this->getReleaseDate();
        $latestRelease = $this->getLatestRelease();
        $hasUpdate = $this->hasUpdate();
        $repoUrl = $this->getRepositoryUrl();
        $updatePrompt = $this->getUpdatePrompt();
        $releaseNotesHtml = $this->getReleaseNotesHtml();
    @endphp

    <div class="space-y-6">

        {{-- Status card --}}
        <x-filament::section>
            <x-slot name="heading">Versie-overzicht</x-slot>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Geïnstalleerd</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">v{{ $current }}</div>
                    @if ($releaseDate)
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Uitgebracht: {{ $releaseDate }}</div>
                    @endif
                </div>

                <div @class([
                    'rounded-xl border p-4',
                    'border-orange-300 bg-orange-50 dark:bg-orange-900/20 dark:border-orange-700' => $hasUpdate,
                    'border-emerald-300 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-700' => ! $hasUpdate && $latestRelease !== null,
                    'border-gray-200 dark:border-gray-700' => $latestRelease === null,
                ])>
                    <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                        @if ($latestRelease)
                            Laatste release op GitHub
                        @else
                            Update-check
                        @endif
                    </div>
                    @if ($latestRelease)
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">v{{ $latestRelease['tag'] }}</div>
                        <div class="text-xs mt-1 {{ $hasUpdate ? 'text-orange-700 dark:text-orange-300 font-semibold' : 'text-emerald-700 dark:text-emerald-300 font-semibold' }}">
                            @if ($hasUpdate)
                                ↑ Update beschikbaar
                            @else
                                ✓ Je draait de laatste versie
                            @endif
                        </div>
                    @else
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Kon GitHub niet bereiken om naar updates te zoeken. Controleer je internetverbinding of bezoek
                            <a href="{{ $repoUrl }}/releases" target="_blank" rel="noopener" class="text-primary-600 dark:text-primary-400 underline">de releases-pagina</a> handmatig.
                        </div>
                    @endif
                </div>
            </div>
        </x-filament::section>

        {{-- Update beschikbaar — instructies --}}
        @if ($hasUpdate)
            <x-filament::section>
                <x-slot name="heading">Hoe update je BankBird?</x-slot>

                <div class="space-y-5">

                    <div class="rounded-xl bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 dark:from-blue-700 dark:via-blue-800 dark:to-blue-900 p-5 text-white">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs uppercase tracking-wider font-bold opacity-80">Aanbevolen</span>
                            <span class="text-xs">·</span>
                            <span class="text-xs">via Claude of Codex</span>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Eén prompt, AI doet de rest</h3>
                        <p class="text-sm opacity-90 mb-4">
                            Open Claude Code of Codex CLI in je BankBird-projectmap en geef deze prompt:
                        </p>
                        <div class="bg-black/30 rounded-lg p-3 font-mono text-sm break-all" id="bb-update-prompt-text">
                            {{ $updatePrompt }}
                        </div>
                        <button type="button"
                                onclick="window.bbCopyUpdatePrompt(this)"
                                class="mt-3 inline-flex items-center gap-2 bg-white text-blue-700 font-bold text-sm rounded-lg px-4 py-2 hover:bg-blue-50 transition">
                            📋 Kopieer prompt
                        </button>
                    </div>

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-3">Of handmatig (voor ontwikkelaars)</h3>
                        <pre class="bg-gray-900 text-gray-100 rounded-lg p-4 text-xs overflow-x-auto"><code>git pull origin master
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm install &amp;&amp; npm run build
php artisan config:cache
php artisan view:cache
php artisan event:cache</code></pre>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Maak <strong>altijd eerst een backup</strong> van je database voordat je update.
                        </p>
                    </div>

                </div>
            </x-filament::section>
        @endif

        {{-- Release notes --}}
        @if ($latestRelease)
            <x-filament::section>
                <x-slot name="heading">
                    Release notes
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">— {{ $latestRelease['name'] ?: 'v'.$latestRelease['tag'] }}</span>
                </x-slot>

                @if ($releaseNotesHtml)
                    <div class="prose prose-sm dark:prose-invert max-w-none">
                        {!! $releaseNotesHtml !!}
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Geen release notes beschikbaar.</p>
                @endif

                @if ($latestRelease['url'] ?? null)
                    <div class="mt-4">
                        <a href="{{ $latestRelease['url'] }}" target="_blank" rel="noopener" class="text-sm text-primary-600 dark:text-primary-400 underline">
                            Volledige release op GitHub →
                        </a>
                    </div>
                @endif
            </x-filament::section>
        @endif

    </div>

    <script>
        window.bbCopyUpdatePrompt = function (btn) {
            var text = document.getElementById('bb-update-prompt-text').innerText.trim();
            var done = function () {
                var original = btn.innerHTML;
                btn.innerHTML = '✅ Gekopieerd!';
                setTimeout(function () { btn.innerHTML = original; }, 2500);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done);
            } else {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.style.cssText = 'position:fixed;top:-9999px;opacity:0;';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        };
    </script>
</x-filament-panels::page>
