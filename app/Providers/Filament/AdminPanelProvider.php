<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\BackupPage;
use App\Filament\Pages\EditProfile;
use App\Filament\Pages\ManageSettings;
use App\Http\Middleware\DemoMode;
use App\Models\AppSetting;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
    private function resolveBrandLogo(): ?string
    {
        $logoPath = rescue(fn () => AppSetting::current()->logo_path, null, false);

        if ($logoPath) {
            return Storage::disk('public')->url($logoPath);
        }

        return asset('images/bankbird-logo.png');
    }

    private function resolveLogoHeight(): string
    {
        return rescue(fn () => AppSetting::current()->logo_height, '4rem', false) ?? '4rem';
    }

    private function resolveFavicon(): ?string
    {
        $faviconPath = rescue(fn () => AppSetting::current()->favicon_path, null, false);

        if ($faviconPath) {
            return Storage::disk('public')->url($faviconPath);
        }

        return asset('images/bird.png');
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path(config('app.demo_mode', false) ? '' : 'admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->profile(EditProfile::class, isSimple: false)
            ->multiFactorAuthentication([
                AppAuthentication::make()->recoverable(),
            ])
            ->darkMode(false)
            ->font('Inter')
            ->brandName('BankBird')
            ->brandLogo(fn () => $this->resolveBrandLogo())
            ->brandLogoHeight(fn () => $this->resolveLogoHeight())
            ->favicon(fn () => $this->resolveFavicon())
            ->userMenuItems([
                MenuItem::make()
                    ->label('Instellingen')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->url(fn () => ManageSettings::getUrl()),
                MenuItem::make()
                    ->label('Backup')
                    ->icon('heroicon-o-archive-box')
                    ->url(fn () => BackupPage::getUrl()),
            ])
            ->colors([
                'primary' => Color::hex('#1E88E5'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,
                fn () => view('partials.sidebar-footer'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn () => view('partials.demo-banner'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                function (): string {
                    return <<<'HTML'
                    <script>
                    (function () {
                        var formatter = new Intl.NumberFormat('nl-NL', {
                            style: 'currency',
                            currency: 'EUR',
                            minimumFractionDigits: 2
                        });

                        function animateCounters() {
                            document.querySelectorAll('[data-counter="true"]').forEach(function (card) {
                                var target = parseFloat(card.getAttribute('data-counter-value'));
                                if (isNaN(target)) { return; }

                                var valueEl = card.querySelector('.fi-wi-stats-overview-stat-value');
                                if (!valueEl || valueEl.getAttribute('data-animated') === '1') { return; }
                                valueEl.setAttribute('data-animated', '1');

                                var isNeg   = target < 0;
                                var absTarget = Math.abs(target);
                                var duration  = 900;
                                var startTs   = null;

                                function step(ts) {
                                    if (!startTs) { startTs = ts; }
                                    var progress = Math.min((ts - startTs) / duration, 1);
                                    var eased    = 1 - Math.pow(1 - progress, 3);
                                    var current  = eased * absTarget * (isNeg ? -1 : 1);
                                    valueEl.textContent = formatter.format(current);
                                    if (progress < 1) { requestAnimationFrame(step); }
                                }

                                requestAnimationFrame(step);
                            });
                        }

                        document.addEventListener('DOMContentLoaded', animateCounters);
                        document.addEventListener('livewire:navigated', function () {
                            // Reset animated flags so counters re-run after navigation
                            document.querySelectorAll('[data-animated="1"]').forEach(function (el) {
                                el.removeAttribute('data-animated');
                            });
                            setTimeout(animateCounters, 80);
                        });
                    })();
                    </script>
                    HTML;
                },
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
            ])
            ->navigationGroups([
                NavigationGroup::make('Financiën'),
                NavigationGroup::make('Beheer'),
                NavigationGroup::make('Rapporten'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                DemoMode::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
