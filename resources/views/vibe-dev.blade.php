@extends('layouts.public')

@section('title', 'Vibe Development — BankBird')
@section('description', 'Bouw zelf verder aan BankBird met AI. Leer hoe je eigen importers maakt, hoe updates werken en hoe je data veilig staat.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#1B0057,#3A0CA3,#560BAD);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:420px;height:420px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">🛠️ Vibe Development</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Bouw zelf verder<br>met AI
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0;max-width:520px;line-height:1.65;">
                    BankBird is open-source en ontworpen om uitgebreid te worden. Op deze pagina vind je tools, hints en praktijkvoorbeelden om het systeem zelf verder te ontwikkelen — met of zonder diepgaande programmeerkennis.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4.5s ease-in-out infinite;" class="hidden-mobile">
                <div style="font-size:7rem;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.3));">🤖</div>
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
        <div class="bb-grid-2" style="grid-template-columns:220px 1fr;gap:2.5rem;align-items:start;">

            {{-- Sidebar TOC --}}
            <div style="position:sticky;top:84px;" class="hidden-mobile">
                <div class="bb-card-flat" style="padding:1.25rem;">
                    <div style="font-size:0.75rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#6B7A99;margin-bottom:1rem;">Inhoud</div>
                    <nav style="display:flex;flex-direction:column;gap:0.125rem;">
                        @foreach([
                            ['#voorbereiding', '🚀 Voorbereiding'],
                            ['#wat-is-vibe-dev', '🛠️ Wat is Vibe Dev?'],
                            ['#eigen-import', '🏦 Eigen import bouwen'],
                            ['#conflicten', '⚠️ Conflicten & updates'],
                            ['#git-en-updates', '🔄 Git & updates'],
                            ['#iban-veiligheid', '🔒 IBAN veiligheid'],
                            ['#backup-datasource', '🗂️ Backup als datasource'],
                        ] as [$href, $label])
                        <a href="{{ $href }}" style="font-size:0.8125rem;color:#6B7A99;text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;transition:color 0.15s,background 0.15s;" onmouseover="this.style.color='#7C3AED';this.style.background='#F5F0FF'" onmouseout="this.style.color='#6B7A99';this.style.background='transparent'">{{ $label }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Main content --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;min-width:0;">

                {{-- Voorbereiding --}}
                <div id="voorbereiding" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🚀</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Bereid je voor — wat heb je nodig?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Vibe Development werkt het best als je de juiste tools klaarstaan. Dit is wat je nodig hebt voordat je begint — ook als je nog nooit code hebt geschreven.
                    </p>

                    {{-- Stap 1: AI tool kiezen --}}
                    <div style="margin-bottom:1.5rem;">
                        <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;">① Kies je AI coding tool</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div style="background:#F5F0FF;border:2px solid rgba(124,58,237,0.2);border-radius:1rem;padding:1.25rem;">
                                <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.75rem;">
                                    <span style="font-size:1.375rem;">🤖</span>
                                    <div>
                                        <div style="font-weight:800;color:#3B0764;font-size:0.9375rem;">Claude Code</div>
                                        <div style="font-size:0.75rem;color:#7C3AED;">claude.ai/code</div>
                                    </div>
                                </div>
                                <ul style="margin:0;padding:0 0 0 1.125rem;display:flex;flex-direction:column;gap:0.3rem;">
                                    @foreach(['Desktop app + terminal', 'Werkt met elke editor', 'Aanrader voor beginners', 'Gratis te starten'] as $item)
                                    <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div style="background:#F0F4FF;border:2px solid rgba(30,136,229,0.15);border-radius:1rem;padding:1.25rem;">
                                <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.75rem;">
                                    <span style="font-size:1.375rem;">💬</span>
                                    <div>
                                        <div style="font-weight:800;color:#0D47A1;font-size:0.9375rem;">ChatGPT / Codex</div>
                                        <div style="font-size:0.75rem;color:#1E88E5;">chatgpt.com</div>
                                    </div>
                                </div>
                                <ul style="margin:0;padding:0 0 0 1.125rem;display:flex;flex-direction:column;gap:0.3rem;">
                                    @foreach(['In de browser, geen installatie', 'Codex werkt via de API', 'Handig als je al ChatGPT Plus hebt', 'Gratis basisversie beschikbaar'] as $item)
                                    <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0.75rem 0 0;line-height:1.6;">
                            Beide werken prima voor BankBird. Kies wat je al kent, of probeer Claude Code als je helemaal nieuw bent.
                        </p>
                    </div>

                    {{-- Stap 2: Projectmap aanmaken --}}
                    <div style="margin-bottom:1.5rem;">
                        <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;">② Maak een lege projectmap aan</div>
                        <p style="font-size:0.875rem;color:#6B7A99;line-height:1.6;margin:0 0 0.875rem;">
                            Maak eerst een lege map aan op je computer (bijv. op je bureaublad of in je <code style="background:#F5F0FF;padding:0.1rem 0.4rem;border-radius:0.25rem;font-size:0.8125rem;color:#5B21B6;">Documenten</code>-map). Open die map daarna in je AI-tool.
                        </p>
                        <div style="display:flex;flex-direction:column;gap:0.75rem;">
                            @foreach([
                                ['🪟', 'Windows', 'Rechtermuisknop op je bureaublad → Nieuw → Map. Naam: <code style="background:#EEE;padding:0.1rem 0.3rem;border-radius:0.25rem;font-size:0.75rem;">bankbird</code>. Sleep de map naar Claude Code, of open de map via Bestand → Map openen.'],
                                ['🍎', 'Mac', 'Open Finder → ga naar je gewenste locatie → Cmd+Shift+N voor een nieuwe map. Open de map in Claude Code via het menu of door hem erin te slepen.'],
                                ['🐧', 'Linux', 'Gebruik <code style="background:#EEE;padding:0.1rem 0.3rem;border-radius:0.25rem;font-size:0.75rem;">mkdir ~/bankbird</code> in je terminal, en open de map daarna in je AI-tool.'],
                            ] as [$icon, $os, $desc])
                            <div style="background:#F9FAFB;border:1px solid #E5E7EB;border-radius:0.875rem;padding:1rem 1.125rem;display:flex;gap:0.875rem;align-items:flex-start;">
                                <span style="font-size:1.25rem;flex-shrink:0;">{{ $icon }}</span>
                                <div>
                                    <div style="font-size:0.875rem;font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $os }}</div>
                                    <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.6;">{!! $desc !!}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Stap 3: Dan de installatie --}}
                    <div style="background:linear-gradient(135deg,#F5F0FF,#EEE8FF);border:1px solid rgba(124,58,237,0.15);border-radius:1rem;padding:1.25rem;display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                        <div style="flex:1;min-width:220px;">
                            <div style="font-size:0.875rem;font-weight:800;color:#3B0764;margin-bottom:0.375rem;">③ Je bent klaar om te installeren!</div>
                            <p style="font-size:0.8125rem;color:#5B21B6;margin:0;line-height:1.6;">
                                Je hebt een AI-tool en een lege projectmap. Volg nu de installatiestappen om BankBird op te zetten.
                            </p>
                        </div>
                        <a href="{{ url('/install') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:#7C3AED;color:white;border-radius:0.875rem;font-weight:700;font-size:0.875rem;padding:0.625rem 1.25rem;text-decoration:none;white-space:nowrap;box-shadow:0 4px 12px rgba(124,58,237,0.3);transition:transform 0.15s,box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(124,58,237,0.4)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 12px rgba(124,58,237,0.3)'">
                            Naar de installatie →
                        </a>
                    </div>
                </div>

                {{-- Wat is Vibe Development --}}
                <div id="wat-is-vibe-dev" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
                        <span style="font-size:1.375rem;">🛠️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Wat is Vibe Development?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.25rem;">
                        Vibe Development betekent dat je met behulp van AI — zoals Claude of ChatGPT — zelf nieuwe functies toevoegt aan BankBird, zonder dat je een doorgewinterd PHP-developer hoeft te zijn. Je beschrijft wat je wilt, de AI schrijft de code, en jij past het aan totdat het werkt.
                    </p>
                    <div class="bb-grid-2" style="gap:1rem;">
                        @foreach([
                            ['✅', 'Wat werkt goed', '#E8F5E9', '#1B5E20', ['Nieuwe bankimport toevoegen', 'Extra rapportfilters bouwen', 'Eigen exportformaten', 'Integraties met andere tools']],
                            ['⚠️', 'Waar je op let', '#FFF3E0', '#BF360C', ['Core-bestanden aanpassen', 'Database-schema\'s wijzigen', 'Authenticatie aanraken', 'Updates kunnen je wijzigingen overschrijven']],
                        ] as [$icon, $label, $bg, $color, $items])
                        <div style="background:{{ $bg }};border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:{{ $color }};margin-bottom:0.875rem;font-size:0.9375rem;">{{ $icon }} {{ $label }}</div>
                            <ul style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach($items as $item)
                                <li style="font-size:0.8125rem;color:#0B1F3A;line-height:1.5;">{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Eigen import bouwen --}}
                <div id="eigen-import" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
                        <span style="font-size:1.375rem;">🏦</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Praktijkvoorbeeld: eigen bankimport</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Stel: ABN AMRO import staat nog niet in BankBird, maar jij hebt een ABN-rekening. Je kunt de import zelf bouwen. Hier is hoe je dat aanpakt met AI.
                    </p>

                    {{-- Stap 1 --}}
                    <div style="display:flex;flex-direction:column;gap:1.25rem;">
                        @foreach([
                            ['1', '#7C3AED', 'Download je bankafschrift', 'Ga naar je bank-app en download een CSV of MT940 export van je transacties. Sla dit bestand op — je gaat het als voorbeeld gebruiken in je prompt.'],
                            ['2', '#7C3AED', 'Geef je AI de context', 'Open Claude (claude.ai) of ChatGPT (chatgpt.com) en geef het systeem uitleg mee. Gebruik de prompt hieronder als startpunt.'],
                        ] as [$num, $color, $title, $desc])
                        <div style="display:flex;gap:1rem;align-items:flex-start;">
                            <div style="width:2rem;height:2rem;background:{{ $color }};color:white;border-radius:50%;font-size:0.8125rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $num }}</div>
                            <div>
                                <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $title }}</div>
                                <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach

                        {{-- Prompt voorbeeld --}}
                        <div class="bb-code-block">
                            <div class="bb-code-bar">
                                <div class="bb-dot" style="background:#FF6058;"></div>
                                <div class="bb-dot" style="background:#FFBD2E;"></div>
                                <div class="bb-dot" style="background:#27C93F;"></div>
                                <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">prompt voor Claude / ChatGPT</span>
                            </div>
                            <pre><span class="tok-c">Ik werk met BankBird, een Laravel 11 + Filament 5 applicatie
