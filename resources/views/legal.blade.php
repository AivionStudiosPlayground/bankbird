@extends('layouts.public')

@section('title', 'Voorwaarden & Privacy — BankBird')
@section('description', 'Algemene voorwaarden, privacyverklaring en disclaimer voor BankBird, een product van Avion Studios.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:30%;right:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">⚖️ Juridisch</div>
        <h1 style="font-size:clamp(2rem,4vw,2.75rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
            Voorwaarden & Privacy
        </h1>
        <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0 0 1.5rem;max-width:580px;line-height:1.65;">
            BankBird is open-source software, aangeboden door <strong>Avion Studios</strong>. Lees hieronder wat dit betekent voor jou als gebruiker.
        </p>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <span style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.85);font-size:0.8125rem;font-weight:600;padding:0.3rem 0.875rem;border-radius:99px;">Laatste update: mei 2026</span>
            <span style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.85);font-size:0.8125rem;font-weight:600;padding:0.3rem 0.875rem;border-radius:99px;">AGPL-3.0 Licentie</span>
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
        <div class="bb-grid-2" style="grid-template-columns:200px 1fr;gap:2.5rem;align-items:start;">

            {{-- Sticky nav --}}
            <div style="position:sticky;top:84px;" class="hidden-mobile">
                <div class="bb-card-flat" style="padding:1.25rem;">
                    <div style="font-size:0.75rem;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#6B7A99;margin-bottom:1rem;">Inhoud</div>
                    <nav style="display:flex;flex-direction:column;gap:0.125rem;">
                        @foreach([
                            ['#over', '🐦 Over BankBird'],
                            ['#scope', '📁 Scope & administratie'],
                            ['#voorwaarden', '📋 Algemene voorwaarden'],
                            ['#aansprakelijkheid', '⚠️ Aansprakelijkheid'],
                            ['#gegevens', '🗄️ Gegevensopslag & AVG'],
                            ['#beveiliging', '🔒 Beveiliging & meldingen'],
                            ['#privacy', '🛡️ Privacy'],
                            ['#licentie', '📄 Licentie'],
                            ['#contact', '✉️ Contact'],
                        ] as [$href, $label])
                        <a href="{{ $href }}" style="font-size:0.8125rem;color:#6B7A99;text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;transition:color 0.15s,background 0.15s;" onmouseover="this.style.color='#1E88E5';this.style.background='#EEF5FF'" onmouseout="this.style.color='#6B7A99';this.style.background='transparent'">{{ $label }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>

            {{-- Content --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem;max-width:720px;min-width:0;">

                {{-- Samenvatting --}}
                <div class="bb-alert bb-alert-blue reveal" style="padding:1.25rem 1.5rem;">
                    <span style="font-size:1.375rem;flex-shrink:0;">💡</span>
                    <div>
                        <strong style="display:block;margin-bottom:0.375rem;">Kort samengevat</strong>
                        BankBird is gratis, open-source software. Jij installeert het op jouw eigen server en bent zelf verantwoordelijk voor je installatie, data en beveiliging. Avion Studios biedt de software aan zoals hij is, zonder garanties. Bij bekende beveiligingsproblemen kijken we ernaar en lossen we het op waar mogelijk.
                    </div>
                </div>

                {{-- 1. Over BankBird --}}
                <div id="over" class="bb-card-flat reveal" style="padding:2rem;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>🐦</span> Over BankBird
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">BankBird is een open-source applicatie voor persoonlijk financieel beheer, ontwikkeld door <strong>Avion Studios</strong>. De software is vrij beschikbaar onder de AGPL-3.0 licentie en wordt aangeboden als <em>self-hosted</em> oplossing: jij draait de software op jouw eigen server of computer.</p>
                        <p style="margin:0;">Avion Studios is geen bank, financieel adviseur of gecertificeerde financiële instelling. BankBird is een hulpmiddel voor persoonlijk gebruik en vervangt geen professioneel financieel advies.</p>
                    </div>
                </div>

                {{-- 1b. Scope & administratie --}}
                <div id="scope" class="bb-card-flat reveal" style="padding:2rem;border-left:4px solid #1E88E5;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>📁</span> Scope & administratie
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">BankBird is in de huidige versie ontworpen voor <strong>één financiële administratie per installatie</strong>. Dit betekent:</p>
                        <div style="display:flex;flex-direction:column;gap:0.625rem;">
                            @foreach([
                                ['👤', 'Één huishouden of persoon', 'Een BankBird-installatie beheert de financiën van één persoon of huishouden. Meerdere gebruikersaccounts zijn mogelijk (bijv. partner), maar zij delen dezelfde administratie.'],
                                ['🏦', 'Meerdere bankrekeningen', 'Binnen die ene administratie kun je wel meerdere bankrekeningen importeren en beheren.'],
                                ['🔮', 'Meerdere administraties in de toekomst', 'Op de roadmap staat ondersteuning voor meerdere losstaande administraties binnen één installatie — handig voor ZZP\'ers of meerdere huishoudens. Dit is nog niet beschikbaar.'],
                            ] as [$icon, $title, $desc])
                            <div style="display:flex;gap:1rem;align-items:flex-start;background:#EEF5FF;border-radius:0.875rem;padding:1rem 1.25rem;">
                                <span style="font-size:1.25rem;flex-shrink:0;">{{ $icon }}</span>
                                <div>
                                    <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $title }}</div>
                                    <div style="font-size:0.875rem;color:#6B7A99;line-height:1.65;">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 2. Algemene voorwaarden --}}
                <div id="voorwaarden" class="bb-card-flat reveal" style="padding:2rem;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>📋</span> Algemene voorwaarden
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">Door BankBird te installeren en te gebruiken ga je akkoord met de volgende voorwaarden:</p>
                        <div style="display:flex;flex-direction:column;gap:0.75rem;">
                            @foreach([
                                ['Eigen verantwoordelijkheid', 'Jij bent als gebruiker volledig verantwoordelijk voor de installatie, het gebruik, het beheer en de beveiliging van jouw BankBird-instantie. Dit omvat het beveiligen van je server, het beheren van toegangsrechten en het regelmatig maken van back-ups van je data.'],
                                ['Eigen risico', 'Het gebruik van BankBird geschiedt volledig op eigen risico. De software wordt aangeboden "as-is" (zoals hij is), zonder enige uitdrukkelijke of impliciete garantie over geschiktheid, betrouwbaarheid of beschikbaarheid.'],
                                ['Geen financieel advies', 'De informatie en overzichten die BankBird genereert zijn uitsluitend bedoeld als persoonlijk hulpmiddel. Ze vormen geen financieel, fiscaal of juridisch advies. Avion Studios is niet verantwoordelijk voor beslissingen die je maakt op basis van de output van de software.'],
                                ['Juistheid van data', 'BankBird verwerkt de bankafschriften die jij uploadt. Avion Studios geeft geen garantie over de correctheid van de verwerking en is niet verantwoordelijk voor fouten in de interpretatie van je financiële gegevens.'],
                                ['Wijzigingen', 'Avion Studios behoudt het recht de software, documentatie en deze voorwaarden op elk moment te wijzigen. Wijzigingen worden gepubliceerd via de GitHub repository en/of deze website.'],
                            ] as [$title, $text])
                            <div style="background:#F7FBFF;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #1E88E5;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">{{ $title }}</div>
                                <div style="font-size:0.875rem;color:#6B7A99;line-height:1.7;">{{ $text }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- 3. Aansprakelijkheid --}}
                <div id="aansprakelijkheid" class="bb-card-flat reveal" style="padding:2rem;border-left:4px solid #FF8A3D;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>⚠️</span> Beperking van aansprakelijkheid
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">Avion Studios aanvaardt <strong>geen aansprakelijkheid</strong> voor schade die voortvloeit uit het gebruik van BankBird, waaronder maar niet beperkt tot:</p>
                        <div class="bb-grid-2" style="gap:0.625rem;">
                            @foreach([
                                '📂 Verlies of beschadiging van financiële gegevens',
                                '🔓 Ongeautoriseerde toegang tot jouw installatie',
                                '💸 Financiële schade op basis van onjuiste data-interpretatie',
                                '🖥️ Uitval, storingen of fouten in de software',
                                '🔒 Datalekken als gevolg van een onbeveiligde serveromgeving',
                                '🔗 Schade door koppelingen met externe AI-diensten',
                            ] as $item)
                            <div style="display:flex;align-items:flex-start;gap:0.5rem;background:#FFF8F0;border-radius:0.625rem;padding:0.75rem;">
                                <span style="font-size:0.875rem;flex-shrink:0;">{{ explode(' ', $item)[0] }}</span>
                                <span style="font-size:0.8125rem;color:#4A5568;line-height:1.5;">{{ implode(' ', array_slice(explode(' ', $item), 1)) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="bb-alert bb-alert-orange" style="margin-top:0.25rem;">
                            <span style="font-size:1.125rem;flex-shrink:0;">⚠️</span>
                            <div style="font-size:0.875rem;">
                                <strong>Jij bent eindverantwoordelijk.</strong> Als self-hosted software draait BankBird op jouw infrastructuur. De beveiliging van je server, database, netwerk en toegangsgegevens is volledig jouw verantwoordelijkheid.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3b. Gegevensopslag & AVG --}}
                <div id="gegevens" class="bb-card-flat reveal" style="padding:2rem;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 0.375rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>🗄️</span> Gegevensopslag & AVG
                    </h2>
                    <p style="font-size:0.875rem;color:#6B7A99;margin:0 0 1.5rem;">Wat BankBird opslaat, waar het staat en hoe zich dat verhoudt tot de AVG.</p>

                    {{-- Wat wordt opgeslagen --}}
                    <div style="margin-bottom:1.5rem;">
                        <div style="font-size:0.8125rem;font-weight:800;text-transform:uppercase;letter-spacing:0.07em;color:#6B7A99;margin-bottom:0.875rem;">Wat staat er in de database?</div>
                        <div class="bb-table-wrap" style="border:1px solid #DDEAF3;border-radius:0.875rem;overflow:hidden;">
                        <div style="min-width:480px;">
                            <div style="display:grid;grid-template-columns:1.5fr 2fr 1fr;background:#F7FBFF;padding:0.5rem 1rem;border-bottom:1px solid #DDEAF3;">
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Gegeven</span>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Wat het is</span>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Gevoelig?</span>
                            </div>
                            @foreach([
                                ['Transacties', 'Datum, bedrag, omschrijving, categorie, rekening', 'Ja — financieel', '#FFF8F0', '#FF8A3D'],
                                ['Gebruikersaccounts', 'Naam, e-mailadres, gehashed wachtwoord, 2FA-sleutel', 'Ja — persoonlijk', '#FFF8F0', '#FF8A3D'],
                                ['Categorieën', 'Namen en hiërarchie van jouw categorieën', 'Nee', '#F0FFF8', '#16C784'],
                                ['Merchants', 'Winkelnamen en herkenningspatronen', 'Beperkt', '#FFF8F0', '#FF8A3D'],
                                ['Importbatches', 'Bestandsnaam, datum, aantal transacties, of AI is gebruikt', 'Beperkt', '#FFF8F0', '#FF8A3D'],
                                ['AI-logs', 'Transactieomschrijvingen die naar AI zijn gestuurd + respons', 'Ja — financieel', '#FFF8F0', '#FF8A3D'],
                                ['Sessies', 'Inlogsessies en tokens (standaard Laravel)', 'Ja — technisch', '#FFF8F0', '#FF8A3D'],
                            ] as [$name, $desc, $level, $bg, $color])
                            <div style="display:grid;grid-template-columns:1.5fr 2fr 1fr;padding:0.625rem 1rem;border-bottom:1px solid #E5EEF7;align-items:center;" onmouseover="this.style.background='#F7FBFF'" onmouseout="this.style.background='transparent'">
                                <span style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{{ $name }}</span>
                                <span style="font-size:0.8125rem;color:#6B7A99;">{{ $desc }}</span>
                                <span style="font-size:0.75rem;background:{{ $bg }};color:{{ $color }};padding:0.2rem 0.625rem;border-radius:99px;font-weight:700;display:inline-block;text-align:center;">{{ $level }}</span>
                            </div>
                            @endforeach
                        </div>
                        </div>{{-- /bb-table-wrap inner --}}
                        <p style="font-size:0.8125rem;color:#6B7A99;margin:0.75rem 0 0;">Alle data staat uitsluitend in de database op <strong>jouw eigen server</strong>. Avion Studios heeft hier geen toegang toe.</p>
                    </div>

                    {{-- Waar staat het --}}
                    <div style="margin-bottom:1.5rem;">
                        <div style="font-size:0.8125rem;font-weight:800;text-transform:uppercase;letter-spacing:0.07em;color:#6B7A99;margin-bottom:0.875rem;">Waar staat de data?</div>
                        <div class="bb-grid-2" style="gap:0.75rem;">
                            <div style="background:#F0FFF8;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #16C784;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">✅ Op jouw server</div>
                                <p style="font-size:0.8125rem;color:#6B7A99;margin:0;line-height:1.65;">De database (MySQL of SQLite) draait op de server die jij beheert. Jij bepaalt waar die staat: lokaal, een VPS of een eigen cloud.</p>
                            </div>
                            <div style="background:#FFF8F0;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #FF8A3D;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">⚠️ Bij AI-gebruik: extern</div>
                                <p style="font-size:0.8125rem;color:#6B7A99;margin:0;line-height:1.65;">Als je AI-categorisatie inschakelt, worden transactieomschrijvingen (geen bedragen of namen) naar Anthropic of OpenAI gestuurd. Dit is optioneel en uitschakelbaar.</p>
                            </div>
                        </div>
                    </div>

                    {{-- AVG --}}
                    <div>
                        <div style="font-size:0.8125rem;font-weight:800;text-transform:uppercase;letter-spacing:0.07em;color:#6B7A99;margin-bottom:0.875rem;">Verhouding tot de AVG (GDPR)</div>
                        <div style="background:#EEF5FF;border-radius:0.875rem;padding:1.25rem;border:1px solid rgba(30,136,229,0.15);display:flex;flex-direction:column;gap:0.875rem;">
                            @foreach([
                                ['BankBird verwerkt persoonsgegevens', 'Financiële gegevens, gebruikersnamen en e-mailadressen vallen onder de AVG. Als je BankBird uitsluitend voor je eigen administratie gebruikt, val je onder de <strong>huishoudelijke uitzondering</strong> van de AVG (art. 2 lid 2c) en zijn de verplichtingen beperkt.'],
                                ['Gebruik je BankBird voor meerdere personen?', 'Dan ben jij de <strong>verwerkingsverantwoordelijke</strong> in de zin van de AVG. Jij moet zorgen voor een rechtmatige grondslag (bijv. toestemming), de data beveiligen en een verwerkersovereenkomst sluiten als je externe diensten inschakelt.'],
                                ['Avion Studios is geen verwerker', 'Omdat Avion Studios geen toegang heeft tot jouw data en deze niet verwerkt, treedt Avion Studios niet op als verwerker in de zin van de AVG. Er is dan ook geen verwerkersovereenkomst van toepassing.'],
                                ['Bewaartermijnen', 'BankBird hanteert geen automatische bewaartermijnen. Jij bent verantwoordelijk voor het bepalen hoe lang je gegevens bewaart en het verwijderen van data wanneer dat nodig is.'],
                            ] as [$title, $text])
                            <div style="display:flex;gap:0.75rem;align-items:flex-start;padding-bottom:0.875rem;border-bottom:1px solid rgba(30,136,229,0.1);" style="last-child:border:none;">
                                <span style="color:#1E88E5;font-size:1.125rem;flex-shrink:0;margin-top:0.1rem;">▸</span>
                                <div>
                                    <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $title }}</div>
                                    <div style="font-size:0.875rem;color:#6B7A99;line-height:1.65;">{!! $text !!}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="bb-alert bb-alert-blue" style="margin-top:0.875rem;">
                            <span style="font-size:1.125rem;flex-shrink:0;">💡</span>
                            <div style="font-size:0.875rem;">
                                <strong>Kort samengevat:</strong> gebruik je BankBird alleen voor jezelf of je eigen huishouden, dan hoef je je in praktijk weinig zorgen te maken over de AVG. Gebruik je het voor anderen, zorg dan voor toestemming en een goede beveiliging van je server.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Beveiliging --}}
                <div id="beveiliging" class="bb-card-flat reveal" style="padding:2rem;border-left:4px solid #16C784;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>🔒</span> Beveiligingsproblemen melden
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">Avion Studios neemt beveiliging serieus. Hoewel we geen aansprakelijkheid aanvaarden voor beveiligingsincidenten, doen we ons best om bekende kwetsbaarheden te verhelpen.</p>
                        <div style="display:flex;flex-direction:column;gap:0.625rem;">
                            @foreach([
                                ['1', '#16C784', 'Meld het verantwoord', 'Ontdek je een beveiligingsprobleem? Stuur een e-mail naar mail@avionstudios.nl of open een vertrouwelijk issue op GitHub. Publiceer de kwetsbaarheid niet openbaar voordat we de kans hebben gehad ernaar te kijken.'],
                                ['2', '#1E88E5', 'We onderzoeken het', 'Avion Studios bekijkt elke gemelde kwetsbaarheid. We streven naar een eerste reactie binnen 7 werkdagen.'],
                                ['3', '#FF8A3D', 'We lossen het op indien mogelijk', 'Als de kwetsbaarheid bevestigd wordt en in de software zelf zit, zullen we een fix uitbrengen. We kunnen echter niet garanderen dat elke kwetsbaarheid opgelost kan worden — de software wordt aangeboden zonder garantie.'],
                            ] as [$num, $color, $title, $text])
                            <div style="display:flex;gap:1rem;align-items:flex-start;">
                                <div style="width:2rem;height:2rem;background:{{ $color }};color:white;border-radius:50%;font-size:0.8125rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $num }}</div>
                                <div>
                                    <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.25rem;">{{ $title }}</div>
                                    <div style="font-size:0.875rem;color:#6B7A99;line-height:1.65;">{{ $text }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="bb-alert bb-alert-green" style="margin-top:0.25rem;">
                            <span style="font-size:1.125rem;flex-shrink:0;">✉️</span>
                            <div style="font-size:0.875rem;">
                                Beveiligingsproblemen melden: <strong><a href="mailto:mail@avionstudios.nl" style="color:inherit;">mail@avionstudios.nl</a></strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 5. Privacy --}}
                <div id="privacy" class="bb-card-flat reveal" style="padding:2rem;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>🛡️</span> Privacyverklaring
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">BankBird is gebouwd met privacy als uitgangspunt. Jouw financiële gegevens blijven op jouw eigen server.</p>
                        <div style="display:flex;flex-direction:column;gap:0.625rem;">
                            <div style="background:#F0FFF8;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #16C784;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">✅ Wat Avion Studios NIET doet</div>
                                <ul style="margin:0;padding-left:1.25rem;font-size:0.875rem;color:#6B7A99;line-height:1.9;">
                                    <li>We verzamelen geen persoonlijke of financiële gegevens van jouw installatie.</li>
                                    <li>We slaan geen bankafschriften, transacties of categorieën op onze servers op.</li>
                                    <li>We plaatsen geen tracking cookies en gebruiken geen analytics op jouw installatie.</li>
                                    <li>We verkopen of delen jouw gegevens niet met derden.</li>
                                </ul>
                            </div>
                            <div style="background:#FFF8F0;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #FF8A3D;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">⚠️ Wat je zelf regelt</div>
                                <ul style="margin:0;padding-left:1.25rem;font-size:0.875rem;color:#6B7A99;line-height:1.9;">
                                    <li>Jij bent verantwoordelijk voor de opslag en beveiliging van alle data in jouw installatie.</li>
                                    <li>Als je AI-categorisatie inschakelt, worden transactieomschrijvingen naar een externe AI-dienst (Anthropic of OpenAI) gestuurd. Lees hun privacybeleid.</li>
                                    <li>BankBird valt onder de AVG/GDPR als je het gebruikt voor gegevens van andere personen. Jij bent daarvoor de verwerkingsverantwoordelijke.</li>
                                </ul>
                            </div>
                            <div style="background:#EEF5FF;border-radius:0.875rem;padding:1rem 1.25rem;border-left:3px solid #1E88E5;">
                                <div style="font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">💡 Website (deze pagina)</div>
                                <p style="margin:0;font-size:0.875rem;color:#6B7A99;line-height:1.65;">Deze publieke website (bankbird.avionstudios.nl) gebruikt geen tracking cookies en verzamelt geen persoonlijke gegevens. Er worden geen analytics of advertentienetwerken gebruikt.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 6. Licentie --}}
                <div id="licentie" class="bb-card-flat reveal" style="padding:2rem;">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>📄</span> Licentie
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">BankBird is uitgebracht onder de <strong>GNU Affero General Public License v3.0 (AGPL-3.0)</strong>. Dit betekent kort gezegd:</p>
                        <div class="bb-grid-2" style="gap:0.625rem;">
                            @foreach([
                                ['✅', 'Gratis te gebruiken', 'Voor persoonlijk en zakelijk gebruik'],
                                ['✅', 'Broncode inzien', 'De volledige code staat op GitHub'],
                                ['✅', 'Aanpassen', 'Je mag de code wijzigen voor eigen gebruik'],
                                ['⚠️', 'Wijzigingen delen', 'Als je een aangepaste versie deelt, moet je de broncode ook delen'],
                            ] as [$icon, $title, $desc])
                            <div style="background:#F7FBFF;border-radius:0.75rem;padding:0.875rem;display:flex;gap:0.625rem;align-items:flex-start;">
                                <span style="font-size:1rem;">{{ $icon }}</span>
                                <div>
                                    <div style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{{ $title }}</div>
                                    <div style="font-size:0.8125rem;color:#6B7A99;margin-top:0.125rem;">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <p style="margin:0;font-size:0.875rem;color:#6B7A99;">De volledige licentietekst is beschikbaar in de <code style="background:#EEF5FF;padding:0.1rem 0.4rem;border-radius:0.25rem;color:#1565C0;">LICENSE</code> file in de GitHub repository.</p>
                    </div>
                </div>

                {{-- 7. Contact --}}
                <div id="contact" class="bb-card-flat reveal" style="padding:2rem;background:linear-gradient(135deg,#EEF5FF,#E3F2FD);">
                    <h2 style="font-size:1.25rem;font-weight:800;margin:0 0 1rem;color:#0B1F3A;display:flex;align-items:center;gap:0.625rem;">
                        <span>✉️</span> Contact
                    </h2>
                    <div style="font-size:0.9375rem;color:#4A5568;line-height:1.8;display:flex;flex-direction:column;gap:0.875rem;">
                        <p style="margin:0;">Heb je vragen over deze voorwaarden, wil je een beveiligingsprobleem melden of heb je andere feedback?</p>
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            <div style="display:flex;align-items:center;gap:0.875rem;background:white;border-radius:0.875rem;padding:1rem 1.25rem;border:1px solid rgba(30,136,229,0.1);">
                                <span style="font-size:1.375rem;">🏢</span>
                                <div>
                                    <div style="font-size:0.75rem;color:#6B7A99;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Aanbieder</div>
                                    <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;">Avion Studios</div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:0.875rem;background:white;border-radius:0.875rem;padding:1rem 1.25rem;border:1px solid rgba(30,136,229,0.1);">
                                <span style="font-size:1.375rem;">✉️</span>
                                <div>
                                    <div style="font-size:0.75rem;color:#6B7A99;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">E-mail</div>
                                    <a href="mailto:mail@avionstudios.nl" style="font-size:0.9375rem;font-weight:700;color:#1E88E5;text-decoration:none;">mail@avionstudios.nl</a>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:0.875rem;background:white;border-radius:0.875rem;padding:1rem 1.25rem;border:1px solid rgba(30,136,229,0.1);">
                                <span style="font-size:1.375rem;">💻</span>
                                <div>
                                    <div style="font-size:0.75rem;color:#6B7A99;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">GitHub</div>
                                    <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" style="font-size:0.9375rem;font-weight:700;color:#1E88E5;text-decoration:none;">github.com/AivionStudiosPlayground/bankbird</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


@endsection
