@extends('layouts.public')

@section('title', 'Over BankBird — Michael Braam')
@section('description', 'Waarom ik BankBird heb gebouwd en wie er achter zit. Een persoonlijk project dat is uitgegroeid tot een open-source financieel hulpmiddel voor iedereen.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-80px;right:-40px;width:500px;height:500px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2.5rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">👋 Over BankBird</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Waarom ik dit<br>heb gebouwd
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.82);margin:0 0 2rem;max-width:500px;line-height:1.7;">
                    BankBird begon als een persoonlijk antwoord op een simpele vraag: <em>"Waar gaat mijn geld eigenlijk naartoe?"</em> — en groeide uit tot een open-source project dat ik graag deel.
                </p>
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <a href="{{ url('/install') }}" class="bb-btn-white" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#1565C0;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.65rem 1.5rem;text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                        Probeer BankBird zelf
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                    </a>
                    <a href="https://aivionstudios.nl" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:600;font-size:0.9375rem;padding:0.625rem 1.5rem;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                        Aivion Studios ↗
                    </a>
                </div>
            </div>
            {{-- Foto --}}
            <div style="flex-shrink:0;" class="hidden-mobile">
                <img src="{{ asset('images/about.png') }}" alt="Michael Braam met BankBird" style="height:280px;width:auto;border-radius:1.5rem;box-shadow:0 20px 60px rgba(0,0,0,0.3);object-fit:cover;">
            </div>
        </div>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

