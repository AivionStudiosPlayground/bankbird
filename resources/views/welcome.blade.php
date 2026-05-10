@extends('layouts.public')

@section('title', 'BankBird — Jouw Vriendelijke Financiële Administratie')
@section('description', 'BankBird maakt persoonlijke financiële administratie leuk. Importeer bankafschriften, AI-categorisatie, mooie rapporten. Gratis & open-source.')

@section('content')

{{-- ══════════════════════════════════════════════ --}}
{{-- HERO                                          --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="
    background: linear-gradient(145deg, #0D47A1 0%, #1565C0 35%, #1E88E5 65%, #42A5F5 100%);
    position: relative; overflow: hidden; padding: 5rem 1.5rem 0;
    min-height: 92vh; display: flex; align-items: center;
">
    <div style="position:absolute;top:-120px;right:-80px;width:600px;height:600px;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-60px;left:-100px;width:500px;height:500px;background:radial-gradient(circle,rgba(13,71,161,0.5) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;top:15%;left:8%;width:10px;height:10px;background:rgba(255,255,255,0.4);border-radius:50%;animation:float-slow 4s ease-in-out infinite;"></div>
    <div style="position:absolute;top:40%;left:5%;width:6px;height:6px;background:rgba(255,255,255,0.25);border-radius:50%;animation:float-slow 6s ease-in-out infinite 1s;"></div>
    <div style="position:absolute;top:25%;right:12%;width:8px;height:8px;background:rgba(255,255,255,0.3);border-radius:50%;animation:float-slow 5s ease-in-out infinite 2s;"></div>
    <div style="position:absolute;bottom:20%;right:8%;width:12px;height:12px;background:rgba(255,255,255,0.2);border-radius:50%;animation:float-slow 7s ease-in-out infinite 0.5s;"></div>

    <div class="bb-wrap" style="position:relative;z-index:1;width:100%;">
        <div class="bb-grid-2" style="align-items:center;">

            <div style="animation: fadeInUp 0.7s ease both;">
                <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:99px;padding:0.3rem 1rem 0.3rem 0.5rem;margin-bottom:1.75rem;">
                    <span style="background:white;color:#1E88E5;border-radius:99px;font-size:0.6875rem;font-weight:800;padding:0.15rem 0.625rem;text-transform:uppercase;letter-spacing:0.08em;">Nieuw</span>
                    <span style="font-size:0.8125rem;color:rgba(255,255,255,0.9);font-weight:500;">AI installeert BankBird voor je</span>
                </div>

                <h1 style="font-size:clamp(2.5rem,5vw,3.75rem);font-weight:900;color:white;line-height:1.1;margin:0 0 1.25rem;letter-spacing:-0.02em;">
                    Financiën bijhouden<br>
                    <span style="color:#FFE082;">zonder gedoe</span> 🐦
                </h1>

                <p style="font-size:1.1875rem;color:rgba(255,255,255,0.82);line-height:1.65;margin:0 0 2.25rem;max-width:520px;">
                    Vraag Claude of Codex om BankBird te installeren en je hebt binnen vijf minuten een persoonlijke financiële assistent — die je bankafschriften importeert, AI je transacties laat categoriseren en je weer helder inzicht geeft. Gratis, open-source.
                </p>

                <div class="bb-flex-center" style="display:flex;flex-wrap:wrap;gap:0.875rem;margin-bottom:3rem;">
                    <a href="{{ url('/install') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#1565C0;border-radius:0.875rem;font-weight:800;font-size:1.0625rem;padding:0.875rem 2rem;text-decoration:none;box-shadow:0 8px 32px rgba(0,0,0,0.2);transition:transform 0.18s,box-shadow 0.18s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.2)'">
                        🤖 Laat AI installeren
                    </a>
                    <a href="{{ url('/demo') }}" class="bb-btn-ghost-white bb-btn-lg">
                        Bekijk de demo →
                    </a>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:1.5rem;">
                    @foreach(['✓ 100% gratis & open-source', '✓ Jouw data, jouw server', '✓ Eén prompt, vijf minuten'] as $item)
                        <span style="font-size:0.875rem;color:rgba(255,255,255,0.75);font-weight:500;">{{ $item }}</span>
                    @endforeach
                </div>
            </div>

            <div class="bb-hero-bird-col" style="display:flex;justify-content:center;align-items:flex-end;animation: fadeIn 0.9s ease both 0.2s; opacity:0;">
                <div style="position:relative;">
                    <div style="position:absolute;bottom:10%;left:50%;transform:translateX(-50%);width:320px;height:120px;background:radial-gradient(ellipse,rgba(255,255,255,0.2) 0%,transparent 70%);filter:blur(20px);border-radius:50%;"></div>
                    <img src="{{ asset('images/bird.png') }}" alt="BankBird mascotte"
                         style="height:420px;width:auto;filter:drop-shadow(0 24px 48px rgba(0,0,0,0.3));animation:float 4s ease-in-out infinite;position:relative;z-index:1;">
                    <div style="position:absolute;top:10%;right:-30px;background:white;border-radius:1rem 1rem 1rem 0.25rem;padding:0.625rem 0.875rem;box-shadow:0 8px 24px rgba(0,0,0,0.15);animation:float-slow 4s ease-in-out infinite 1s;">
                        <div style="font-size:0.8125rem;font-weight:700;color:#1565C0;">💳 €2.847 gespaard</div>
                        <div style="font-size:0.6875rem;color:#6B7A99;margin-top:0.125rem;">Deze maand 🎉</div>
                    </div>
                    <div style="position:absolute;bottom:18%;left:-20px;background:linear-gradient(135deg,#16C784,#0A9660);border-radius:0.875rem;padding:0.5rem 0.875rem;box-shadow:0 8px 24px rgba(22,199,132,0.35);animation:float-slow 5s ease-in-out infinite 2s;">
                        <div style="font-size:0.75rem;font-weight:700;color:white;">AI gecategoriseerd ✨</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- STATS BAR                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:3rem 1.5rem;">
    <div class="bb-wrap">
        <div class="bb-grid-4" style="background:white;border-radius:1.5rem;border:1px solid rgba(30,136,229,0.1);box-shadow:0 4px 24px rgba(30,136,229,0.08);padding:2rem 2.5rem;text-align:center;">
            @foreach([
                ['🏦', '5+', 'Bank formaten'],
                ['🤖', 'AI', 'Categorisatie'],
                ['📊', '∞', 'Rapporten'],
                ['🔒', '100%', 'Jouw data'],
            ] as [$icon, $val, $label])
            <div class="reveal">
                <div style="font-size:1.75rem;margin-bottom:0.25rem;">{{ $icon }}</div>
                <div style="font-size:2rem;font-weight:900;color:#1E88E5;line-height:1;">{{ $val }}</div>
                <div style="font-size:0.8125rem;color:#6B7A99;font-weight:500;margin-top:0.25rem;">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- DE INSTALLATIE VAN 2026                       --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="bb-section" style="background:white;">
    <div class="bb-wrap">
        <div style="text-align:center;margin-bottom:3rem;" class="reveal">
            <div class="bb-pill" style="margin-bottom:1rem;">🤖 De installatie van 2026</div>
            <h2 style="font-size:clamp(1.875rem,3.5vw,2.75rem);font-weight:900;margin:0 0 1rem;letter-spacing:-0.02em;">
                Vergeet diskettes,<br><span class="bb-gradient-text">vraag de AI</span>
            </h2>
            <p style="font-size:1.0625rem;color:#6B7A99;max-width:620px;margin:0 auto;line-height:1.65;">
                We kennen de tijd van diskettes, downloads en lange installers. Maar we leven in 2026 — en AI doet dit gewoon voor je. BankBird is volledig te installeren via Claude of Codex.
            </p>
        </div>

        <div class="bb-grid-2 reveal" style="gap:1.5rem;align-items:stretch;">
            {{-- Vroeger --}}
            <div style="background:#F5F5F5;border:1px solid #E0E0E0;border-radius:1.5rem;padding:2rem;position:relative;overflow:hidden;">
                <div style="position:absolute;top:1rem;right:1rem;background:#9E9E9E;color:white;border-radius:99px;font-size:0.6875rem;font-weight:800;padding:0.25rem 0.75rem;text-transform:uppercase;letter-spacing:0.06em;">Vroeger</div>
                <div style="font-size:2.25rem;margin-bottom:1rem;filter:grayscale(0.4);">💾📀</div>
                <h3 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#424242;line-height:1.3;">Diskettes, downloads, installers</h3>
                <ul style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:0.625rem;">
                    @foreach([
                        '📦 Software op een schijfje of zip-bestand',
                        '⬇️ Downloaden, uitpakken, kijken wat je krijgt',
                        '⚙️ Setup-wizard met 14 schermen "Volgende"',
                        '💻 Terminal-commando\'s die je niet snapt',
                        '🐛 Foutmeldingen googlen en stackoverflow afstropen',
                    ] as $item)
                    <li style="font-size:0.9375rem;color:#616161;line-height:1.5;">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Nu --}}
            <div style="background:linear-gradient(135deg,#0D47A1,#1565C0,#1E88E5);border-radius:1.5rem;padding:2rem;position:relative;overflow:hidden;color:white;box-shadow:0 12px 40px rgba(30,136,229,0.25);">
                <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
                <div style="position:absolute;top:1rem;right:1rem;background:white;color:#1565C0;border-radius:99px;font-size:0.6875rem;font-weight:800;padding:0.25rem 0.75rem;text-transform:uppercase;letter-spacing:0.06em;z-index:1;">Nu — 2026</div>
                <div style="font-size:2.25rem;margin-bottom:1rem;position:relative;z-index:1;">🤖✨</div>
                <h3 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:white;line-height:1.3;position:relative;z-index:1;">Eén prompt, vijf minuten</h3>
                <ul style="margin:0;padding:0;list-style:none;display:flex;flex-direction:column;gap:0.625rem;position:relative;z-index:1;">
                    @foreach([
                        '💬 Open Claude Code of Codex',
                        '✍️ Typ: "Installeer BankBird (github.com/AivionStudiosPlayground/bankbird) voor me"',
                        '☕ Pak een koffie',
                        '🐦 BankBird draait — voor altijd op de achtergrond',
                    ] as $item)
                    <li style="font-size:0.9375rem;color:rgba(255,255,255,0.92);line-height:1.5;">{{ $item }}</li>
                    @endforeach
                </ul>
                <div style="margin-top:1.5rem;padding:1rem;background:rgba(0,0,0,0.25);border-radius:0.75rem;font-family:'JetBrains Mono','Fira Code',ui-monospace,monospace;font-size:0.875rem;color:#A7F3D0;position:relative;z-index:1;">
                    &gt; Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me.
                </div>
                <a href="{{ url('/install') }}" style="display:inline-flex;align-items:center;gap:0.5rem;margin-top:1.25rem;background:white;color:#1565C0;border-radius:0.75rem;font-weight:800;font-size:0.9375rem;padding:0.625rem 1.25rem;text-decoration:none;position:relative;z-index:1;">
                    Zo werkt het →
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- FEATURES                                      --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="bb-section" style="background:#F0F6FF;">
    <div class="bb-wrap">
        <div style="text-align:center;margin-bottom:3.5rem;" class="reveal">
            <div class="bb-pill" style="margin-bottom:1rem;">✨ Wat doet BankBird?</div>
            <h2 style="font-size:clamp(1.875rem,3.5vw,2.75rem);font-weight:900;margin:0 0 1rem;letter-spacing:-0.02em;">
                Alles wat je nodig hebt,<br><span class="bb-gradient-text">niets wat je niet wil</span>
            </h2>
            <p style="font-size:1.0625rem;color:#6B7A99;max-width:560px;margin:0 auto;">
                Geen abonnementen, geen verborgen kosten. Gewoon een slimme tool die draait op jouw eigen server.
            </p>
        </div>

        <div class="bb-grid-3">
            @foreach([
                ['images/icons/01.png', '#DBEAFE', 'Bankafschriften importeren', 'ING, SNS en Knab — upload je PDF of CSV en BankBird verwerkt alles automatisch. Rabobank en ABN AMRO volgen later.'],
                ['images/icons/02.png', '#0F1E35', 'AI doet het denkwerk',       'Claude of GPT categoriseert je transacties razendsnel. Leert van jouw feedback en wordt elke dag slimmer.'],
                ['images/icons/03.png', '#12182E', 'Slimme merchant herkenning', 'BankBird leert welke winkels bij welke categorie horen. Eén keer instellen, altijd goed.'],
                ['images/icons/04.png', '#D1FAE5', 'Mooie rapporten',            'Maandoverzichten, jaaroverzichten, uitgavenpatronen. Alles in één oogopslag duidelijk.'],
                ['images/icons/05.png', '#1E1B3A', 'Multi-user & 2FA',           'Gebruik BankBird met je hele gezin of huishouden. Met tweefactorauthenticatie extra veilig.'],
                ['images/icons/06.png', '#FDE8D8', 'Privacy first',              'Jouw data staat op jouw server. Nooit in de cloud van een ander. Nooit gedeeld. Altijd van jou.'],
            ] as [$icon, $bg, $title, $desc])
            <div class="bb-card reveal" style="padding:1.75rem;display:flex;flex-direction:column;align-items:center;text-align:center;">
                <div style="width:7rem;height:7rem;border-radius:1.25rem;overflow:hidden;margin-bottom:1.375rem;flex-shrink:0;background:{{ $bg }};display:flex;align-items:center;justify-content:center;">
                    <img src="{{ asset($icon) }}" alt="{{ $title }}" style="width:90%;height:90%;object-fit:contain;">
                </div>
                <h3 style="font-size:1.0625rem;font-weight:800;margin:0 0 0.5rem;color:#0B1F3A;">{{ $title }}</h3>
                <p style="font-size:0.9rem;color:#6B7A99;line-height:1.65;margin:0;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- HOW IT WORKS                                  --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="bb-section" style="background:white;">
    <div class="bb-wrap">
        <div class="bb-grid-2" style="gap:5rem;align-items:center;">

            <div style="display:flex;justify-content:center;" class="reveal">
                <div style="position:relative;">
                    <div style="width:360px;height:360px;background:linear-gradient(135deg,#EEF5FF,#E3F2FD);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <img src="{{ asset('images/bird.png') }}" alt="BankBird" style="height:280px;width:auto;filter:drop-shadow(0 12px 24px rgba(30,136,229,0.2));animation:float 4.5s ease-in-out infinite;">
                    </div>
                    <div style="position:absolute;top:-10px;right:-20px;background:white;border-radius:1rem;padding:0.75rem 1rem;box-shadow:0 8px 24px rgba(30,136,229,0.12);border:1px solid rgba(30,136,229,0.1);animation:float-slow 5s ease-in-out infinite;">
                        <div style="font-size:0.75rem;color:#6B7A99;margin-bottom:0.125rem;">Supermarkt</div>
                        <div style="font-size:1rem;font-weight:800;color:#0B1F3A;">€ 342,80</div>
                        <div style="font-size:0.6875rem;color:#16C784;font-weight:600;">↓ 12% vs vorige maand</div>
                    </div>
                    <div style="position:absolute;bottom:20px;left:-30px;background:white;border-radius:1rem;padding:0.75rem 1rem;box-shadow:0 8px 24px rgba(30,136,229,0.12);border:1px solid rgba(30,136,229,0.1);animation:float-slow 6s ease-in-out infinite 1.5s;">
                        <div style="font-size:0.75rem;color:#6B7A99;margin-bottom:0.125rem;">AI gecategoriseerd</div>
                        <div style="display:flex;gap:0.25rem;align-items:center;">
                            <div style="width:8px;height:8px;background:#16C784;border-radius:50%;animation:pulse-glow 2s ease-in-out infinite;"></div>
                            <span style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">247 transacties ✓</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal">
                <div class="bb-pill" style="margin-bottom:1rem;">🗺️ Hoe werkt het?</div>
                <h2 style="font-size:clamp(1.75rem,3vw,2.5rem);font-weight:900;margin:0 0 2.5rem;letter-spacing:-0.02em;">
                    In drie stappen<br><span class="bb-gradient-text">volledig inzicht</span>
                </h2>

                <div style="display:flex;flex-direction:column;gap:2rem;">
                    @foreach([
                        ['1', '#EEF5FF', '#1E88E5', 'Vraag Claude of Codex', 'Eén prompt — de AI installeert BankBird voor je via Laravel Herd. Geen technische kennis nodig, vijf minuten klaar.'],
                        ['2', '#F0FFF8', '#16C784', 'Importeer je bankafschrift', 'Upload je PDF of CSV van ING, SNS of Knab. BankBird leest alles automatisch uit; meer banken volgen.'],
                        ['3', '#FFF8F0', '#FF8A3D', 'Geniet van het overzicht', 'AI categoriseert je transacties, je ziet mooie rapporten en hebt eindelijk rust over je financiën.'],
                    ] as [$num, $bg, $color, $title, $desc])
                    <div style="display:flex;gap:1.25rem;align-items:flex-start;">
                        <div style="width:2.75rem;height:2.75rem;background:{{ $bg }};border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:{{ $color }};flex-shrink:0;">{{ $num }}</div>
                        <div>
                            <div style="font-size:1.0625rem;font-weight:800;color:#0B1F3A;margin-bottom:0.375rem;">{{ $title }}</div>
                            <div style="font-size:0.9rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:2.5rem;">
                    <a href="{{ url('/install') }}" class="bb-btn">Bekijk de installatie handleiding →</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- TECH STACK                                    --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="bb-section-sm" style="background:#F0F6FF;">
    <div class="bb-wrap">
        <div style="text-align:center;margin-bottom:2.5rem;" class="reveal">
            <div class="bb-pill" style="margin-bottom:0.75rem;">🛠️ Gebouwd op</div>
            <h2 style="font-size:1.75rem;font-weight:900;margin:0;letter-spacing:-0.02em;">Solide technologie</h2>
        </div>
        <div class="bb-grid-5 reveal">
            @foreach([
                ['⚙️', 'Laravel 11', 'PHP framework'],
                ['🎨', 'Filament 5', 'Admin panel'],
                ['⚡', 'Livewire 4', 'Reactief UI'],
                ['🤖', 'AI APIs', 'Claude & GPT'],
                ['🐘', 'MySQL/SQLite', 'Database'],
            ] as [$icon, $name, $desc])
            <div class="bb-card" style="padding:1.25rem;text-align:center;">
                <div style="font-size:1.75rem;margin-bottom:0.5rem;">{{ $icon }}</div>
                <div style="font-size:0.9375rem;font-weight:800;color:#0B1F3A;margin-bottom:0.125rem;">{{ $name }}</div>
                <div style="font-size:0.75rem;color:#6B7A99;">{{ $desc }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- CTA                                           --}}
{{-- ══════════════════════════════════════════════ --}}
<section class="bb-section" style="background:white;">
    <div class="bb-wrap">
        <div style="
            background:linear-gradient(135deg, #1565C0 0%, #1E88E5 50%, #42A5F5 100%);
            border-radius:2rem; padding:4rem 3rem; text-align:center; position:relative; overflow:hidden;
        " class="reveal">
            <div style="position:absolute;top:-60px;right:-60px;width:300px;height:300px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
            <div style="position:absolute;bottom:-80px;left:-40px;width:280px;height:280px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>

            <img src="{{ asset('images/icons/install.png') }}" alt="Installeer BankBird" style="height:200px;width:auto;filter:drop-shadow(0 12px 32px rgba(0,0,0,0.22));animation:float 4s ease-in-out infinite;margin-bottom:1.75rem;display:block;margin-left:auto;margin-right:auto;">

            <h2 style="font-size:clamp(1.75rem,3.5vw,2.75rem);font-weight:900;color:white;margin:0 0 1rem;letter-spacing:-0.02em;">
                Eén prompt verwijderd
            </h2>
            <p style="font-size:1.0625rem;color:rgba(255,255,255,0.82);margin:0 auto 2rem;max-width:520px;">
                Open Claude of Codex, vraag om BankBird. Geen downloads, geen installers, geen terminal — gewoon AI die het werk doet.
            </p>
            <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
                <a href="{{ url('/install') }}" class="bb-btn-white bb-btn-lg">🤖 Laat AI installeren</a>
                <a href="{{ url('/demo') }}" class="bb-btn-ghost-white bb-btn-lg">Bekijk demo</a>
            </div>
        </div>
    </div>
</section>

{{-- Compatibel met — alleen logos, transparant default, 100% bij hover --}}
<section style="background:white;padding:4rem 1.5rem;">
    <div class="bb-wrap" style="text-align:center;">
        <div class="bb-supported-label reveal">Compatibel met</div>
        <div class="bb-supported-sub reveal">Banken en AI-tools die BankBird ondersteunt — geen officiële samenwerking</div>
        <div class="bb-supported-logos reveal">
            <img src="{{ asset('images/banks/ing-logo.svg') }}" alt="ING" class="bb-supported-logo">
            <img src="{{ asset('images/banks/knab-logo.svg') }}" alt="Knab" class="bb-supported-logo">
            <img src="{{ asset('images/banks/sns-logo.svg') }}" alt="SNS" class="bb-supported-logo">
            <img src="{{ asset('images/banks/codex-logo.jpg') }}" alt="Codex" class="bb-supported-logo">
            <img src="{{ asset('images/banks/claude-ai-icon.svg') }}" alt="Claude" class="bb-supported-logo">
        </div>
    </div>
</section>

<style>
    .bb-supported-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #6B7A99;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        margin-bottom: 0.4rem;
    }
    .bb-supported-sub {
        font-size: 0.75rem;
        color: #94A3B8;
        font-weight: 500;
        margin-bottom: 2rem;
    }
    .bb-supported-logos {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4rem;
        flex-wrap: wrap;
    }
    .bb-supported-logo {
        height: 2.75rem;
        width: auto;
        opacity: 0.4;
        filter: grayscale(30%);
        transition: opacity 0.3s ease, filter 0.3s ease, transform 0.3s ease;
    }
    .bb-supported-logo:hover {
        opacity: 1;
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    @media (max-width: 640px) {
        .bb-supported-logos { gap: 2rem; }
        .bb-supported-logo { height: 2rem; }
    }
</style>

@endsection
