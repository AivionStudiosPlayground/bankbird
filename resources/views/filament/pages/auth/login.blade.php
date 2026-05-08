<div class="bb-login-outer">
    <div class="bb-login-container">

        {{-- Left card: login form --}}
        <div class="bb-login-form-card">
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

            <div class="bb-login-form-inner @class(['bb-login-form-inner--admin' => ! \App\Support\Demo::active()])">
                @if ($this->hasLogo())
                    @if (! \App\Support\Demo::active())
                        <div class="bb-login-logo-wrapper">
                            <x-filament-panels::logo />
                        </div>
                    @else
                        <x-filament-panels::logo />
                    @endif
                @endif

                @if (filled($this->getHeading()) || filled($this->getSubheading()))
                    <x-filament-panels::header.simple
                        :heading="$this->getHeading()"
                        :subheading="$this->getSubheading()"
                        :logo="false"
                    />
                @endif

                <div class="fi-simple-page-content">
                    {{ $this->content }}
                </div>
            </div>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
        </div>

        {{-- Right card: image with caption --}}
        <div class="bb-login-image-card">
            <img
                src="{{ asset('images/login.png') }}"
                alt="BankBird"
                class="bb-login-image"
            />
            <div class="bb-login-caption">
                <p class="bb-login-caption-text">Welkom bij BankBird</p>
            </div>
        </div>

    </div>

    @if (! \App\Support\Demo::active())
        <footer class="bb-login-footer">
            BankBird v{{ config('app.version') }}<br />
            Built with care by Aivion Studios
        </footer>
    @endif

    @if (! $this instanceof \Filament\Tables\Contracts\HasTable)
        <x-filament-actions::modals />
    @endif
</div>