<section style="background:#F0F6FF;padding:4rem 1.5rem 6rem;">
    <div class="bb-wrap">

        {{-- Foto op mobiel --}}
        <div class="bb-card-flat reveal" style="overflow:hidden;margin-bottom:2rem;display:none;" id="about-img-mobile">
            <img src="{{ asset('images/about.png') }}" alt="Michael Braam met BankBird" style="width:100%;height:auto;display:block;">
        </div>

        <div class="bb-grid-2" style="align-items:start;gap:4rem;">

            {{-- LINKS: Het verhaal --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;">

                {{-- Waarom --}}
                <div class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
                        <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(30,136,229,0.3);">💡</div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Waarom BankBird?</h2>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:1rem;font-size:0.9375rem;color:#4A5568;line-height:1.75;">
                        <p style="margin:0;">
                            Ik betaal vrijwel alles digitaal. Handig — maar daardoor sta ik er ook zelden bij stil wat er echt uitgaat. Op een avond vroeg ik mezelf af: <strong style="color:#0B1F3A;">hoeveel betaal ik eigenlijk aan streamingdiensten?</strong> En hoeveel gooi ik er maandelijks door aan boodschappen?
                        </p>
                        <p style="margin:0;">
                            Ik opende mijn bankapp, scrollde door honderden transacties en had geen flauw idee waar ik moest beginnen. Er was geen overzicht, geen structuur, geen inzicht. Alleen een lange lijst getallen.
                        </p>
                        <p style="margin:0;">
                            Bestaande tools voelden òf te zwaar (voor bedrijven) òf te simpel (alleen een grafiekje). Ik wilde iets dat <em>echt werkt</em> voor iemand zoals ik: iemand die niet elke euro bijhoudt maar wél wil begrijpen waar het geld naartoe gaat.
                        </p>
                        <p style="margin:0;">
                            Dus bouwde ik BankBird.
                        </p>
                    </div>
                </div>

                {{-- Waarom open-source --}}
                <div class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem;">
                        <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#16C784,#0A9660);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(22,199,132,0.3);">🌍</div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Waarom open-source?</h2>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:1rem;font-size:0.9375rem;color:#4A5568;line-height:1.75;">
                        <p style="margin:0;">
                            Als het voor mij werkt, werkt het misschien ook voor jou. En als jij er iets aan toevoegt wat ik nog niet had bedacht, is het systeem ineens nóg beter — voor ons allebei.
                        </p>
                        <p style="margin:0;">
                            Ik geloof dat financieel inzicht voor iedereen toegankelijk moet zijn, niet alleen voor wie een duur abonnement kan betalen. BankBird draait op je eigen server, je data blijft van jou, en de code is voor iedereen te bekijken.
                        </p>
                        <p style="margin:0;">
                            Mis je een bank, een feature, of heb je een idee? Open een issue op GitHub of bouw het zelf — dat is precies de bedoeling.
                        </p>
                    </div>

                    <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
                        <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;background:#0B1F3A;color:white;border-radius:0.875rem;font-weight:700;font-size:0.875rem;padding:0.6rem 1.25rem;text-decoration:none;transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                            Bijdragen op GitHub
                        </a>
                        <a href="{{ url('/vibe-dev') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:#EEF5FF;color:#1565C0;border-radius:0.875rem;font-weight:700;font-size:0.875rem;padding:0.6rem 1.25rem;text-decoration:none;border:1px solid rgba(30,136,229,0.2);transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                            🛠️ Zelf iets bouwen →
                        </a>
                    </div>
                </div>

            </div>

            {{-- RECHTS: Over Michael --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;">

                {{-- Profiel --}}
                <div class="bb-card-flat reveal" style="padding:2rem;background:linear-gradient(145deg,#FAFCFF,#F0F6FF);">
                    <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem;">
                        <div style="width:4rem;height:4rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:1.25rem;display:flex;align-items:center;justify-content:center;font-size:1.75rem;box-shadow:0 6px 20px rgba(30,136,229,0.3);flex-shrink:0;">👨‍💻</div>
                        <div>
                            <div style="font-size:1.25rem;font-weight:900;color:#0B1F3A;letter-spacing:-0.01em;">Michael Braam</div>
                            <div style="font-size:0.875rem;color:#1E88E5;font-weight:600;">Founder & Creative Director</div>
                            <div style="font-size:0.8125rem;color:#6B7A99;margin-top:0.125rem;">Aivion Studios</div>
                        </div>
                    </div>
                    <p style="font-size:0.9375rem;color:#4A5568;line-height:1.75;margin:0 0 1.25rem;">
                        Ik ben Michael — maker van digitale dingen die er toe doen. Via Aivion Studios werk ik aan AI-gedreven platformen, visuals, muziek en interactieve ervaringen. BankBird is mijn persoonlijke zijproject dat iets te groot werd om voor mezelf te houden.
                    </p>

                    <div style="display:flex;flex-direction:column;gap:0.625rem;margin-bottom:1.5rem;">
                        @foreach([
                            ['🎨', 'AI Studio', 'Visuele en conceptuele creaties met AI'],
                            ['💻', 'Vibe Coding', 'Platformen bouwen met AI en clean code'],
                            ['🎵', 'Muziek', 'Cinematografische composities'],
                            ['🎮', 'Gaming', 'Interactieve werelden en games'],
                        ] as [$icon, $title, $desc])
                        <div style="display:flex;align-items:center;gap:0.875rem;padding:0.625rem 0.875rem;background:white;border-radius:0.875rem;border:1px solid rgba(30,136,229,0.08);">
                            <span style="font-size:1rem;flex-shrink:0;">{{ $icon }}</span>
                            <div>
                                <div style="font-size:0.8125rem;font-weight:700;color:#0B1F3A;">{{ $title }}</div>
                                <div style="font-size:0.75rem;color:#6B7A99;">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Social links --}}
                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                        <a href="https://aivionstudios.nl" target="_blank" style="display:inline-flex;align-items:center;gap:0.375rem;background:white;color:#0B1F3A;border:1px solid #DDEAF3;border-radius:0.625rem;font-size:0.8125rem;font-weight:600;padding:0.4rem 0.875rem;text-decoration:none;transition:border-color 0.15s,color 0.15s;" onmouseover="this.style.borderColor='#1E88E5';this.style.color='#1E88E5'" onmouseout="this.style.borderColor='#DDEAF3';this.style.color='#0B1F3A'">
                            🌐 aivionstudios.nl
                        </a>
                        <a href="mailto:mail@aivionstudios.nl" style="display:inline-flex;align-items:center;gap:0.375rem;background:white;color:#0B1F3A;border:1px solid #DDEAF3;border-radius:0.625rem;font-size:0.8125rem;font-weight:600;padding:0.4rem 0.875rem;text-decoration:none;transition:border-color 0.15s,color 0.15s;" onmouseover="this.style.borderColor='#1E88E5';this.style.color='#1E88E5'" onmouseout="this.style.borderColor='#DDEAF3';this.style.color='#0B1F3A'">
                            ✉️ Contact
                        </a>
                    </div>
                </div>

                {{-- Vier woorden --}}
                <div class="bb-card-flat reveal" style="padding:1.75rem;">
                    <div style="font-size:0.75rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#6B7A99;margin-bottom:1.25rem;">Vier woorden die BankBird typeren</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.875rem;">
                        @foreach([
                            ['🎯', 'Focus', 'Alleen wat ertoe doet', '#EEF5FF', '#1565C0'],
                            ['💡', 'Ideas', 'Altijd aan het bouwen', '#FFF8F0', '#BF360C'],
                            ['🤝', 'Samen', 'Open-source voor iedereen', '#E8F5E9', '#1B5E20'],
                            ['📈', 'Groei', 'Beter worden elke versie', '#F5F0FF', '#5B21B6'],
                        ] as [$icon, $word, $desc, $bg, $color])
                        <div style="background:{{ $bg }};border-radius:1rem;padding:1rem;text-align:center;">
                            <div style="font-size:1.5rem;margin-bottom:0.375rem;">{{ $icon }}</div>
                            <div style="font-weight:800;color:#0B1F3A;font-size:0.9375rem;margin-bottom:0.25rem;">{{ $word }}</div>
                            <div style="font-size:0.75rem;color:#6B7A99;">{{ $desc }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tagline --}}
                <div class="reveal" style="background:linear-gradient(135deg,#0D47A1,#1565C0,#1E88E5);border-radius:1.5rem;padding:1.75rem;text-align:center;position:relative;overflow:hidden;">
                    <div style="position:absolute;inset:0;background:url('{{ asset('images/about.png') }}') center/cover no-repeat;opacity:0.08;border-radius:1.5rem;"></div>
                    <div style="position:relative;z-index:1;">
                        <div style="font-size:1.25rem;font-weight:900;color:white;line-height:1.3;letter-spacing:-0.01em;">
                            "Samen bouwen aan<br>slimmere financiële oplossingen."
                        </div>
                        <div style="font-size:0.8125rem;color:rgba(255,255,255,0.6);margin-top:0.75rem;">— Michael Braam, Aivion Studios</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- CTA onderaan --}}
        <div style="margin-top:3rem;" class="reveal">
            <div style="background:white;border:1px solid rgba(30,136,229,0.1);border-radius:2rem;padding:2.5rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap;box-shadow:0 4px 24px rgba(30,136,229,0.08);">
                <div>
                    <h3 style="font-size:1.375rem;font-weight:900;color:#0B1F3A;margin:0 0 0.5rem;letter-spacing:-0.02em;">Klaar om mee te doen?</h3>
                    <p style="font-size:0.9375rem;color:#6B7A99;margin:0;max-width:480px;line-height:1.65;">Installeer BankBird op je eigen server, draag bij via GitHub, of bouw zelf nieuwe features met de Vibe Development gids.</p>
                </div>
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;flex-shrink:0;">
                    <a href="{{ url('/install') }}" class="bb-btn" style="display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#1E88E5,#1565C0);color:white;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;text-decoration:none;box-shadow:0 4px 16px rgba(30,136,229,0.35);">
                        Aan de slag →
                    </a>
                    <a href="{{ url('/kennisbank') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:#F0F6FF;color:#1565C0;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;text-decoration:none;border:1px solid rgba(30,136,229,0.15);">
                        📖 Kennisbank
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
@media (max-width: 860px) {
    .hidden-mobile { display: none !important; }
    #about-img-mobile { display: block !important; }
    [class*="bb-grid-2"] { grid-template-columns: 1fr !important; gap: 1.5rem !important; }
}
@media (max-width: 640px) {
    [style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr 1fr !important; }
}
</style>

@endsection