voor persoonlijke financiële administratie. Ik wil een nieuwe
bankimport toevoegen voor ABN AMRO CSV-bestanden.

Het ABN AMRO CSV-formaat heeft deze kolommen:
[plak hier de eerste 3-5 regels van je CSV-bestand]

De bestaande ING CSV-import staat in:
app/Services/Importers/IngCsvImporter.php

Maak een vergelijkbare klasse AbnAmroCsvImporter die:
- hetzelfde ImporterInterface implementeert
- de ABN AMRO kolomnamen correct mapt
- het bedrag omzet naar een positief/negatief getal

Geef mij de volledige PHP-klasse terug.</span></pre>
                        </div>

                        @foreach([
                            ['3', '#7C3AED', 'Zet het bestand op de juiste plek', 'Sla de door AI gegenereerde klasse op in app/Services/Importers/AbnAmroCsvImporter.php. BankBird detecteert importers automatisch als ze het ImporterInterface implementeren.'],
                            ['4', '#7C3AED', 'Test met een klein bestand', 'Ga in het admin panel naar Imports > Nieuw en upload een klein CSV-bestand (5–10 regels). Controleer of de transacties correct worden ingelezen.'],
                        ] as [$num, $color, $title, $desc])
                        <div style="display:flex;gap:1rem;align-items:flex-start;">
                            <div style="width:2rem;height:2rem;background:{{ $color }};color:white;border-radius:50%;font-size:0.8125rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $num }}</div>
                            <div>
                                <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $title }}</div>
                                <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Conflicten --}}
                <div id="conflicten" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">⚠️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Conflicten met toekomstige updates</h2>
                    </div>

                    <div class="bb-alert bb-alert-orange" style="margin-bottom:1.5rem;">
                        <span style="font-size:1.25rem;flex-shrink:0;">🔔</span>
                        <div style="font-size:0.9rem;line-height:1.6;"><strong>Belangrijk om te weten:</strong> als jij zelf een ABN AMRO import bouwt en wij later ook een officiële ABN AMRO import uitbrengen, kunnen die twee met elkaar botsen — met dubbele of foutieve imports als gevolg.</div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:1rem;">

                        {{-- Scenario 1 --}}
                        <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.75rem;font-size:0.9375rem;">📌 Scenario: Jouw import vs. de officiële versie</div>
                            <p style="font-size:0.875rem;color:#6B7A99;line-height:1.6;margin:0 0 1rem;">
                                Stel: je hebt <code style="font-size:0.8rem;">AbnAmroCsvImporter.php</code> zelf gebouwd. Na een update brengen wij een officiële versie uit. Er zijn drie opties:
                            </p>
                            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                                @foreach([
                                    ['✅', 'Jouw versie deactiveren', 'Verwijder of hernoem je eigen importer. De officiële versie neemt het over. Kies dit als de officiële versie alles doet wat jij nodig hebt.'],
                                    ['🔀', 'Jouw versie houden', 'Hernoem je klasse naar bijv. <code>MijnAbnAmroCsvImporter</code> zodat er geen botsing is. Beide importers bestaan naast elkaar.'],
                                    ['🔧', 'Samenvoegen', 'Vergelijk jouw versie met de officiële en neem de beste aanpak over. Gebruik een diff-tool of vraag Claude of ChatGPT om de twee versies samen te voegen.'],
                                ] as [$icon, $title, $desc])
                                <div style="display:flex;gap:0.75rem;align-items:flex-start;">
                                    <span style="font-size:1.125rem;flex-shrink:0;margin-top:0.1rem;">{{ $icon }}</span>
                                    <div>
                                        <div style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{!! $title !!}</div>
                                        <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{!! $desc !!}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Prompt tip --}}
                        <div style="background:#F5F0FF;border:1px solid rgba(124,58,237,0.15);border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#5B21B6;margin-bottom:0.75rem;font-size:0.875rem;">💡 Tip: vraag het aan Claude of ChatGPT</div>
                            <div class="bb-code-block">
                                <div class="bb-code-bar">
                                    <div class="bb-dot" style="background:#FF6058;"></div>
                                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                                    <div class="bb-dot" style="background:#27C93F;"></div>
                                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">prompt</span>
                                </div>
                                <pre><span class="tok-c">Ik heb zelf een ABN AMRO importer gebouwd [plak jouw code].
BankBird heeft nu ook een officiële versie uitgebracht [plak
nieuwe code]. Welke aanpak raad je aan? Zijn er conflicten?
Kun je de beste versie samenvoegen?</span></pre>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Git & updates --}}
                <div id="git-en-updates" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🔄</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Git & updates — hoe werkt dat?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        BankBird wordt bijgewerkt via Git. Als je veel zelf hebt aangepast, kan een <code>git pull</code> voor problemen zorgen. Hier zijn de drie meest gebruikte aanpakken:
                    </p>

                    <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.5rem;">

                        @foreach([
                            ['🟢', 'Aanpak 1: Eigen bestanden, kern ongewijzigd', 'De veiligste manier. Voeg alleen <em>nieuwe</em> bestanden toe (nieuwe importers, widgets, etc.) zonder bestaande bestanden aan te passen. Updates van BankBird zullen jouw toevoegingen niet overschrijven.', 'Laag risico'],
                            ['🟡', 'Aanpak 2: Fork op GitHub', 'Fork de BankBird repository op GitHub. Doe jouw aanpassingen op je eigen fork. Haal updates binnen via <code>git merge upstream/main</code>. Conflicts los je op in je eigen branch.', 'Gemiddeld risico'],
                            ['🔴', 'Aanpak 3: Directe aanpassingen zonder fork', 'Je past core-bestanden aan zonder fork. Updates overschrijven je wijzigingen bij een <code>git pull</code> als er geen conflicts zijn — of ze blokkeren de update. Maak altijd eerst een backup.', 'Hoog risico'],
                        ] as [$dot, $title, $desc, $risk])
                        <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                                <div style="font-weight:800;color:#0B1F3A;font-size:0.9375rem;">{{ $dot }} {!! $title !!}</div>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;background:white;border:1px solid #DDEAF3;padding:0.15rem 0.5rem;border-radius:99px;">{{ $risk }}</span>
                            </div>
                            <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{!! $desc !!}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="bb-alert bb-alert-blue">
                        <span style="font-size:1.25rem;flex-shrink:0;">💡</span>
                        <div style="font-size:0.875rem;line-height:1.6;"><strong>Gouden regel:</strong> hoe meer je werkt met <em>nieuwe</em> bestanden in plaats van bestaande aan te passen, hoe makkelijker updates verlopen. Gebruik Laravel's extension points: maak nieuwe Service-klassen, nieuwe Filament-pagina's, nieuwe Importers.</div>
                    </div>
                </div>

                {{-- IBAN veiligheid --}}
                <div id="iban-veiligheid" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🔒</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Hoe staat je IBAN veilig in de database?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Een IBAN is gevoelige financiële informatie. BankBird slaat dit <strong>versleuteld</strong> op via Laravel's ingebouwde encryptie. Hier is het volledige plaatje — van database tot PHP-code.
                    </p>

                    <div style="display:flex;flex-direction:column;gap:1.25rem;">

                        {{-- Stap 1: In de database --}}
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">1. Wat staat er letterlijk in de database?</div>
                            <div class="bb-code-block">
                                <div class="bb-code-bar">
                                    <div class="bb-dot" style="background:#FF6058;"></div>
                                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                                    <div class="bb-dot" style="background:#27C93F;"></div>
                                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">database · accounts tabel</span>
                                </div>
                                <pre><span class="tok-c">-- Wat je ziet als je de database opengooit:</span>
