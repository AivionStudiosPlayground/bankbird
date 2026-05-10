@extends('layouts.public')

@section('title', 'Installatie — BankBird')
@section('description', 'Installeer BankBird in een paar minuten op jouw eigen computer met Laravel Herd. Eén Claude-prompt en je bent klaar.')

@section('content')

{{-- ══════════════════════════════════════════════ --}}
{{-- WORK IN PROGRESS BANNER                       --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#0B1F3A;padding:0.875rem 1.5rem;border-bottom:1px solid rgba(255,138,61,0.3);">
    <div class="bb-wrap" style="display:flex;align-items:center;justify-content:center;gap:0.875rem;flex-wrap:wrap;text-align:center;">
        <span style="background:linear-gradient(135deg,#FF8A3D,#FF6B1A);color:white;font-size:0.6875rem;font-weight:800;padding:0.25rem 0.625rem;border-radius:99px;text-transform:uppercase;letter-spacing:0.06em;flex-shrink:0;">🚧 In ontwikkeling</span>
        <span style="font-size:0.875rem;color:rgba(255,255,255,0.85);line-height:1.5;">
            We werken aan een nieuwe installatieflow met Laravel Herd én een video-opname.
            Onderstaande inhoud is een preview — details kunnen nog wijzigen.
            Heb je nu al hulp nodig? <a href="https://github.com/AivionStudiosPlayground/bankbird#installatie" target="_blank" rel="noopener" style="color:#FF8A3D;font-weight:700;text-decoration:underline;text-underline-offset:2px;">Lees de README op GitHub</a>.
        </span>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- HERO                                          --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-80px;right:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.08) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">🚀 Installatie</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Eén prompt.<br>BankBird draait.
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.85);margin:0;max-width:520px;line-height:1.65;">
                    Geen terminal, geen technische kennis. Met Laravel Herd en een AI-assistent zoals Claude of Codex doe je de hele installatie in vier stappen.
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

