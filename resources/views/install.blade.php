@extends('layouts.public')

@section('title', 'Installatie — BankBird')
@section('description', 'Installeer BankBird in een paar minuten op jouw eigen server. Stap-voor-stap handleiding.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-80px;right:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.08) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">🚀 Installatie handleiding</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    In vijf minuten<br>klaar voor gebruik
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0;max-width:480px;line-height:1.65;">
                    Geen zorgen, BankBird is makkelijk te installeren. Volg de stappen hieronder en je bent zo aan de slag.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4s ease-in-out infinite;">
                <img src="{{ asset('images/icons/install.png') }}" alt="BankBird installatie" class="bb-hero-img" style="height:220px;width:auto;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.25));">
            </div>
        </div>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

{{-- Nieuw met Vibe Coding? --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem 0;">
    <div class="bb-wrap">
        <div style="background:#F5F0FF;border:1px solid rgba(124,58,237,0.2);border-radius:1rem;display:flex;gap:1rem;align-items:center;flex-wrap:wrap;padding:1.125rem 1.5rem;">
            <span style="font-size:1.375rem;flex-shrink:0;">🛠️</span>
            <div style="flex:1;min-width:220px;">
                <span style="font-size:0.9375rem;font-weight:800;color:#3B0764;">Nieuw met Vibe Coding?</span>
                <span style="font-size:0.875rem;color:#5B21B6;margin-left:0.5rem;line-height:1.6;">Zorg eerst dat je Claude Code of ChatGPT hebt en maak een lege projectmap aan.</span>
            </div>
            <a href="{{ url('/vibe-dev#voorbereiding') }}" style="display:inline-flex;align-items:center;gap:0.375rem;background:#7C3AED;color:white;border-radius:0.625rem;font-size:0.8125rem;font-weight:700;padding:0.4rem 0.875rem;text-decoration:none;white-space:nowrap;transition:background 0.15s;" onmouseover="this.style.background='#6D28D9'" onmouseout="this.style.background='#7C3AED'">
                Lees de voorbereiding →
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- AI INSTALL ASSISTANT                         --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:3rem 1.5rem 0;">
    <div class="bb-wrap">
        <div class="bb-gradient-card" style="
            background:linear-gradient(135deg,#0D47A1 0%,#1565C0 50%,#1E88E5 100%);
            border-radius:2rem;padding:2.5rem;position:relative;overflow:hidden;
        ">
            <div style="position:absolute;top:-40px;right:-40px;width:250px;height:250px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
            <div class="bb-grid-2" style="align-items:center;position:relative;z-index:1;">
                <div>
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:99px;padding:0.25rem 0.875rem;margin-bottom:1rem;">
                        <span style="font-size:0.75rem;">✨</span>
                        <span style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.06em;">Nieuw: AI-installatie assistent</span>
                    </div>
                    <h2 style="font-size:1.625rem;font-weight:900;color:white;margin:0 0 0.75rem;line-height:1.2;">
                        Geen technische kennis nodig 🐦
                    </h2>
                    <p style="font-size:0.9375rem;color:rgba(255,255,255,0.8);margin:0 0 1.5rem;max-width:520px;line-height:1.65;">
                        Kopieer de onderstaande prompt en plak hem in Claude of ChatGPT. De AI begeleidt je stap voor stap door de volledige installatie — op Windows, Mac of Linux.
                    </p>
                    <div class="bb-flex-center" style="display:flex;gap:0.875rem;flex-wrap:wrap;">
                        <button onclick="copyPrompt('claude')" id="btn-claude" style="display:inline-flex;align-items:center;gap:0.625rem;background:white;color:#1565C0;border:none;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:transform 0.15s,box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.2)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#CC785C"/><path d="M8 12.5c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="white" stroke-width="1.5" stroke-linecap="round"/><circle cx="12" cy="14" r="2.5" fill="white"/></svg>
                            Kopieer voor Claude
                        </button>
                        <button onclick="copyPrompt('chatgpt')" id="btn-chatgpt" style="display:inline-flex;align-items:center;gap:0.625rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;cursor:pointer;transition:background 0.15s,transform 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#74AA9C"/><path d="M7 12h10M12 7v10" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>
                            Kopieer voor ChatGPT
                        </button>
                    </div>
                    <div id="copy-feedback" style="display:none;margin-top:1rem;background:rgba(22,199,132,0.2);border:1px solid rgba(22,199,132,0.4);border-radius:0.625rem;padding:0.625rem 1rem;font-size:0.875rem;font-weight:600;color:#A7F3D0;">
                        ✅ Prompt gekopieerd! Plak hem nu in Claude of ChatGPT en volg de instructies.
                    </div>
                </div>
                <div style="flex-shrink:0;animation:float 4s ease-in-out infinite;" class="hidden-mobile">
                    <img src="{{ asset('images/icons/install.png') }}" alt="BankBird installatie" style="height:180px;width:auto;filter:drop-shadow(0 12px 24px rgba(0,0,0,0.25));">
                </div>
            </div>

            {{-- Prompt preview --}}
            <div style="margin-top:1.75rem;position:relative;z-index:1;">
                <div style="background:rgba(0,0,0,0.25);border-radius:1rem;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
                    <div style="display:flex;align-items:center;gap:0.5rem;padding:0.625rem 1rem;border-bottom:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.03);">
                        <div style="width:10px;height:10px;border-radius:50%;background:#FF6058;"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#FFBD2E;"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#27C93F;"></div>
                        <span style="font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;margin-left:auto;">installatie-prompt.txt</span>
                    </div>
                    <pre id="install-prompt" style="margin:0;padding:1.25rem;font-size:0.75rem;line-height:1.75;color:rgba(255,255,255,0.75);font-family:'JetBrains Mono','Fira Code',ui-monospace,monospace;max-height:160px;overflow:hidden;position:relative;">Je bent een vriendelijke installatie-assistent voor BankBird 🐦
BankBird is een open-source persoonlijke financiële administratie app (Laravel 11 + Filament 5).

Jouw taak: begeleid mij stap voor stap door de installatie op mijn computer.
Ga ervan uit dat ik weinig technische kennis heb. Wees geduldig en bemoedigend.

Repo: https://github.com/AivionStudiosPlayground/bankbird

WAT BANKBIRD DOET:
- Bankafschriften importeren (ING PDF en CSV — Rabobank & ABN AMRO volgen binnenkort)
- Transacties automatisch categoriseren via AI (Claude of OpenAI) — optioneel
- Slimme merchant-herkenning via patronen
- Mooie financiële rapporten en overzichten
- Multi-user ondersteuning met 2FA

AANPAK:
1. Vraag eerst naar mijn besturingssysteem (Windows / Mac / Linux)
2. Controleer of de vereisten aanwezig zijn (PHP 8.2+, Composer, Node.js 18+, Git)
3. Help bij het installeren van ontbrekende vereisten
4. Begeleid door: clone → composer install → npm install → .env instellen
5. Stel SQLite voor als database (makkelijkste optie voor beginners)
6. Voer migrations uit, bouw frontend, start de app
7. Help bij eventuele fouten

REGELS:
- Geef slechts één stap/commando tegelijk
- Wacht op mijn bevestiging/output voordat je verdergaat
- Leg elk commando kort uit in gewone taal
- Als er een fout is, help dan troubleshooten vóór je verder gaat
- Stel aan het einde voor om AI-categorisatie in te stellen (optioneel)

Begin met een vriendelijke begroeting en vraag naar mijn besturingssysteem!</pre>
                    <div style="position:relative;margin:0;padding:0;">
                        <div style="height:40px;background:linear-gradient(to top,rgba(0,0,0,0.4),transparent);position:absolute;bottom:0;left:0;right:0;pointer-events:none;border-radius:0 0 1rem 1rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const installPrompt = `Je bent een vriendelijke installatie-assistent voor BankBird 🐦
BankBird is een open-source persoonlijke financiële administratie app (Laravel 11 + Filament 5).

Jouw taak: begeleid mij stap voor stap door de installatie op mijn computer.
Ga ervan uit dat ik weinig technische kennis heb. Wees geduldig en bemoedigend.

Repo: https://github.com/AivionStudiosPlayground/bankbird

WAT BANKBIRD DOET:
- Bankafschriften importeren (ING PDF en CSV — Rabobank & ABN AMRO volgen binnenkort)
- Transacties automatisch categoriseren via AI (Claude of OpenAI) — optioneel
- Slimme merchant-herkenning via patronen
- Mooie financiële rapporten en overzichten
- Multi-user ondersteuning met 2FA

AANPAK:
1. Vraag eerst naar mijn besturingssysteem (Windows / Mac / Linux)
2. Controleer of de vereisten aanwezig zijn (PHP 8.2+, Composer, Node.js 18+, Git)
3. Help bij het installeren van ontbrekende vereisten
4. Begeleid door: clone → composer install → npm install → .env instellen
5. Stel SQLite voor als database (makkelijkste optie voor beginners)
6. Voer migrations uit, bouw frontend, start de app
7. Help bij eventuele fouten

REGELS:
- Geef slechts één stap/commando tegelijk
- Wacht op mijn bevestiging/output voordat je verdergaat
- Leg elk commando kort uit in gewone taal
- Als er een fout is, help dan troubleshooten vóór je verder gaat
- Stel aan het einde voor om AI-categorisatie in te stellen (optioneel)

Begin met een vriendelijke begroeting en vraag naar mijn besturingssysteem!`;

function copyPrompt(target) {
    function showFeedback() {
        const feedback = document.getElementById('copy-feedback');
        const btnClaude = document.getElementById('btn-claude');
        const btnChatgpt = document.getElementById('btn-chatgpt');

        feedback.style.display = 'block';

        if (target === 'claude') {
            btnClaude.innerHTML = '✅ Gekopieerd!';
            setTimeout(() => { btnClaude.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#CC785C"/><path d="M8 12.5c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="white" stroke-width="1.5" stroke-linecap="round"/><circle cx="12" cy="14" r="2.5" fill="white"/></svg> Kopieer voor Claude'; }, 2500);
        } else {
            btnChatgpt.innerHTML = '✅ Gekopieerd!';
            setTimeout(() => { btnChatgpt.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#74AA9C"/><path d="M7 12h10M12 7v10" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg> Kopieer voor ChatGPT'; }, 2500);
        }

        setTimeout(() => { feedback.style.display = 'none'; }, 5000);
    }

    // Clipboard API (HTTPS) met fallback voor HTTP (zoals .test domeinen)
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(installPrompt).then(showFeedback);
    } else {
        const ta = document.createElement('textarea');
        ta.value = installPrompt;
        ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0;';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        try { document.execCommand('copy'); showFeedback(); } catch(e) {}
        document.body.removeChild(ta);
    }
}
</script>

{{-- Quick nav --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem;">
    <div class="bb-wrap">
        <div style="background:white;border-radius:1.25rem;border:1px solid rgba(30,136,229,0.1);padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
            <span style="font-size:0.8125rem;font-weight:700;color:#6B7A99;margin-right:0.5rem;">Spring naar:</span>
            @foreach([
                ['#vereisten', '📋 Vereisten'],
                ['#installatie', '⬇️ Installatie'],
                ['#configuratie', '⚙️ Configuratie'],
                ['#starten', '▶️ Opstarten'],
                ['#ai', '🤖 AI instellen'],
                ['#problemen', '🔧 Problemen'],
            ] as [$href, $label])
            <a href="{{ $href }}" style="font-size:0.8125rem;font-weight:600;color:#1E88E5;text-decoration:none;padding:0.35rem 0.875rem;background:#EEF5FF;border-radius:99px;border:1px solid rgba(30,136,229,0.2);transition:background 0.15s,transform 0.15s;" onmouseover="this.style.background='#DDEEFF';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#EEF5FF';this.style.transform='none'">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- Content --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem 6rem;">
    <div class="bb-wrap">
        <div style="display:grid;grid-template-columns:1fr;gap:1.5rem;">

            {{-- Stap 1: Vereisten --}}
            <div id="vereisten" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">1</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">📋 Vereisten</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Zorg dat je dit hebt geïnstalleerd</p>
                    </div>
                </div>
                <div class="bb-grid-3" style="gap:1rem;">
                    @foreach([
                        ['⚙️', 'PHP 8.2+', 'Of hoger'],
                        ['🐘', 'Composer', 'v2+'],
                        ['🟢', 'Node.js', 'v18+'],
                        ['🗄️', 'MySQL of SQLite', 'Database'],
                        ['📦', 'Git', 'Voor clonen'],
                        ['🔑', 'API key', 'OpenAI of Anthropic (optioneel)'],
                    ] as [$icon, $name, $desc])
                    <div style="background:#F0F6FF;border-radius:0.875rem;padding:1rem;display:flex;gap:0.75rem;align-items:center;">
                        <span style="font-size:1.375rem;">{{ $icon }}</span>
                        <div>
                            <div style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{{ $name }}</div>
                            <div style="font-size:0.75rem;color:#6B7A99;">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Stap 2: Klonen --}}
            <div id="installatie" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">2</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">⬇️ Repository clonen</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Download de broncode</p>
                    </div>
                </div>
                <div class="bb-code-block">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                    </div>
                    <pre><span class="tok-c"># Clone de repository</span>
<span class="tok-k">git</span> clone https://github.com/AivionStudiosPlayground/bankbird.git
<span class="tok-k">cd</span> bankbird

<span class="tok-c"># Installeer PHP dependencies</span>
<span class="tok-k">composer</span> install

<span class="tok-c"># Installeer Node dependencies</span>
<span class="tok-k">npm</span> install</pre>
                </div>
            </div>

            {{-- Stap 3: Configuratie --}}
            <div id="configuratie" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">3</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">⚙️ Omgeving instellen</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Kopieer en bewerk het configuratiebestand</p>
                    </div>
                </div>
                <div class="bb-code-block" style="margin-bottom:1.25rem;">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                    </div>
                    <pre><span class="tok-k">cp</span> .env.example .env
<span class="tok-k">php</span> artisan key:generate</pre>
                </div>
                <p style="font-size:0.9rem;color:#6B7A99;margin:0 0 1rem;">Pas vervolgens je <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">.env</code> bestand aan met jouw database-gegevens:</p>
                <div class="bb-code-block">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">.env</span>
                    </div>
                    <pre><span class="tok-c"># Database (MySQL voorbeeld)</span>
<span class="tok-v">DB_CONNECTION</span>=mysql
<span class="tok-v">DB_HOST</span>=127.0.0.1
<span class="tok-v">DB_PORT</span>=3306
<span class="tok-v">DB_DATABASE</span>=bankbird
<span class="tok-v">DB_USERNAME</span>=root
<span class="tok-v">DB_PASSWORD</span>=jouw_wachtwoord

<span class="tok-c"># Of gebruik SQLite (makkelijkste optie)</span>
<span class="tok-v">DB_CONNECTION</span>=sqlite</pre>
                </div>
            </div>

            {{-- Stap 4: Database --}}
            <div id="starten" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">4</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">▶️ Database & opstarten</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Maak de tabellen aan en start de app</p>
                    </div>
                </div>
                <div class="bb-code-block" style="margin-bottom:1.25rem;">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                    </div>
                    <pre><span class="tok-c"># Database aanmaken en seeden</span>
<span class="tok-k">php</span> artisan migrate --seed

<span class="tok-c"># Frontend assets bouwen</span>
<span class="tok-k">npm</span> run build

<span class="tok-c"># Development server starten</span>
<span class="tok-k">php</span> artisan serve</pre>
                </div>
                <div class="bb-alert bb-alert-green">
                    <span style="font-size:1.25rem;flex-shrink:0;">🎉</span>
                    <div>
                        <strong>Je bent klaar!</strong> Open <code style="background:rgba(22,199,132,0.15);padding:0.1rem 0.4rem;border-radius:0.25rem;">http://localhost:8000</code> in je browser. Log in met de standaard credentials uit de seeder.
                    </div>
                </div>
            </div>

            {{-- Stap 5: AI --}}
            <div id="ai" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#7C3AED,#5B21B6);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,0.3);">5</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">🤖 AI categorisatie instellen <span style="font-size:0.75rem;color:#6B7A99;font-weight:500;">(optioneel)</span></h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Laat AI je transacties automatisch categoriseren</p>
                    </div>
                </div>
                <div class="bb-code-block" style="margin-bottom:1.25rem;">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">.env</span>
                    </div>
                    <pre><span class="tok-c"># Kies je AI provider</span>
<span class="tok-v">AI_PROVIDER</span>=anthropic  <span class="tok-c"># of: openai</span>

<span class="tok-c"># Anthropic (Claude)</span>
<span class="tok-v">ANTHROPIC_API_KEY</span>=sk-ant-...

<span class="tok-c"># Of OpenAI (GPT)</span>
<span class="tok-v">OPENAI_API_KEY</span>=sk-...</pre>
                </div>
                <div class="bb-alert bb-alert-blue">
                    <span style="font-size:1.25rem;flex-shrink:0;">💡</span>
                    <div>
                        <strong>Tip:</strong> AI is optioneel. Zonder API key kun je transacties ook handmatig of via merchant-patronen categoriseren. Beide werken prima!
                    </div>
                </div>
            </div>

            {{-- Problemen --}}
            <div id="problemen" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:#FFF8F0;border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.375rem;flex-shrink:0;">🔧</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Veelvoorkomende problemen</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Loopt het vast? Hier de meestgestelde vragen</p>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @foreach([
                        ['Geen verbinding met database', 'Controleer je DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME en DB_PASSWORD in .env. Bij SQLite hoef je alleen DB_CONNECTION=sqlite in te stellen.'],
                        ['Vite fout bij npm run build', 'Zorg dat je Node.js v18 of hoger hebt. Probeer eerst `npm install` opnieuw uit te voeren.'],
                        ['AI categorisatie werkt niet', 'Controleer of je API key correct is ingesteld in .env en of je voldoende credits hebt bij je AI provider.'],
                        ['Pagina laadt niet na installatie', 'Voer `php artisan config:clear && php artisan cache:clear` uit om de cache te legen.'],
                    ] as [$problem, $solution])
                    <div style="background:#F0F6FF;border-radius:0.875rem;padding:1.125rem 1.25rem;">
                        <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">❓ {{ $problem }}</div>
                        <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{{ $solution }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="margin-top:1.5rem;" class="bb-alert bb-alert-blue">
                    <span style="font-size:1.25rem;flex-shrink:0;">💬</span>
                    <div>
                        Kom je er niet uit? Open een <strong>issue op GitHub</strong> en we helpen je snel verder!
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