id  | name            | iban
----+-----------------+---------------------------------------------------
1   | ING Betaalrek.  | <span class="tok-s">eyJpdiI6IkZwVXZGME...</span><span class="tok-c">(lange versleutelde string)</span>
2   | Spaarrekening   | <span class="tok-s">eyJpdiI6InhkdDFQQ3...</span><span class="tok-c">(lange versleutelde string)</span>

<span class="tok-c">-- Je echte IBAN (NL59INGB...) is nergens in klare tekst zichtbaar.</span></pre>
                            </div>
                        </div>

                        {{-- Stap 2: In de code --}}
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">2. Hoe werkt de versleuteling in de code?</div>
                            <div class="bb-code-block">
                                <div class="bb-code-bar">
                                    <div class="bb-dot" style="background:#FF6058;"></div>
                                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                                    <div class="bb-dot" style="background:#27C93F;"></div>
                                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">app/Models/Account.php</span>
                                </div>
                                <pre><span class="tok-k">protected function</span> <span class="tok-fn">casts</span>(): <span class="tok-k">array</span>
{
    <span class="tok-k">return</span> [
        <span class="tok-s">'iban'</span> => <span class="tok-s">'encrypted'</span>, <span class="tok-c">// ← Laravel versleutelt automatisch</span>
        <span class="tok-s">'type'</span> => AccountType::<span class="tok-k">class</span>,
        <span class="tok-s">'balance'</span> => <span class="tok-s">'decimal:2'</span>,
    ];
}

<span class="tok-c">// Opslaan: Laravel versleutelt automatisch</span>
<span class="tok-fn">Account</span>::create([
    <span class="tok-s">'iban'</span> => <span class="tok-s">'NL59INGB0653592555'</span>,  <span class="tok-c">// jij geeft klare tekst</span>
]);

<span class="tok-c">// Uitlezen: Laravel ontsleutelt automatisch</span>
$account = <span class="tok-fn">Account</span>::find(1);
<span class="tok-k">echo</span> $account->iban; <span class="tok-c">// → 'NL59INGB0653592555' (klare tekst)</span></pre>
                            </div>
                        </div>

                        {{-- Stap 3: APP_KEY --}}
                        <div style="background:#F0FFF8;border:1px solid rgba(22,199,132,0.2);border-radius:1rem;padding:1.25rem;">
                            <div style="font-size:0.875rem;font-weight:800;color:#0A9660;margin-bottom:0.625rem;">🔑 De sleutel: APP_KEY</div>
                            <p style="font-size:0.875rem;color:#0B1F3A;line-height:1.6;margin:0 0 0.75rem;">
                                De versleuteling werkt via de <code>APP_KEY</code> in je <code>.env</code>-bestand. Dit is een unieke 32-byte sleutel die Laravel genereert bij installatie. <strong>Bewaar deze goed</strong> — zonder die sleutel kun je je eigen data niet meer lezen.
                            </p>
                            <div class="bb-code-block">
                                <div class="bb-code-bar">
                                    <div class="bb-dot" style="background:#FF6058;"></div>
                                    <div class="bb-dot" style="background:#FFBD2E;"></div>
                                    <div class="bb-dot" style="background:#27C93F;"></div>
                                    <span style="margin-left:auto;font-size:0.6875rem;color:rgba(255,255,255,0.3);font-family:monospace;">.env</span>
                                </div>
                                <pre><span class="tok-k">APP_KEY</span>=<span class="tok-s">base64:jouw-unieke-sleutel-hier...</span>