{{-- ══════════════════════════════════════════════ --}}
{{-- WAT JE KRIJGT                                 --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2.5rem 1.5rem 0;">
    <div class="bb-wrap">
        <div class="bb-grid-3" style="gap:1rem;">
            @foreach([
                ['⚡', 'Vier stappen', 'Van clone tot draaiend, in een paar minuten'],
                ['🔁', 'Altijd beschikbaar', 'Herd start mee met je computer — nooit meer iets opstarten'],
                ['🐦', 'bankbird.test', 'Eigen lokaal adres in je browser, geen poortnummers'],
            ] as [$icon, $name, $desc])
            <div style="background:white;border:1px solid rgba(30,136,229,0.1);border-radius:1rem;padding:1.25rem;display:flex;gap:0.875rem;align-items:flex-start;">
                <span style="font-size:1.5rem;flex-shrink:0;">{{ $icon }}</span>
                <div>
                    <div style="font-size:0.9375rem;font-weight:800;color:#0B1F3A;margin-bottom:0.25rem;">{{ $name }}</div>
                    <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.55;">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- AI INSTALL ASSISTANT                         --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2.5rem 1.5rem 0;">
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
                        <span style="font-size:0.75rem;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;letter-spacing:0.06em;">AI-installatie assistent</span>
                    </div>
                    <h2 style="font-size:1.625rem;font-weight:900;color:white;margin:0 0 0.75rem;line-height:1.2;">
                        Geen technische kennis nodig 🐦
                    </h2>
                    <p style="font-size:0.9375rem;color:rgba(255,255,255,0.85);margin:0 0 1.5rem;max-width:520px;line-height:1.65;">
                        BankBird bevat een ingebouwd <code style="background:rgba(255,255,255,0.15);padding:0.1rem 0.4rem;border-radius:0.3rem;font-size:0.875em;">AGENTS.md</code> install-protocol. Open Claude Code of Codex in de project-map en geef onderstaande prompt — de agent doet de rest.
                    </p>
                    <div class="bb-flex-center" style="display:flex;gap:0.875rem;flex-wrap:wrap;">
                        <button onclick="copyPrompt()" id="btn-copy" style="display:inline-flex;align-items:center;gap:0.625rem;background:white;color:#1565C0;border:none;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.75rem 1.5rem;cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:transform 0.15s,box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.2)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)'">
                            📋 Kopieer prompt
                        </button>
                        <a href="https://herd.laravel.com/" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:0.625rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.625rem 1.5rem;text-decoration:none;transition:background 0.15s,transform 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.12)';this.style.transform='none'">
                            ⬇️ Download Herd
                        </a>
                    </div>
                    <div id="copy-feedback" style="display:none;margin-top:1rem;background:rgba(22,199,132,0.2);border:1px solid rgba(22,199,132,0.4);border-radius:0.625rem;padding:0.625rem 1rem;font-size:0.875rem;font-weight:600;color:#A7F3D0;">
                        ✅ Prompt gekopieerd! Plak hem in Claude Code of Codex CLI.
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
                        <span style="font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;margin-left:auto;">prompt.txt</span>
                    </div>
                    <pre id="install-prompt" style="margin:0;padding:1.25rem;font-size:0.875rem;line-height:1.7;color:rgba(255,255,255,0.9);font-family:'JetBrains Mono','Fira Code',ui-monospace,monospace;">Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me.</pre>
                </div>
                <p style="margin:0.875rem 0 0;font-size:0.75rem;color:rgba(255,255,255,0.55);line-height:1.55;">
                    Eén regel volstaat. De agent leest het <code style="background:rgba(255,255,255,0.1);padding:0.05rem 0.3rem;border-radius:0.25rem;font-size:0.95em;color:rgba(255,255,255,0.85);">End-user installation protocol</code> in <code style="background:rgba(255,255,255,0.1);padding:0.05rem 0.3rem;border-radius:0.25rem;font-size:0.95em;color:rgba(255,255,255,0.85);">AGENTS.md</code> en doorloopt zelf alle stappen.
                </p>
            </div>
        </div>
    </div>
</section>

<script>
const installPrompt = `Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me.`;

function copyPrompt() {
    function showFeedback() {
        const feedback = document.getElementById('copy-feedback');
        const btn = document.getElementById('btn-copy');
        feedback.style.display = 'block';
        btn.innerHTML = '✅ Gekopieerd!';
        setTimeout(() => { btn.innerHTML = '📋 Kopieer prompt'; }, 2500);
        setTimeout(() => { feedback.style.display = 'none'; }, 5000);
    }
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(installPrompt).then(showFeedback);
    } else {
        const ta = document.createElement('textarea');
        ta.value = installPrompt;
        ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0;';
        document.body.appendChild(ta);
        ta.focus(); ta.select();
        try { document.execCommand('copy'); showFeedback(); } catch(e) {}
        document.body.removeChild(ta);
    }
}
</script>

{{-- ══════════════════════════════════════════════ --}}
{{-- QUICK NAV                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem;">
    <div class="bb-wrap">
        <div style="background:white;border-radius:1.25rem;border:1px solid rgba(30,136,229,0.1);padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
            <span style="font-size:0.8125rem;font-weight:700;color:#6B7A99;margin-right:0.5rem;">Spring naar:</span>
            @foreach([
                ['#stap-1', '1️⃣ Herd'],
                ['#stap-2', '2️⃣ Clone'],
                ['#stap-3', '3️⃣ Prompt'],
                ['#stap-4', '4️⃣ Klaar'],
                ['#https',  '🔒 HTTPS (optioneel)'],
                ['#geavanceerd', '🛠 Geavanceerd'],
                ['#problemen', '🔧 Problemen'],
            ] as [$href, $label])
            <a href="{{ $href }}" style="font-size:0.8125rem;font-weight:600;color:#1E88E5;text-decoration:none;padding:0.35rem 0.875rem;background:#EEF5FF;border-radius:99px;border:1px solid rgba(30,136,229,0.2);transition:background 0.15s,transform 0.15s;" onmouseover="this.style.background='#DDEEFF';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#EEF5FF';this.style.transform='none'">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- DE 4 STAPPEN                                  --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem 4rem;">
    <div class="bb-wrap">
        <div style="display:grid;grid-template-columns:1fr;gap:1.5rem;">

            {{-- Stap 1: Herd --}}
            <div id="stap-1" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">1</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">⬇️ Installeer Laravel Herd</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Eénmalig — bundelt PHP, Composer en Node, draait op de achtergrond</p>
                    </div>
                </div>
                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0 0 1.25rem;">
                    Herd is een gratis tool van het Laravel-team. Hij installeert alles wat BankBird nodig heeft, en zorgt dat je app altijd op de achtergrond draait op <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">http://bankbird.test</code> — ook na een herstart.
                </p>
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
                    <a href="https://herd.laravel.com/" target="_blank" rel="noopener" class="bb-btn">
                        Download Laravel Herd
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                    </a>
                    <span style="font-size:0.8125rem;color:#6B7A99;">Beschikbaar voor Windows en macOS · Gratis</span>
                </div>
                <div style="margin-top:1.25rem;" class="bb-alert bb-alert-blue">
                    <span style="font-size:1.125rem;flex-shrink:0;">💡</span>
                    <div style="font-size:0.875rem;line-height:1.6;">
                        <strong>Geen Herd?</strong> Vraag Claude/Codex om hem te installeren — de agent download de installer en je hoeft alleen één keer "Ja" te klikken op de Windows-beveiligingsprompt (UAC).
                    </div>
                </div>
            </div>

            {{-- Stap 2: Clone --}}
            <div id="stap-2" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">2</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">📥 Clone de repository</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Download de broncode op een plek naar keuze</p>
                    </div>
                </div>
                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0 0 1.25rem;">
                    Open een terminal (Herd levert er één mee — of gebruik Windows Terminal / iTerm), navigeer naar waar je BankBird wilt opslaan en run:
                </p>
                <div class="bb-code-block">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                    </div>
                    <pre><span class="tok-k">git</span> clone https://github.com/AivionStudiosPlayground/bankbird.git
<span class="tok-k">cd</span> bankbird</pre>
                </div>
            </div>

            {{-- Stap 3: Prompt --}}
            <div id="stap-3" class="bb-card-flat reveal" style="padding:2rem;">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(30,136,229,0.3);">3</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">🤖 Vraag Claude of Codex</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Eén prompt — de agent doet de rest</p>
                    </div>
                </div>
                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0 0 1.25rem;">
                    Open Claude Code of Codex CLI in de project-map en geef deze prompt:
                </p>
                <div class="bb-code-block">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">prompt</span>
                    </div>
                    <pre style="font-size:0.9375rem;line-height:1.6;color:white;">Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me.</pre>
                </div>
                <div style="margin-top:1.25rem;" class="bb-alert bb-alert-blue">
                    <span style="font-size:1.125rem;flex-shrink:0;">📜</span>
                    <div style="font-size:0.875rem;line-height:1.6;">
                        De agent volgt het <a href="https://github.com/AivionStudiosPlayground/bankbird/blob/master/AGENTS.md#end-user-installation-protocol" target="_blank" rel="noopener" style="color:#1565C0;font-weight:700;text-decoration:underline;">End-user installation protocol</a> uit <code style="background:rgba(30,136,229,0.1);padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;">AGENTS.md</code>: Herd-detectie, dependencies installeren, het project aan Herd koppelen (<code style="background:rgba(30,136,229,0.1);padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;">herd link bankbird</code>), database opzetten, admin-account aanmaken en een smoke-test op de loginpagina.
                    </div>
                </div>
            </div>

            {{-- Stap 4: Klaar --}}
            <div id="stap-4" class="bb-card-flat reveal" style="padding:2rem;border:2px solid rgba(22,199,132,0.3);">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#16C784,#0D9F66);border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;font-weight:900;color:white;flex-shrink:0;box-shadow:0 4px 12px rgba(22,199,132,0.3);">4</div>
                    <div>
                        <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">🎉 Open je browser</h2>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Voor altijd beschikbaar — geen server starten, geen terminal</p>
                    </div>
                </div>
                <p style="font-size:0.9375rem;color:#0B1F3A;line-height:1.65;margin:0 0 1.25rem;">
                    Zodra de agent meldt dat alles klaar is:
                </p>
                <div class="bb-code-block">
                    <div class="bb-code-bar">
                        <div class="bb-dot" style="background:#FF6058;"></div>
                        <div class="bb-dot" style="background:#FFBD2E;"></div>
                        <div class="bb-dot" style="background:#27C93F;"></div>
                        <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">browser</span>
                    </div>
                    <pre style="font-size:1rem;line-height:1.6;color:white;">http://bankbird.test/</pre>
                </div>
                <div style="margin-top:1.25rem;" class="bb-alert bb-alert-green">
                    <span style="font-size:1.25rem;flex-shrink:0;">✨</span>
                    <div style="font-size:0.9rem;line-height:1.6;">
                        <strong>Klaar voor altijd.</strong> Herd start automatisch met je computer. Vanaf nu open je BankBird gewoon in je browser, ook na een herstart. Claude/Codex heb je alleen nog nodig voor updates of hulp bij fouten.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- HTTPS (OPTIONEEL)                             --}}
{{-- ══════════════════════════════════════════════ --}}
<section id="https" style="background:#F0F6FF;padding:1rem 1.5rem 2rem;">
    <div class="bb-wrap">
        <div class="bb-card-flat reveal" style="padding:2rem;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                <div style="width:2.5rem;height:2.5rem;background:#FFF8F0;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;">🔒</div>
                <div>
                    <h2 style="font-size:1.125rem;font-weight:800;margin:0;color:#0B1F3A;">HTTPS aanzetten <span style="font-size:0.75rem;color:#6B7A99;font-weight:500;">(optioneel)</span></h2>
                    <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Default draait BankBird op HTTP — voor lokaal gebruik veilig genoeg</p>
                </div>
            </div>
            <p style="font-size:0.9rem;color:#0B1F3A;line-height:1.65;margin:0 0 1rem;">
                Wil je een groen slotje? Run één keer in de project-map:
            </p>
            <div class="bb-code-block" style="margin-bottom:1rem;">
                <div class="bb-code-bar">
                    <div class="bb-dot" style="background:#FF6058;"></div>
                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                    <div class="bb-dot" style="background:#27C93F;"></div>
                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                </div>
                <pre><span class="tok-k">herd</span> secure</pre>
            </div>
            <p style="font-size:0.875rem;color:#6B7A99;line-height:1.6;margin:0;">
                Volg de Windows-prompt om Herd's lokale certificaat te vertrouwen (één UAC-klik). Daarna werkt <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">https://bankbird.test</code>.
            </p>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- GEAVANCEERD                                   --}}
{{-- ══════════════════════════════════════════════ --}}
<section id="geavanceerd" style="background:#F0F6FF;padding:1rem 1.5rem 2rem;">
    <div class="bb-wrap">
        <div class="bb-card-flat reveal" style="padding:2rem;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                <div style="width:2.5rem;height:2.5rem;background:#F5F0FF;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;">🛠</div>
                <div>
                    <h2 style="font-size:1.125rem;font-weight:800;margin:0;color:#0B1F3A;">Geavanceerd: handmatige installatie</h2>
                    <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Voor ontwikkelaars of installs zonder Herd</p>
                </div>
            </div>
            <p style="font-size:0.9rem;color:#0B1F3A;line-height:1.65;margin:0 0 1rem;">
                Wil je elke stap zelf doen? Na <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">git clone</code>:
            </p>
            <div class="bb-code-block" style="margin-bottom:1rem;">
                <div class="bb-code-bar">
                    <div class="bb-dot" style="background:#FF6058;"></div>
                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                    <div class="bb-dot" style="background:#27C93F;"></div>
                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">bash</span>
                </div>
                <pre><span class="tok-k">composer</span> install
<span class="tok-k">composer</span> run setup
<span class="tok-k">php</span> artisan make:filament-user</pre>
            </div>
            <p style="font-size:0.875rem;color:#6B7A99;line-height:1.6;margin:0 0 1rem;">
                Zonder Herd start je de dev-server zelf met <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">composer run dev</code> en open je <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.85em;color:#1565C0;">http://127.0.0.1:8000/</code>. Let op: deze server moet je elke keer handmatig starten.
            </p>
            <div class="bb-alert bb-alert-orange">
                <span style="font-size:1.125rem;flex-shrink:0;">⚠️</span>
                <div style="font-size:0.875rem;line-height:1.6;">
                    <strong>Vereisten zonder Herd:</strong> PHP 8.4 (8.5 nog niet ondersteund), Composer 2+, Node.js 20+, Git.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- PROBLEMEN                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<section id="problemen" style="background:#F0F6FF;padding:1rem 1.5rem 6rem;">
    <div class="bb-wrap">
        <div class="bb-card-flat reveal" style="padding:2rem;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                <div style="width:3rem;height:3rem;background:#FFF8F0;border-radius:0.875rem;display:flex;align-items:center;justify-content:center;font-size:1.375rem;flex-shrink:0;">🔧</div>
                <div>
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0;color:#0B1F3A;">Veelvoorkomende problemen</h2>
                    <p style="font-size:0.8125rem;color:#6B7A99;margin:0;">Loopt het vast? Begin hier</p>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                @foreach([
                    ['bankbird.test laadt niet', 'Controleer in de Herd-app onder "Sites" of "bankbird" als geparkeerde site staat. Zo niet, run in de project-map: <code>herd link bankbird</code>.'],
                    ['Login werkt niet / pagina refresht', 'Vrijwel altijd een PHP-versieprobleem (PHP 8.5 i.p.v. 8.4). Open Herd en zet de PHP-versie voor deze site op 8.4. BankBird ondersteunt PHP 8.5 nog niet.'],
                    ['SSL-foutmelding bij https://bankbird.test', 'Run <code>herd secure</code> in de project-map en bevestig de Windows-prompt om Herd\'s lokale certificaat te vertrouwen. Of blijf HTTP gebruiken — voor lokaal gebruik is dat prima.'],
                    ['"localhost" werkt niet (zonder Herd)', 'Gebruik <code>http://127.0.0.1:8000</code> in plaats van <code>localhost</code>. Op Windows resolved <code>localhost</code> vaak naar IPv6, terwijl <code>php artisan serve</code> alleen IPv4 luistert.'],
                    ['"Class not found" of Vite-fout', 'Run <code>composer dump-autoload</code> en <code>npm run build</code> opnieuw. Bij hardnekkige problemen: <code>php artisan optimize:clear</code>.'],
                ] as [$problem, $solution])
                <div style="background:#F0F6FF;border-radius:0.875rem;padding:1.125rem 1.25rem;">
                    <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">❓ {{ $problem }}</div>
                    <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{!! $solution !!}</div>
                </div>
                @endforeach
            </div>
            <div style="margin-top:1.5rem;" class="bb-alert bb-alert-blue">
                <span style="font-size:1.25rem;flex-shrink:0;">💬</span>
                <div style="font-size:0.9rem;line-height:1.6;">
                    Kom je er niet uit? Open een <a href="https://github.com/AivionStudiosPlayground/bankbird/issues" target="_blank" rel="noopener" style="color:#1565C0;font-weight:700;text-decoration:underline;">issue op GitHub</a> en we helpen je snel verder.
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- WAT NU? — funnel naar volgende stappen        --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:1rem 1.5rem 4rem;">
    <div class="bb-wrap">
        <div style="text-align:center;margin-bottom:2rem;">
            <h2 style="font-size:clamp(1.5rem,2.5vw,2rem);font-weight:900;margin:0 0 0.5rem;color:#0B1F3A;letter-spacing:-0.02em;">Wat nu?</h2>
            <p style="font-size:0.9375rem;color:#6B7A99;margin:0;">Drie handige plekken om verder te kijken</p>
        </div>
        <div class="bb-grid-3" style="gap:1rem;">
            @foreach([
                ['/demo', '🐦', 'Bekijk de demo', 'Eerst zien hoe BankBird werkt voordat je installeert? Open de live demo met voorbeelddata.'],
                ['/faq', '❓', 'Lees de FAQ', 'Antwoorden op vragen over open source, je data, AI-categorisatie en wat je met BankBird mag doen.'],
                ['/docs', '📚', 'Naar de docs', 'Diepere technische documentatie voor wie zelf wil sleutelen of integreren.'],
            ] as [$href, $icon, $title, $desc])
            <a href="{{ url($href) }}" class="bb-card" style="padding:1.5rem;text-decoration:none;display:flex;flex-direction:column;gap:0.625rem;">
                <span style="font-size:1.75rem;">{{ $icon }}</span>
                <div style="font-size:1rem;font-weight:800;color:#0B1F3A;">{{ $title }}</div>
                <div style="font-size:0.875rem;color:#6B7A99;line-height:1.55;flex:1;">{{ $desc }}</div>
                <div style="font-size:0.8125rem;font-weight:700;color:#1E88E5;margin-top:0.25rem;">Bekijk →</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
