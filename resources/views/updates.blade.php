@extends('layouts.public')

@section('title', 'Updates & Roadmap — BankBird')
@section('description', 'Wat er nu in BankBird zit en wat er aankomt. Volg de ontwikkeling van nieuwe bankformaten, exportfuncties en meer.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;left:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.07) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">🗺️ Roadmap</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Wat er is &<br>wat er aankomt
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0;max-width:520px;line-height:1.65;">
                    BankBird groeit. Dit is eerlijk overzicht van wat er nu werkt en wat er op de planning staat. Geen marketing, gewoon de feiten.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4.5s ease-in-out infinite;">
                <img src="{{ asset('images/bird.png') }}" alt="BankBird" class="bb-hero-img" style="height:180px;width:auto;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.25));">
            </div>
        </div>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

<section style="background:#F0F6FF;padding:3rem 1.5rem 6rem;">
    <div class="bb-wrap">

        {{-- Versie badge --}}
        <div style="text-align:center;margin-bottom:2rem;" class="reveal">
            <div style="display:inline-flex;align-items:center;gap:0.75rem;background:white;border:1px solid rgba(30,136,229,0.15);border-radius:99px;padding:0.5rem 1.25rem 0.5rem 0.75rem;box-shadow:0 4px 16px rgba(30,136,229,0.08);">
                <span style="background:#16C784;color:white;font-size:0.6875rem;font-weight:800;padding:0.2rem 0.625rem;border-radius:99px;text-transform:uppercase;letter-spacing:0.06em;">v{{ config('app.version') }} — Actueel</span>
                <span style="font-size:0.875rem;color:#6B7A99;font-weight:500;">Laatste update: {{ \Carbon\Carbon::parse(config('app.release_date'))->locale('nl')->translatedFormat('F Y') }}</span>
            </div>
        </div>

        {{-- Geavanceerde update card --}}
        <div style="max-width:640px;margin:0 auto 3rem;" class="reveal">
            <a href="{{ route('updates.technisch') }}" style="display:block;background:linear-gradient(135deg,#FFF3E0,#FFE9D1);border:1px solid rgba(255,138,61,0.25);border-radius:1.25rem;padding:1.25rem 1.5rem;text-decoration:none;color:inherit;box-shadow:0 4px 16px rgba(255,138,61,0.1);transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(255,138,61,0.18)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(255,138,61,0.1)'">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#FF8A3D,#E65100);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;box-shadow:0 4px 12px rgba(255,138,61,0.3);">⚙️</div>
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;flex-wrap:wrap;">
                            <span style="font-size:0.65rem;font-weight:800;color:#BF360C;text-transform:uppercase;letter-spacing:0.08em;background:white;padding:0.15rem 0.5rem;border-radius:99px;">Geavanceerde update</span>
                            <span style="font-size:0.65rem;font-weight:700;color:#BF360C;text-transform:uppercase;letter-spacing:0.08em;">Vereist actie</span>
                        </div>
                        <div style="font-size:1rem;font-weight:800;color:#0B1F3A;margin-bottom:0.25rem;">Kritieke updates voor selfhost installs</div>
                        <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">Technische uitleg over de databasewissel-middleware, demo-mode-fallbacks en sessie-isolatie. Lees dit voor je je instance bijwerkt.</div>
                    </div>
                    <div style="font-size:1.25rem;color:#FF8A3D;flex-shrink:0;">→</div>
                </div>
            </a>
        </div>

        <div class="bb-grid-2" style="align-items:start;">

            {{-- ══ LINKS: WAT ER IN ZIT ══ --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#16C784,#0A9660);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(22,199,132,0.3);">✅</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Wat er nu in zit</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Volledig werkend in v{{ config('app.version') }}</p>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:0.75rem;">

                    {{-- Categorie: Importeren --}}
                    <div class="bb-card-flat" style="overflow:hidden;">
                        <div style="background:#F0FFF8;padding:0.625rem 1.25rem;border-bottom:1px solid rgba(22,199,132,0.12);">
                            <span style="font-size:0.75rem;font-weight:800;color:#0A9660;text-transform:uppercase;letter-spacing:0.07em;">🏦 Bankafschriften</span>
                        </div>
                        <div style="padding:0.75rem 1.25rem;display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                'ING — PDF import',
                                'ING — CSV import',
                                'SNS — PDF import',
                                'Knab — PDF import',
                                'Automatische bankdetectie bij PDF-upload',
                            ] as $item)
                            <div style="display:flex;align-items:center;gap:0.625rem;">
                                <span style="color:#16C784;font-size:1rem;flex-shrink:0;">✓</span>
                                <span style="font-size:0.875rem;color:#0B1F3A;font-weight:500;">{{ $item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Categorie: AI --}}
                    <div class="bb-card-flat" style="overflow:hidden;">
                        <div style="background:#F0FFF8;padding:0.625rem 1.25rem;border-bottom:1px solid rgba(22,199,132,0.12);">
                            <span style="font-size:0.75rem;font-weight:800;color:#0A9660;text-transform:uppercase;letter-spacing:0.07em;">🤖 AI & Categorisatie</span>
                        </div>
                        <div style="padding:0.75rem 1.25rem;display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                'AI-categorisatie via Claude (Anthropic)',
                                'AI-categorisatie via OpenAI (GPT)',
                                'Merchant-patroonherkenning via regex',
                                'Handmatig categoriseren',
                                'Categorie-leren op basis van feedback',
                            ] as $item)
                            <div style="display:flex;align-items:center;gap:0.625rem;">
                                <span style="color:#16C784;font-size:1rem;flex-shrink:0;">✓</span>
                                <span style="font-size:0.875rem;color:#0B1F3A;font-weight:500;">{{ $item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Categorie: Rapporten --}}
                    <div class="bb-card-flat" style="overflow:hidden;">
                        <div style="background:#F0FFF8;padding:0.625rem 1.25rem;border-bottom:1px solid rgba(22,199,132,0.12);">
                            <span style="font-size:0.75rem;font-weight:800;color:#0A9660;text-transform:uppercase;letter-spacing:0.07em;">📊 Rapporten & Overzicht</span>
                        </div>
                        <div style="padding:0.75rem 1.25rem;display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                'Maandoverzicht met inkomsten/uitgaven',
                                'Jaaroverzicht',
                                'Uitgaven per categorie',
                                'Transactiebeheer met filters',
                                'Zoeken in transacties',
                            ] as $item)
                            <div style="display:flex;align-items:center;gap:0.625rem;">
                                <span style="color:#16C784;font-size:1rem;flex-shrink:0;">✓</span>
                                <span style="font-size:0.875rem;color:#0B1F3A;font-weight:500;">{{ $item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Categorie: Beheer --}}
                    <div class="bb-card-flat" style="overflow:hidden;">
                        <div style="background:#F0FFF8;padding:0.625rem 1.25rem;border-bottom:1px solid rgba(22,199,132,0.12);">
                            <span style="font-size:0.75rem;font-weight:800;color:#0A9660;text-transform:uppercase;letter-spacing:0.07em;">⚙️ Beheer</span>
                        </div>
                        <div style="padding:0.75rem 1.25rem;display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                'Multi-user ondersteuning',
                                'Tweefactorauthenticatie (2FA)',
                                'Categoriebeheer (hiërarchisch)',
                                'Merchantbeheer',
                                'Importgeschiedenis',
                                'Volledige back-up & herstel',
                                'Vriendelijke 404 & 403 foutpagina\'s',
                                'Demo-modus met duidelijke read-only meldingen',
                            ] as $item)
                            <div style="display:flex;align-items:center;gap:0.625rem;">
                                <span style="color:#16C784;font-size:1rem;flex-shrink:0;">✓</span>
                                <span style="font-size:0.875rem;color:#0B1F3A;font-weight:500;">{{ $item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ RECHTS: WAT ER AANKOMT ══ --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#FF8A3D,#E65100);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(255,138,61,0.3);">🚀</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Wat er aankomt</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Op de planning voor komende versies</p>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:0.875rem;">

                    {{-- In ontwikkeling --}}
                    <div style="background:white;border:1px solid rgba(255,138,61,0.2);border-radius:1.25rem;overflow:hidden;">
                        <div style="background:linear-gradient(135deg,#FFF3E0,#FFF8F0);padding:0.75rem 1.25rem;border-bottom:1px solid rgba(255,138,61,0.12);display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.75rem;font-weight:800;color:#BF360C;text-transform:uppercase;letter-spacing:0.07em;">🚧 In ontwikkeling</span>
                            <span style="font-size:0.6875rem;background:#FF8A3D;color:white;padding:0.15rem 0.5rem;border-radius:99px;font-weight:700;">Binnenkort</span>
                        </div>
                        <div style="padding:1rem 1.25rem;display:flex;flex-direction:column;gap:0.875rem;">
                            @foreach([
                                ['🏦', 'Rabobank CSV import', 'Parser voor het Rabobank bankafschriftformaat'],
                                ['🏦', 'ABN AMRO import', 'Ondersteuning voor ABN AMRO MT940 en CSV'],
                                ['📤', 'CSV export', 'Exporteer gefilterde transacties als CSV voor Excel'],
                                ['⚡', 'Essent maandverslag', 'Gas- en elektraverbruik inzichtelijk naast je bankdata'],
                                ['📄', 'PDF export van rapporten', 'Exporteer je maand- of jaaroverzicht als mooi opgemaakt PDF'],
                            ] as [$icon, $title, $desc])
                            <div style="display:flex;gap:0.875rem;align-items:flex-start;">
                                <div style="width:2.25rem;height:2.25rem;background:#FFF3E0;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">{{ $icon }}</div>
                                <div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#0B1F3A;">{{ $title }}</div>
                                    <div style="font-size:0.8125rem;color:#6B7A99;margin-top:0.125rem;">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Gepland --}}
                    <div style="background:white;border:1px solid rgba(30,136,229,0.15);border-radius:1.25rem;overflow:hidden;">
                        <div style="background:#EEF5FF;padding:0.75rem 1.25rem;border-bottom:1px solid rgba(30,136,229,0.1);display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.75rem;font-weight:800;color:#1565C0;text-transform:uppercase;letter-spacing:0.07em;">📋 Gepland</span>
                            <span style="font-size:0.6875rem;background:#1E88E5;color:white;padding:0.15rem 0.5rem;border-radius:99px;font-weight:700;">v2.1 — v3.0</span>
                        </div>
                        <div style="padding:1rem 1.25rem;display:flex;flex-direction:column;gap:0.875rem;">
                            @foreach([
                                ['🏦', 'Bunq import', 'Koppeling met Bunq exportformaat'],
                                ['📤', 'Excel export', 'Exporteer naar .xlsx voor uitgebreide analyse'],
                                ['🔁', 'Terugkerende transacties', 'Herken en markeer automatische incasso\'s en abonnementen'],
                                ['💡', 'Spaardoelen', 'Stel doelen in en volg je voortgang per categorie'],
                                ['📱', 'Mobiele weergave', 'Volledig geoptimaliseerd admin panel op telefoon'],
                            ] as [$icon, $title, $desc])
                            <div style="display:flex;gap:0.875rem;align-items:flex-start;">
                                <div style="width:2.25rem;height:2.25rem;background:#EEF5FF;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">{{ $icon }}</div>
                                <div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#0B1F3A;">{{ $title }}</div>
                                    <div style="font-size:0.8125rem;color:#6B7A99;margin-top:0.125rem;">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Ideeën --}}
                    <div style="background:white;border:1px solid rgba(124,58,237,0.15);border-radius:1.25rem;overflow:hidden;">
                        <div style="background:#F5F0FF;padding:0.75rem 1.25rem;border-bottom:1px solid rgba(124,58,237,0.1);display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.75rem;font-weight:800;color:#5B21B6;text-transform:uppercase;letter-spacing:0.07em;">💭 Ideeën & wensen</span>
                            <span style="font-size:0.6875rem;background:#7C3AED;color:white;padding:0.15rem 0.5rem;border-radius:99px;font-weight:700;">Nog onzeker</span>
                        </div>
                        <div style="padding:1rem 1.25rem;display:flex;flex-direction:column;gap:0.875rem;">
                            @foreach([
                                ['🧾', 'Facturen', 'Upload en koppel facturen aan transacties in je administratie'],
                                ['🌍', 'Meerdere valuta', 'Ondersteuning voor transacties in euro én andere valuta'],
                            ] as [$icon, $title, $desc])
                            <div style="display:flex;gap:0.875rem;align-items:flex-start;">
                                <div style="width:2.25rem;height:2.25rem;background:#F5F0FF;border-radius:0.625rem;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">{{ $icon }}</div>
                                <div>
                                    <div style="font-size:0.9rem;font-weight:700;color:#0B1F3A;">{{ $title }}</div>
                                    <div style="font-size:0.8125rem;color:#6B7A99;margin-top:0.125rem;">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ══ GEAVANCEERDE UPDATES — afhankelijkheden & beveiligings-advisories ══ --}}
        @php
            $advisories = [
                [
                    'id' => 'vite-esbuild-2026-05',
                    'title' => 'Vite & esbuild — beveiligings-update voor de build-tools',
                    'severity' => 'moderate',
                    'status' => 'fixed',
                    'date' => 'mei 2026',
                    'summary' => 'Twee gereedschappen die BankBird gebruikt om CSS en JavaScript te bouwen — Vite en esbuild — hadden een lek in hun lokale ontwikkel-server. Dit lek raakte alleen ontwikkelaars die `npm run dev` draaien, niet bezoekers van een live BankBird-installatie.',
                    'impact' => 'Klein voor draaiende installaties. BankBird wordt in productie geserveerd vanuit een vooraf gebouwde versie (`npm run build`) waarin de kwetsbare ontwikkel-server niet aanwezig is.',
                    'recommendation' => 'Opgelost: Vite is bijgewerkt van 5.x naar 6.x (kleine sprong, lost beide adviezen op). `npm audit` toont nu 0 kwetsbaarheden.',
                    'dev_commands' => "# Toegepaste upgrade (Vite 5 → 6)\nnpm install --save-dev vite@^6 laravel-vite-plugin@^1.2\nnpm run build\nnpm audit  # 0 vulnerabilities",
                    'references' => [
                        ['label' => 'GHSA-4w7w-66w2-5vf9 — Vite path traversal', 'url' => 'https://github.com/advisories/GHSA-4w7w-66w2-5vf9'],
                        ['label' => 'GHSA-67mh-4wv8-2f99 — esbuild dev server', 'url' => 'https://github.com/advisories/GHSA-67mh-4wv8-2f99'],
                    ],
                ],
            ];

            $severityMeta = [
                'critical' => ['label' => 'Kritiek',    'bg' => '#FEE2E2', 'fg' => '#991B1B', 'border' => '#FCA5A5'],
                'high'     => ['label' => 'Hoog',       'bg' => '#FFEDD5', 'fg' => '#9A3412', 'border' => '#FDBA74'],
                'moderate' => ['label' => 'Gemiddeld',  'bg' => '#FEF3C7', 'fg' => '#92400E', 'border' => '#FCD34D'],
                'low'      => ['label' => 'Laag',       'bg' => '#E0F2FE', 'fg' => '#075985', 'border' => '#7DD3FC'],
            ];

            $statusMeta = [
                'open'        => ['label' => 'Openstaand',     'bg' => '#FFF3E0', 'fg' => '#BF360C', 'border' => '#FDBA74'],
                'in_progress' => ['label' => 'In behandeling', 'bg' => '#EEF5FF', 'fg' => '#1565C0', 'border' => '#90CAF9'],
                'fixed'       => ['label' => 'Opgelost',       'bg' => '#F0FFF8', 'fg' => '#0A9660', 'border' => '#9EEACB'],
            ];
        @endphp

        <div style="margin-top:4rem;" class="reveal">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
                <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#7C3AED,#5B21B6);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(124,58,237,0.3);">🛡️</div>
                <div>
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Geavanceerde updates</h2>
                    <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Adviezen voor onderliggende afhankelijkheden — geen BankBird-releases, wel zaken om bij gelegenheid op te pakken</p>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:1rem;margin-top:1.5rem;">
                @foreach ($advisories as $advisory)
                    @php
                        $sev = $severityMeta[$advisory['severity']] ?? $severityMeta['moderate'];
                        $stat = $statusMeta[$advisory['status']] ?? $statusMeta['open'];
                    @endphp
                    <article style="background:white;border:1px solid rgba(124,58,237,0.15);border-radius:1.25rem;overflow:hidden;box-shadow:0 2px 12px rgba(11,31,58,0.05);">

                        {{-- Header: titel + badges --}}
                        <header style="padding:1rem 1.25rem;background:linear-gradient(135deg,#F5F0FF,#FAF7FF);border-bottom:1px solid rgba(124,58,237,0.1);display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                            <div style="flex:1;min-width:240px;">
                                <h3 style="font-size:1rem;font-weight:800;color:#0B1F3A;margin:0 0 0.25rem;line-height:1.35;">{{ $advisory['title'] }}</h3>
                                <div style="font-size:0.75rem;color:#6B7A99;">{{ $advisory['date'] }}</div>
                            </div>
                            <div style="display:flex;gap:0.4rem;flex-shrink:0;flex-wrap:wrap;">
                                <span style="font-size:0.6875rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:99px;background:{{ $sev['bg'] }};color:{{ $sev['fg'] }};border:1px solid {{ $sev['border'] }};text-transform:uppercase;letter-spacing:0.05em;">{{ $sev['label'] }}</span>
                                <span style="font-size:0.6875rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:99px;background:{{ $stat['bg'] }};color:{{ $stat['fg'] }};border:1px solid {{ $stat['border'] }};text-transform:uppercase;letter-spacing:0.05em;">{{ $stat['label'] }}</span>
                            </div>
                        </header>

                        {{-- Body --}}
                        <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">

                            <div>
                                <div style="font-size:0.6875rem;font-weight:800;color:#7C3AED;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.4rem;">Wat speelt er?</div>
                                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0;">{{ $advisory['summary'] }}</p>
                            </div>

                            <div>
                                <div style="font-size:0.6875rem;font-weight:800;color:#7C3AED;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.4rem;">Impact voor BankBird</div>
                                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0;">{{ $advisory['impact'] }}</p>
                            </div>

                            <div>
                                <div style="font-size:0.6875rem;font-weight:800;color:#7C3AED;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.4rem;">Aanbeveling</div>
                                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0;">{{ $advisory['recommendation'] }}</p>
                            </div>

                            @if (! empty($advisory['dev_commands']))
                                <details style="border:1px solid #E5E7EB;border-radius:0.75rem;overflow:hidden;background:#FAFAFA;">
                                    <summary style="cursor:pointer;padding:0.75rem 1rem;font-size:0.75rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.06em;list-style:none;display:flex;align-items:center;gap:0.5rem;user-select:none;">
                                        <span>▶</span>
                                        Voor ontwikkelaars — commando's
                                    </summary>
                                    <pre style="margin:0;padding:1rem 1.25rem;background:#0B1F3A;color:#E5E7EB;font-size:0.8125rem;line-height:1.6;overflow-x:auto;font-family:'SF Mono','Monaco','Consolas',monospace;border-top:1px solid #E5E7EB;"><code>{{ $advisory['dev_commands'] }}</code></pre>
                                </details>
                            @endif

                            @if (! empty($advisory['references']))
                                <div>
                                    <div style="font-size:0.6875rem;font-weight:800;color:#7C3AED;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:0.5rem;">Bronnen</div>
                                    <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0.375rem;">
                                        @foreach ($advisory['references'] as $reference)
                                            <li>
                                                <a href="{{ $reference['url'] }}" target="_blank" rel="noopener" style="font-size:0.875rem;color:#1565C0;text-decoration:none;display:inline-flex;align-items:center;gap:0.375rem;">
                                                    {{ $reference['label'] }}
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        {{-- Bijdragen CTA --}}
        <div style="margin-top:3rem;" class="reveal">
            <div class="bb-grid-2 bb-gradient-card" style="background:linear-gradient(135deg,#1565C0,#1E88E5,#42A5F5);border-radius:2rem;padding:3rem 2.5rem;align-items:center;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-40px;right:200px;width:220px;height:220px;background:rgba(255,255,255,0.05);border-radius:50%;pointer-events:none;"></div>
                <div style="position:relative;z-index:1;">
                    <h2 style="font-size:1.625rem;font-weight:900;color:white;margin:0 0 0.625rem;letter-spacing:-0.02em;">
                        Mis je een bank of feature?
                    </h2>
                    <p style="font-size:0.9375rem;color:rgba(255,255,255,0.82);margin:0 0 1.5rem;max-width:480px;line-height:1.65;">
                        BankBird is open-source. Open een issue of pull request op GitHub en help mee bouwen. Elke bijdrage — klein of groot — is welkom.
                    </p>
                    <div class="bb-flex-center" style="display:flex;gap:0.875rem;flex-wrap:wrap;">
                        <a href="https://github.com/AivionStudiosPlayground/bankbird/issues" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#1565C0;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                            Open een issue op GitHub
                        </a>
                        <a href="{{ url('/install') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                            Zelf installeren →
                        </a>
                    </div>
                </div>
                <div style="flex-shrink:0;animation:float 4s ease-in-out infinite;" class="hidden-mobile">
                    <img src="{{ asset('images/bird.png') }}" alt="BankBird" style="height:140px;width:auto;filter:drop-shadow(0 8px 20px rgba(0,0,0,0.2));">
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