<span class="tok-c"># Nieuwe sleutel genereren (bij eerste installatie):</span>
<span class="tok-fn">php</span> artisan key:generate</pre>
                            </div>
                        </div>

                        {{-- Samenvatting --}}
                        <div style="background:#EEF5FF;border-radius:1rem;padding:1.25rem;">
                            <div style="font-size:0.875rem;font-weight:800;color:#1565C0;margin-bottom:0.75rem;">📋 Samenvatting beveiliging</div>
                            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                @foreach([
                                    ['✅', 'IBAN is versleuteld opgeslagen — niet leesbaar in de database'],
                                    ['✅', 'Versleuteling gebeurt automatisch via Laravel\'s encrypted cast'],
                                    ['✅', 'Ontsleuteling ook automatisch — jij werkt altijd met klare tekst in de code'],
                                    ['✅', 'Elke installatie heeft een unieke APP_KEY (AES-256-CBC encryptie)'],
                                    ['⚠️', 'Verlies je APP_KEY? Dan kun je versleutelde data niet meer lezen'],
                                    ['⚠️', 'Maak regelmatig een backup van je .env-bestand op een veilige plek'],
                                ] as [$icon, $text])
                                <div style="display:flex;gap:0.625rem;align-items:flex-start;">
                                    <span style="font-size:0.9375rem;flex-shrink:0;">{{ $icon }}</span>
                                    <span style="font-size:0.8125rem;color:#0B1F3A;line-height:1.5;">{{ $text }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Backup als datasource --}}
                <div id="backup-datasource" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🗂️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Backup als datasource voor development</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        De backup-functie (bereikbaar via het gebruikersmenu → <strong>Backup</strong>) exporteert al je data als een gestructureerd JSON-bestand. Voor vibe-developers is dat een goudmijn: je ziet precies hoe de datastructuur eruitziet, kun je lokaal testen met echte data en een nieuwe installatie snel vullen.
                    </p>

                    <div style="background:#0D1B2E;border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;font-family:monospace;font-size:0.8125rem;line-height:1.7;overflow-x:auto;">
                        <div style="color:#95E88A;margin-bottom:0.5rem;">// bankbird-backup-2026-05-05.json</div>
                        <div style="color:#7EC8E3;">{</div>
                        <div style="color:#7EC8E3;padding-left:1.5rem;">"version": 1,</div>
                        <div style="color:#7EC8E3;padding-left:1.5rem;">"created_at": "2026-05-05T...",</div>
                        <div style="color:#FFD580;padding-left:1.5rem;">"accounts":      [ ... ]  <span style="color:#6B7A99;">// IBAN, naam, type</span></div>
                        <div style="color:#FFD580;padding-left:1.5rem;">"categories":    [ ... ]  <span style="color:#6B7A99;">// hiërarchisch, met children[]</span></div>
                        <div style="color:#FFD580;padding-left:1.5rem;">"merchants":     [ ... ]  <span style="color:#6B7A99;">// inclusief match_patterns[]</span></div>
                        <div style="color:#FFD580;padding-left:1.5rem;">"transactions":  [ ... ]  <span style="color:#6B7A99;">// alle velden, refs op ID</span></div>
                        <div style="color:#7EC8E3;">}</div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
                        @foreach([
                            ['🧪', 'Lokaal testen', 'Download je backup en gebruik hem als testdata bij het bouwen van een nieuwe parser of feature. Geen nep-data nodig.'],
                            ['🚀', 'Nieuwe installatie vullen', 'Zet BankBird op een nieuwe server? Importeer je backup en al je categorieën, merchants en transacties staan er meteen in.'],
                            ['🔍', 'Datastructuur inspecteren', 'Open de JSON in VS Code of een JSON-viewer en zie exact welke velden elke entiteit heeft — handig als referentie bij het schrijven van code.'],
                            ['📤', 'Eigen exports bouwen', 'Gebruik de backup als basis om je eigen export-scripts te schrijven. Alle data staat erin, in een voorspelbaar formaat.'],
                        ] as [$icon, $title, $desc])
                        <div style="background:#F5F0FF;border-radius:1rem;padding:1.125rem;">
                            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
                                <span style="font-size:1rem;">{{ $icon }}</span>
                                <span style="font-size:0.875rem;font-weight:700;color:#3B0764;">{{ $title }}</span>
                            </div>
                            <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="bb-alert" style="background:#F5F0FF;border:1px solid rgba(124,58,237,0.2);border-radius:0.875rem;display:flex;gap:0.75rem;padding:0.875rem 1rem;align-items:flex-start;">
                        <span style="font-size:1.25rem;flex-shrink:0;">⚠️</span>
                        <div style="font-size:0.875rem;color:#5B21B6;line-height:1.6;">
                            <strong>Let op:</strong> het backup-bestand bevat gevoelige data (rekeningnummers, transacties). Behandel het bestand als privé en sla het niet op in een publieke map of Git-repository.
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="reveal">
                    <div style="background:linear-gradient(135deg,#3A0CA3,#560BAD,#7C3AED);border-radius:2rem;padding:2.5rem 2rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:-30px;right:150px;width:200px;height:200px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>
                        <div style="position:relative;z-index:1;">
                            <h3 style="font-size:1.375rem;font-weight:900;color:white;margin:0 0 0.5rem;letter-spacing:-0.02em;">Klaar om te bouwen?</h3>
                            <p style="font-size:0.9375rem;color:rgba(255,255,255,0.75);margin:0 0 1.25rem;line-height:1.6;">Bekijk de technische documentatie voor de architectuur en service-interfaces, of open een issue op GitHub als je vastloopt.</p>
                            <div class="bb-flex-center" style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                                <a href="{{ url('/docs') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#5B21B6;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.65rem 1.375rem;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,0.2);transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                                    📚 Documentatie →
                                </a>
                                <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:600;font-size:0.9375rem;padding:0.625rem 1.375rem;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                                    GitHub ↗
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


@endsection
