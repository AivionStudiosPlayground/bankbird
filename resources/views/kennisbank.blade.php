@extends('layouts.public')

@section('title', 'Kennisbank — BankBird')
@section('description', 'Alles over hoe BankBird werkt. Van importeren tot categoriseren, merchants toevoegen, AI gebruiken en rapporten begrijpen.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#003D2B,#00695C,#00897B);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;right:-60px;width:420px;height:420px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">📖 Kennisbank</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Hoe werkt<br>BankBird?
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0;max-width:520px;line-height:1.65;">
                    Van je eerste import tot AI-categorisatie en merchants met logo's — hier vind je antwoorden op alle vragen over hoe het systeem in elkaar zit en hoe je er het meeste uithaal.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4.5s ease-in-out infinite;" class="hidden-mobile">
                <div style="font-size:7rem;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.3));">📖</div>
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
        <div style="display:grid;grid-template-columns:220px 1fr;gap:2.5rem;align-items:start;">

            {{-- Sidebar TOC --}}
            <div style="position:sticky;top:84px;" class="hidden-mobile">
                <div class="bb-card-flat" style="padding:1.25rem;">
                    <div style="font-size:0.75rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#6B7A99;margin-bottom:1rem;">Inhoud</div>
                    <nav style="display:flex;flex-direction:column;gap:0.125rem;">
                        @foreach([
                            ['#hoe-werkt-het', '🐦 Hoe werkt het?'],
                            ['#importeren', '📥 Importeren'],
                            ['#categorieën', '🏷️ Categorieën'],
                            ['#merchants', '🏪 Merchants'],
                            ['#ai-categorisatie', '🤖 AI categorisatie'],
                            ['#rapporten', '📊 Rapporten'],
                            ['#instellingen', '⚙️ Instellingen'],
                            ['#backup', '🗂️ Backup'],
                        ] as [$href, $label])
                        <a href="{{ $href }}" style="font-size:0.8125rem;color:#6B7A99;text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;transition:color 0.15s,background 0.15s;" onmouseover="this.style.color='#00695C';this.style.background='#E0F2F1'" onmouseout="this.style.color='#6B7A99';this.style.background='transparent'">{{ $label }}</a>
                        @endforeach
                    </nav>
                </div>

                <div class="bb-card-flat" style="padding:1.25rem;margin-top:1rem;background:#E0F2F1;border-color:rgba(0,105,92,0.15);">
                    <div style="font-size:0.75rem;font-weight:800;color:#00695C;margin-bottom:0.75rem;">🔗 Meer lezen</div>
                    <div style="display:flex;flex-direction:column;gap:0.375rem;">
                        <a href="{{ url('/docs') }}" style="font-size:0.8125rem;color:#00695C;text-decoration:none;font-weight:500;">📚 Technische docs</a>
                        <a href="{{ url('/vibe-dev') }}" style="font-size:0.8125rem;color:#00695C;text-decoration:none;font-weight:500;">🛠️ Vibe Development</a>
                        <a href="{{ url('/install') }}" style="font-size:0.8125rem;color:#00695C;text-decoration:none;font-weight:500;">🚀 Installatie</a>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;">

                {{-- Hoe werkt BankBird --}}
                <div id="hoe-werkt-het" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
                        <span style="font-size:1.375rem;">🐦</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Hoe werkt BankBird?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        BankBird is een zelf-gehoste app voor persoonlijke financiële administratie. Je uploadt je bankafschriften, het systeem herkent transacties automatisch, en AI (optioneel) categoriseert alles voor je. Jouw data blijft op jouw eigen server.
                    </p>

                    {{-- Flow diagram --}}
                    <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
                        @foreach([
                            ['📄', 'Bankafschrift uploaden'],
                            ['→', null],
                            ['🔍', 'Transacties herkennen'],
                            ['→', null],
                            ['🏪', 'Merchant matchen'],
                            ['→', null],
                            ['🤖', 'AI categoriseert'],
                            ['→', null],
                            ['📊', 'Rapport bekijken'],
                        ] as [$icon, $label])
                            @if($label === null)
                                <span style="color:#6B7A99;font-size:1.25rem;">{{ $icon }}</span>
                            @else
                                <div style="background:#E0F2F1;border-radius:0.75rem;padding:0.5rem 0.875rem;display:flex;align-items:center;gap:0.375rem;">
                                    <span style="font-size:0.875rem;">{{ $icon }}</span>
                                    <span style="font-size:0.75rem;font-weight:700;color:#00695C;">{{ $label }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="bb-alert bb-alert-blue">
                        <span style="font-size:1.25rem;flex-shrink:0;">💡</span>
                        <div style="font-size:0.875rem;line-height:1.6;"><strong>AI is optioneel.</strong> BankBird werkt ook zonder AI-koppeling. Je kunt dan handmatig categoriseren of merchants instellen die automatisch worden herkend op basis van de transactieomschrijving.</div>
                    </div>
                </div>

                {{-- Importeren --}}
                <div id="importeren" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">📥</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Bankafschriften importeren</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Ga in het admin panel naar <strong>Financiën → Imports → Nieuw</strong>. Je kiest een rekening, uploadt je bestand en BankBird verwerkt de rest.
                    </p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div style="background:#E0F2F1;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#004D40;margin-bottom:0.75rem;font-size:0.9375rem;">✅ Ondersteunde formaten</div>
                            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                @foreach([
                                    ['🏦', 'ING PDF', 'Bankafschrift als PDF'],
                                    ['🏦', 'ING CSV', 'Export via Mijn ING'],
                                    ['🏦', 'SNS PDF', 'Transactie-historie als PDF'],
                                    ['🏦', 'Knab PDF', 'Rekeningafschrift als PDF'],
                                    ['🏦', 'Rabobank', 'Binnenkort'],
                                    ['🏦', 'ABN AMRO', 'Binnenkort'],
                                ] as [$icon, $bank, $note])
                                <div style="display:flex;align-items:center;gap:0.625rem;">
                                    <span style="font-size:0.875rem;">{{ $icon }}</span>
                                    <span style="font-size:0.8125rem;color:#0B1F3A;font-weight:600;">{{ $bank }}</span>
                                    <span style="font-size:0.75rem;color:#6B7A99;">{{ $note }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.75rem;font-size:0.9375rem;">🔁 Dubbele transacties</div>
                            <p style="font-size:0.8125rem;color:#6B7A99;line-height:1.6;margin:0;">
                                BankBird detecteert dubbele imports automatisch op basis van datum, bedrag en omschrijving. Importeer je hetzelfde bestand twee keer, dan worden de duplicaten overgeslagen.
                            </p>
                        </div>
                    </div>

                    <div class="bb-alert bb-alert-orange">
                        <span style="font-size:1.25rem;flex-shrink:0;">⚠️</span>
                        <div style="font-size:0.875rem;line-height:1.6;"><strong>Tip voor PDF-imports:</strong> zorg dat de PDF niet beveiligd is met een wachtwoord. Sommige bank-apps leveren beveiligde PDFs; bij ING kun je de CSV-export als alternatief gebruiken.</div>
                    </div>
                </div>

                {{-- Categorieën --}}
                <div id="categorieën" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🏷️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Categorieën</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Categorieën geven structuur aan je uitgaven. BankBird ondersteunt hiërarchische categorieën — een hoofdcategorie met subcategorieën.
                    </p>

                    <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;">
                        <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;font-size:0.875rem;">🌳 Voorbeeld hiërarchie</div>
                        <div style="display:flex;flex-direction:column;gap:0.375rem;font-family:monospace;font-size:0.8125rem;color:#0B1F3A;">
                            <div>🛒 <strong>Boodschappen</strong></div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Albert Heijn</div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Jumbo</div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Online boodschappen</div>
                            <div style="margin-top:0.375rem;">🚗 <strong>Vervoer</strong></div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Brandstof</div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ OV / Trein</div>
                            <div style="margin-top:0.375rem;">🏠 <strong>Wonen</strong></div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Huur / Hypotheek</div>
                            <div style="padding-left:1.5rem;color:#6B7A99;">└─ Energie</div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">➕ Categorie toevoegen</div>
                            <ol style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach(['Ga naar Beheer → Categorieën', 'Klik op "Nieuw"', 'Geef een naam en kleur', 'Kies optioneel een bovenliggende categorie', 'Opslaan'] as $step)
                                <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $step }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">🤖 Laat AI categoriseren</div>
                            <p style="font-size:0.8125rem;color:#6B7A99;line-height:1.6;margin:0;">
                                Na een import kun je ongecategoriseerde transacties selecteren en via de bulk-actie "AI categoriseren" automatisch laten toewijzen. AI gebruikt jouw bestaande categorieën als keuzelijst.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Merchants --}}
                <div id="merchants" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🏪</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Merchants — wat zijn dat?</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Een merchant is een winkel, leverancier of dienst die je terugziet in je transacties. Door merchants in te stellen, herkent BankBird ze automatisch en wijst de juiste categorie toe — zonder dat AI nodig is.
                    </p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">

                        <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;font-size:0.9375rem;">📌 Voorbeeld</div>
                            <div style="background:white;border-radius:0.75rem;padding:1rem;font-size:0.8125rem;border:1px solid #DDEAF3;">
                                <div style="color:#6B7A99;margin-bottom:0.375rem;">Transactieomschrijving:</div>
                                <div style="font-family:monospace;background:#0D1B2E;color:#95E88A;padding:0.5rem 0.75rem;border-radius:0.5rem;margin-bottom:0.75rem;font-size:0.75rem;">BEA NR:012345 <strong>ALBERT HEIJN</strong> 1234</div>
                                <div style="color:#6B7A99;margin-bottom:0.375rem;">Merchant patroon (regex):</div>
                                <div style="font-family:monospace;background:#0D1B2E;color:#7EC8E3;padding:0.5rem 0.75rem;border-radius:0.5rem;font-size:0.75rem;">ALBERT HEIJN</div>
                                <div style="margin-top:0.75rem;display:flex;align-items:center;gap:0.375rem;">
                                    <span style="color:#16C784;">✓</span>
                                    <span style="color:#0B1F3A;font-size:0.75rem;font-weight:600;">Categorie: Boodschappen → AH</span>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex;flex-direction:column;gap:0.875rem;">
                            <div>
                                <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.5rem;">✋ Handmatig toevoegen</div>
                                <ol style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.25rem;">
                                    @foreach(['Ga naar Beheer → Merchants', 'Klik op "Nieuw"', 'Naam invullen (bijv. "Albert Heijn")', 'Patroon invullen (zoekterm in omschrijving)', 'Categorie koppelen', 'Opslaan'] as $step)
                                    <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $step }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>

                    </div>

                    {{-- Logo toevoegen --}}
                    <div style="border:1px dashed rgba(30,136,229,0.25);border-radius:1rem;padding:1.25rem;background:white;">
                        <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.875rem;">
                            <span style="font-size:1.125rem;">🖼️</span>
                            <div style="font-size:0.9375rem;font-weight:800;color:#0B1F3A;">Logo toevoegen aan een merchant</div>
                        </div>
                        <p style="font-size:0.875rem;color:#6B7A99;line-height:1.6;margin:0 0 1rem;">
                            Bij elke merchant kun je een logo uploaden. Dat logo verschijnt bij transacties in het overzicht, waardoor je in één oogopslag ziet waar het geld naartoe ging.
                        </p>
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                '📁 Ga naar Beheer → Merchants en open een merchant',
                                '🖼️ Klik op het logo-upload veld',
                                '📐 Aanbevolen formaat: vierkant PNG of SVG, minimaal 64×64 px',
                                '💾 Sla op — het logo verschijnt direct in je transactieoverzichten',
                            ] as $step)
                            <div style="font-size:0.8125rem;color:#0B1F3A;line-height:1.5;">{{ $step }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- AI categorisatie --}}
                <div id="ai-categorisatie" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🤖</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">AI categorisatie — met of zonder?</h2>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div style="background:#E0F2F1;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#004D40;margin-bottom:0.75rem;">✅ Zonder AI</div>
                            <ul style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach(['Volledig gratis', 'Werkt offline', 'Geen API-sleutel nodig', 'Merchants herkennen transacties via regex', 'Handmatig categoriseren'] as $item)
                                <li style="font-size:0.8125rem;color:#0B1F3A;line-height:1.5;">{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div style="background:#EEF5FF;border-radius:1rem;padding:1.25rem;">
                            <div style="font-weight:800;color:#1565C0;margin-bottom:0.75rem;">🚀 Met AI</div>
                            <ul style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach(['Bulk categorisatie in één klik', 'Leert van jouw feedback', 'Ondersteunt Claude (Anthropic) en GPT (OpenAI)', 'Kleine kosten per API-aanroep', 'Bespaart veel handmatig werk'] as $item)
                                <li style="font-size:0.8125rem;color:#0B1F3A;line-height:1.5;">{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;">
                        <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;font-size:0.875rem;">⚙️ AI instellen</div>
                        <ol style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach([
                                'Ga naar je profiel (rechtsboven in het admin panel)',
                                'Kies je AI-provider: Claude (Anthropic) of ChatGPT (OpenAI)',
                                'Voer je API-sleutel in — die haal je op bij de website van je provider',
                                'Selecteer na een import ongecategoriseerde transacties',
                                'Gebruik de bulk-actie "AI categoriseren"',
                            ] as $i => $step)
                            <li style="font-size:0.875rem;color:#0B1F3A;line-height:1.6;">{{ $step }}</li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="bb-alert bb-alert-green">
                        <span style="font-size:1.25rem;flex-shrink:0;">💡</span>
                        <div style="font-size:0.875rem;line-height:1.6;"><strong>Tip:</strong> gebruik AI voor de eerste grote batch ongecategoriseerde transacties. Daarna werken merchants je maandelijkse nieuwe transacties automatisch bij — zonder AI-kosten.</div>
                    </div>
                </div>

                {{-- Rapporten --}}
                <div id="rapporten" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">📊</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Rapporten & overzichten</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        BankBird heeft drie rapportpagina's, te vinden onder <strong>Rapporten</strong> in het admin panel.
                    </p>

                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        @foreach([
                            ['📅', 'Maandrapport', '#EEF5FF', '#1565C0', 'Kies een maand en zie al je inkomsten en uitgaven uitgesplitst per categorie, met percentages en vergelijking met vorige maand.'],
                            ['📈', 'Jaaroverzicht', '#E0F2F1', '#004D40', 'Per maand je inkomsten, uitgaven en netto saldo naast elkaar. Ideaal om te zien in welke maand je meer uitgeeft.'],
                            ['🔍', 'Categorie drilldown', '#F5F0FF', '#5B21B6', 'Klik op een categorie in het maandrapport voor een volledig transactieoverzicht binnen die categorie en periode.'],
                        ] as [$icon, $title, $bg, $color, $desc])
                        <div style="background:{{ $bg }};border-radius:1rem;padding:1.25rem;display:flex;gap:1rem;align-items:flex-start;">
                            <div style="font-size:1.5rem;flex-shrink:0;">{{ $icon }}</div>
                            <div>
                                <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.375rem;font-size:0.9375rem;">{{ $title }}</div>
                                <div style="font-size:0.875rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Instellingen --}}
                <div id="instellingen" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">⚙️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Instellingen</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Bereikbaar via het gebruikersmenu rechtsboven → <strong>Instellingen</strong>.
                    </p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        @foreach([
                            ['🖼️', 'Logo & favicon', 'Upload je eigen logo en favicon. Het logo verschijnt linksboven in het admin panel; de hoogte is instelbaar.'],
                            ['👤', 'Profiel', 'Verander je naam, e-mailadres of wachtwoord. Hier stel je ook je AI-provider en API-sleutel in.'],
                            ['🔐', '2FA', 'Tweefactorauthenticatie is ingebouwd. Activeer via je profiel met een authenticator-app (Google Auth, 1Password, etc.).'],
                            ['🏦', 'Rekeningen', 'Beheer je bankrekeningen onder Financiën → Rekeningen. Voeg IBAN, naam en kleur toe.'],
                        ] as [$icon, $title, $desc])
                        <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;">
                            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.625rem;">
                                <span style="font-size:1.125rem;">{{ $icon }}</span>
                                <div style="font-weight:800;color:#0B1F3A;font-size:0.9375rem;">{{ $title }}</div>
                            </div>
                            <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.6;">{{ $desc }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Backup --}}
                <div id="backup" class="bb-card-flat reveal" style="padding:2rem;">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                        <span style="font-size:1.375rem;">🗂️</span>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Backup — je data veilig stellen</h2>
                    </div>
                    <p style="font-size:0.9375rem;color:#6B7A99;line-height:1.7;margin:0 0 1.5rem;">
                        Vanuit het gebruikersmenu rechtsboven (klik op je naam of avatar) vind je de pagina <strong>Backup</strong>. Hier kun je met één klik een volledige kopie van al je BankBird-gegevens downloaden naar je eigen computer.
                    </p>

                    {{-- Wat zit erin --}}
                    <div style="background:#F0F6FF;border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;">
                        <div style="font-weight:800;color:#0B1F3A;margin-bottom:0.875rem;font-size:0.875rem;">📦 Wat zit er in de backup?</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                            @foreach([
                                ['🏦', 'Rekeningen', 'Naam, type en IBAN van al je bankrekeningen'],
                                ['💸', 'Transacties', 'Alle transacties inclusief bedrag, datum en categorie'],
                                ['🏷️', 'Categorieën', 'Volledige hiërarchie met kleuren en iconen'],
                                ['🏪', 'Merchants', 'Naam, logo-URL, patronen en gekoppelde categorie'],
                            ] as [$icon, $title, $desc])
                            <div style="background:white;border-radius:0.75rem;padding:0.875rem;border:1px solid #DDEAF3;">
                                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.375rem;">
                                    <span style="font-size:1rem;">{{ $icon }}</span>
                                    <span style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{{ $title }}</span>
                                </div>
                                <div style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $desc }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">💾 Backup maken</div>
                            <ol style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach([
                                    'Klik rechtsboven op je naam of avatar',
                                    'Kies "Backup" in het menu',
                                    'Klik op "Backup downloaden"',
                                    'Het bestand wordt opgeslagen in je Downloads-map',
                                ] as $step)
                                <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $step }}</li>
                                @endforeach
                            </ol>
                        </div>
                        <div>
                            <div style="font-size:0.875rem;font-weight:800;color:#0B1F3A;margin-bottom:0.625rem;">🔄 Backup terugzetten</div>
                            <ol style="margin:0;padding:0 0 0 1.25rem;display:flex;flex-direction:column;gap:0.375rem;">
                                @foreach([
                                    'Ga naar Backup via het gebruikersmenu',
                                    'Selecteer je back-upbestand',
                                    'Klik op "Terugzetten" en bevestig',
                                    'Bestaande gegevens worden niet overschreven',
                                ] as $step)
                                <li style="font-size:0.8125rem;color:#6B7A99;line-height:1.5;">{{ $step }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <div class="bb-alert bb-alert-green">
                        <span style="font-size:1.25rem;flex-shrink:0;">💡</span>
                        <div style="font-size:0.875rem;line-height:1.6;">
                            <strong>Tip:</strong> maak een backup voordat je grote wijzigingen doorvoert, zoals het samenvoegen van categorieën of het verwijderen van merchants. De backup wordt lokaal op je computer opgeslagen — niet in de cloud.
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="reveal">
                    <div style="background:linear-gradient(135deg,#003D2B,#00695C,#00897B);border-radius:2rem;padding:2.5rem 2rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:-30px;right:150px;width:200px;height:200px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>
                        <div style="position:relative;z-index:1;">
                            <h3 style="font-size:1.375rem;font-weight:900;color:white;margin:0 0 0.5rem;letter-spacing:-0.02em;">Nog vragen?</h3>
                            <p style="font-size:0.9375rem;color:rgba(255,255,255,0.75);margin:0 0 1.25rem;line-height:1.6;">Bekijk de technische documentatie of wil je zelf iets bouwen? Lees de Vibe Development gids.</p>
                            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                                <a href="{{ url('/docs') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#004D40;border-radius:0.875rem;font-weight:700;font-size:0.9375rem;padding:0.65rem 1.375rem;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,0.2);transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                                    📚 Technische docs →
                                </a>
                                <a href="{{ url('/vibe-dev') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.12);color:white;border:2px solid rgba(255,255,255,0.3);border-radius:0.875rem;font-weight:600;font-size:0.9375rem;padding:0.625rem 1.375rem;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                                    🛠️ Vibe Development →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 860px) {
    .hidden-mobile { display: none !important; }
    [style*="grid-template-columns:220px"] { grid-template-columns: 1fr !important; }
    [style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection
