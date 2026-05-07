@extends('layouts.public')

@section('title', 'FAQ — BankBird')
@section('description', 'Veelgestelde vragen over BankBird: wat het is, hoe het werkt, wat open-source betekent, en wat je met de software mag doen.')

@section('content')

{{-- ══════════════════════════════════════════════ --}}
{{-- HERO                                          --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-80px;right:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.08) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">❓ Veelgestelde vragen</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Goeie vragen,<br>eerlijke antwoorden
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.85);margin:0;max-width:520px;line-height:1.65;">
                    Vragen over BankBird, open source, je data of wat je met de code mag doen — alles op één plek.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4s ease-in-out infinite;" class="hidden-mobile">
                <img src="{{ asset('images/bird.png') }}" alt="BankBird" style="height:200px;width:auto;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.25));">
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
{{-- QUICK NAV                                     --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2rem 1.5rem 0;">
    <div class="bb-wrap">
        <div style="background:white;border-radius:1.25rem;border:1px solid rgba(30,136,229,0.1);padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
            <span style="font-size:0.8125rem;font-weight:700;color:#6B7A99;margin-right:0.5rem;">Spring naar:</span>
            @foreach([
                ['#algemeen', '🐦 Algemeen'],
                ['#data', '🏦 Banken & data'],
                ['#installatie', '🛠 Installatie'],
                ['#ai', '🤖 AI'],
                ['#opensource', '⚖️ Open source & licentie'],
            ] as [$href, $label])
            <a href="{{ $href }}" style="font-size:0.8125rem;font-weight:600;color:#1E88E5;text-decoration:none;padding:0.35rem 0.875rem;background:#EEF5FF;border-radius:99px;border:1px solid rgba(30,136,229,0.2);transition:background 0.15s,transform 0.15s;" onmouseover="this.style.background='#DDEEFF';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#EEF5FF';this.style.transform='none'">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════ --}}
{{-- FAQ STYLES                                    --}}
{{-- ══════════════════════════════════════════════ --}}
<style>
    details.bb-faq-item {
        background: white;
        border: 1px solid rgba(30,136,229,0.12);
        border-radius: 1rem;
        padding: 0;
        transition: border-color 0.18s, box-shadow 0.18s;
    }
    details.bb-faq-item[open] {
        border-color: rgba(30,136,229,0.35);
        box-shadow: 0 4px 24px rgba(30,136,229,0.1);
    }
    details.bb-faq-item summary {
        padding: 1.125rem 1.5rem;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 700;
        color: #0B1F3A;
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        line-height: 1.4;
    }
    details.bb-faq-item summary::-webkit-details-marker { display: none; }
    details.bb-faq-item summary::after {
        content: '＋';
        flex-shrink: 0;
        width: 1.75rem; height: 1.75rem;
        background: #EEF5FF;
        color: #1565C0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
        transition: transform 0.2s, background 0.18s;
    }
    details.bb-faq-item[open] summary::after {
        content: '−';
        background: #1565C0;
        color: white;
    }
    details.bb-faq-item .bb-faq-body {
        padding: 0 1.5rem 1.25rem;
        font-size: 0.9375rem;
        color: #6B7A99;
        line-height: 1.7;
    }
    details.bb-faq-item .bb-faq-body p { margin: 0 0 0.75rem; }
    details.bb-faq-item .bb-faq-body p:last-child { margin-bottom: 0; }
    details.bb-faq-item .bb-faq-body code {
        background: #EEF5FF;
        padding: 0.1rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.85em;
        color: #1565C0;
    }
    details.bb-faq-item .bb-faq-body a {
        color: #1565C0;
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 2px;
    }
    details.bb-faq-item .bb-faq-body strong { color: #0B1F3A; }
    .bb-faq-cat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2.5rem 0 1.25rem;
    }
    .bb-faq-cat-header:first-child { margin-top: 0; }
    .bb-faq-cat-icon {
        width: 3rem; height: 3rem;
        background: linear-gradient(135deg, #1E88E5, #1565C0);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.375rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(30,136,229,0.3);
    }
    .bb-faq-cat-title {
        font-size: 1.375rem;
        font-weight: 800;
        color: #0B1F3A;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .bb-faq-cat-sub {
        font-size: 0.8125rem;
        color: #6B7A99;
        margin: 0;
    }
    .bb-faq-list {
        display: flex;
        flex-direction: column;
        gap: 0.875rem;
    }
</style>

{{-- ══════════════════════════════════════════════ --}}
{{-- FAQ CONTENT                                   --}}
{{-- ══════════════════════════════════════════════ --}}
<section style="background:#F0F6FF;padding:2.5rem 1.5rem 4rem;">
    <div class="bb-wrap" style="max-width:880px;">

        {{-- ALGEMEEN --}}
        <div id="algemeen">
            <div class="bb-faq-cat-header">
                <div class="bb-faq-cat-icon">🐦</div>
                <div>
                    <h2 class="bb-faq-cat-title">Algemeen</h2>
                    <p class="bb-faq-cat-sub">Wat is BankBird en voor wie</p>
                </div>
            </div>
            <div class="bb-faq-list">
                <details class="bb-faq-item">
                    <summary>Wat is BankBird precies?</summary>
                    <div class="bb-faq-body">
                        <p>BankBird is een persoonlijke financiële administratie-app. Je importeert je bankafschriften (PDF of CSV), de app categoriseert je transacties — automatisch of handmatig — en geeft je heldere maandoverzichten en rapporten over waar je geld naartoe gaat.</p>
                        <p>Het draait op je eigen computer of server. Geen abonnement, geen cloud-account bij ons, geen reclame.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Wat kost BankBird?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Niets.</strong> BankBird is volledig gratis en open-source. Geen freemium-trucjes, geen "premium features" die we achter een muur stoppen.</p>
                        <p>De enige potentiële kosten zijn optionele AI-categorisatie (waarvoor je een eigen Claude of OpenAI API-sleutel gebruikt — pay-as-you-go bij die providers, typisch een paar cent per maand voor persoonlijk gebruik) en een server om het op te draaien (kan ook gewoon je eigen laptop zijn — gratis).</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Voor wie is BankBird bedoeld?</summary>
                    <div class="bb-faq-body">
                        <p>Voor mensen die zelf grip willen op hun financiën zonder dat hun data bij een derde partij belandt. Vaak zijn dat: privacy-bewuste gebruikers, freelancers die willen weten waar hun geld blijft, gezinnen die samen budgetteren, of mensen die simpelweg geen abonnement willen voor iets dat lokaal prima werkt.</p>
                        <p>Je hoeft géén ontwikkelaar te zijn — sinds 2026 doet AI de installatie voor je.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Wie maakt BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>BankBird wordt gemaakt door <a href="https://aivionstudios.nl" target="_blank" rel="noopener">Aivion Studios</a> als open-source project. De code is publiek op <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" rel="noopener">GitHub</a>, iedereen mag bijdragen.</p>
                    </div>
                </details>
            </div>
        </div>

        {{-- BANKEN & DATA --}}
        <div id="data">
            <div class="bb-faq-cat-header">
                <div class="bb-faq-cat-icon" style="background:linear-gradient(135deg,#16C784,#0D9F66);box-shadow:0 4px 12px rgba(22,199,132,0.3);">🏦</div>
                <div>
                    <h2 class="bb-faq-cat-title">Banken & data</h2>
                    <p class="bb-faq-cat-sub">Welke banken, hoe veilig is je data</p>
                </div>
            </div>
            <div class="bb-faq-list">
                <details class="bb-faq-item">
                    <summary>Welke banken worden ondersteund?</summary>
                    <div class="bb-faq-body">
                        <p>Op dit moment volledig ondersteund: <strong>ING</strong> (PDF en CSV).</p>
                        <p>In ontwikkeling: <strong>Rabobank</strong> en <strong>ABN AMRO</strong>. Andere Nederlandse en Europese banken kunnen toegevoegd worden — we kijken naar het volume aan vraag.</p>
                        <p>Mis je een bank? Open een issue op <a href="https://github.com/AivionStudiosPlayground/bankbird/issues" target="_blank" rel="noopener">GitHub</a>.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Waar staat mijn data?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Op jouw eigen computer of server.</strong> BankBird heeft geen centrale database, geen cloud-account, geen "BankBird-server" die jouw data ziet. Wij kunnen je transacties letterlijk niet inzien — ze staan alleen bij jou.</p>
                        <p>Als je BankBird lokaal installeert (de standaard), staat alles in een SQLite-bestand op je eigen laptop. Verwijder dat bestand en je data is weg.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Hoe veilig is mijn data binnen BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>Alle <strong>IBAN-rekeningnummers worden versleuteld opgeslagen</strong> met Laravel's encryptie (AES-256). Wachtwoorden worden gehasht met bcrypt.</p>
                        <p>Je kunt <strong>twee-factor authenticatie (TOTP)</strong> activeren via je profiel, zodat zelfs iemand met je wachtwoord niet kan inloggen.</p>
                        <p>Voor multi-user setups is er per-gebruiker data-isolatie: gebruikers zien alleen hun eigen accounts en transacties, ook als ze in dezelfde database zitten.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Gaat mijn data ooit naar een externe partij?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Standaard niet.</strong> BankBird stuurt geen data ergens heen.</p>
                        <p>De enige uitzondering is als je <em>zelf</em> AI-categorisatie inschakelt — dan worden beschrijvingen van transacties (zoals "Albert Heijn", "Spotify") naar Claude (Anthropic) of OpenAI gestuurd om een categorie te raden. Bedragen, IBANs en persoonlijke gegevens worden niet meegestuurd. Dit is volledig opt-in en je kunt het altijd uitzetten.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Wat als ik wil stoppen — kan ik mijn data exporteren?</summary>
                    <div class="bb-faq-body">
                        <p>Ja. Aangezien BankBird op jouw computer draait, heb je altijd directe toegang tot het SQLite-bestand. Daar kun je via een SQL-tool (DB Browser for SQLite, TablePlus, etc) alles uit halen in CSV of een ander formaat.</p>
                        <p>Een ingebouwde export-functie staat op de roadmap.</p>
                    </div>
                </details>
            </div>
        </div>

        {{-- INSTALLATIE --}}
        <div id="installatie">
            <div class="bb-faq-cat-header">
                <div class="bb-faq-cat-icon" style="background:linear-gradient(135deg,#FF8A3D,#E65100);box-shadow:0 4px 12px rgba(255,138,61,0.3);">🛠</div>
                <div>
                    <h2 class="bb-faq-cat-title">Installatie</h2>
                    <p class="bb-faq-cat-sub">Hoe krijg je BankBird draaiend</p>
                </div>
            </div>
            <div class="bb-faq-list">
                <details class="bb-faq-item">
                    <summary>Hoe installeer ik BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>De simpelste manier: installeer <a href="https://herd.laravel.com/" target="_blank" rel="noopener">Laravel Herd</a> (één gratis download), clone de repository, en vraag <strong>Claude Code of Codex</strong>: <em>"Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me."</em> De AI doet de rest.</p>
                        <p>Volledige uitleg met screenshots staat op de <a href="{{ url('/install') }}">installatiepagina</a>.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Welke besturingssystemen worden ondersteund?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Windows en macOS</strong> via Laravel Herd — meest soepele installatie.</p>
                        <p><strong>Linux</strong> werkt ook, maar via de geavanceerde route (handmatig PHP, Composer, Node installeren). Herd is op Linux nog niet beschikbaar.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Heb ik technische kennis nodig?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Nee.</strong> Sinds 2026 installeert AI dit voor je. Je hoeft niet te weten wat PHP, Composer of een terminal is — Claude Code of Codex regelt het volledig op basis van het ingebouwde <code>AGENTS.md</code> install-protocol.</p>
                        <p>Als je het zelf handmatig wilt doen, is er een geavanceerde sectie in de README. Maar dat hoeft niet.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Moet ik BankBird elke keer opstarten?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Nee, niet als je Herd gebruikt.</strong> Herd start automatisch met je computer en serveert BankBird op de achtergrond op <code>http://bankbird.test</code>. Je opent gewoon je browser en het draait.</p>
                        <p>Zonder Herd moet je inderdaad elke sessie de development-server starten — daarom raden we Herd aan.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Kan ik BankBird ook online voor meerdere mensen draaien?</summary>
                    <div class="bb-faq-body">
                        <p>Ja. BankBird ondersteunt multi-user met data-isolatie per gebruiker. Voor productie-deployment heb je dan wel een server (VPS of Laravel Cloud), HTTPS, en een MySQL-database aan te bevelen — zie de "Online gebruik" sectie in de README.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Hoe weet ik dat er een update beschikbaar is?</summary>
                    <div class="bb-faq-body">
                        <p>Bij elke admin-pagina toont BankBird automatisch een oranje banner als een nieuwere versie op GitHub is uitgebracht. De banner linkt naar <code>/admin/updates</code> waar je de release notes kunt lezen en de update-prompt kunt kopiëren voor Claude of Codex.</p>
                        <p>De huidige versie staat altijd onderaan in de sidebar — bijvoorbeeld <code>v1.0.0</code> — met een opvallend label als er een update klaar staat.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Hoe update ik BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>Net als de installatie — open Claude Code of Codex CLI in je projectmap en geef de prompt: <em>"Update BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me."</em> De AI volgt het <code>End-user upgrade protocol</code> in <code>AGENTS.md</code>: backup van je database, code pullen, dependencies bijwerken, migraties draaien en smoke-test op de loginpagina.</p>
                        <p>Wil je het zelf doen? Op de <code>/admin/updates</code> pagina staan de exacte commando's onder "Of handmatig (voor ontwikkelaars)".</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Kan ik BankBird zelf aanpassen zonder dat updates breken?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Ja, mits je je aanpassingen op de juiste plek zet.</strong> BankBird heeft twee speciale folders waar wij bij updates <strong>nooit</strong> aankomen:</p>
                        <ul style="margin: 0 0 0.75rem 1.25rem; padding: 0; list-style: disc;">
                            <li><code>app/Custom/</code> — voor jouw eigen PHP-code (eigen Filament-resources, services, jobs)</li>
                            <li><code>resources/views/custom/</code> — voor jouw eigen Blade-templates</li>
                        </ul>
                        <p>Code en views in deze folders blijven bij elke <code>git pull</code> intact, zonder merge-conflicten. In elke folder staat een <code>README.md</code> met voorbeelden.</p>
                        <p>Wijzigingen aan onze core-bestanden (modellen, migraties, bestaande Filament-resources, layouts) zijn op eigen risico — bij upgrades kunnen daar conflicten ontstaan die de AI of jij handmatig moet oplossen.</p>
                        <p>Configuratie zoals logo, brandkleuren en AI-keys gaan via de <strong>Instellingen</strong>-pagina in de admin — dat raakt geen code en blijft bij updates altijd intact.</p>
                    </div>
                </details>
            </div>
        </div>

        {{-- AI --}}
        <div id="ai">
            <div class="bb-faq-cat-header">
                <div class="bb-faq-cat-icon" style="background:linear-gradient(135deg,#7C3AED,#5B21B6);box-shadow:0 4px 12px rgba(124,58,237,0.3);">🤖</div>
                <div>
                    <h2 class="bb-faq-cat-title">AI</h2>
                    <p class="bb-faq-cat-sub">AI-categorisatie en AI-installatie</p>
                </div>
            </div>
            <div class="bb-faq-list">
                <details class="bb-faq-item">
                    <summary>Wat is AI-categorisatie precies?</summary>
                    <div class="bb-faq-body">
                        <p>BankBird kan transactiebeschrijvingen ("Albert Heijn 1234 Amsterdam", "Spotify Premium") naar Claude of OpenAI sturen om automatisch een categorie te raden ("Boodschappen", "Abonnementen"). Je hoeft dan zelf veel minder handmatig te categoriseren.</p>
                        <p>Het is volledig optioneel — zonder AI werkt BankBird ook prima via merchant-patronen die je zelf instelt of door losse handmatige categorisatie.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Wat kost AI-categorisatie?</summary>
                    <div class="bb-faq-body">
                        <p>Je gebruikt je eigen API-sleutel bij Claude (Anthropic) of OpenAI — die rekenen pay-as-you-go af. Voor persoonlijk gebruik is dat typisch een paar cent per maand: een transactie-categorisatie kost minder dan een tiende van een cent.</p>
                        <p>Wij verdienen er niets aan; je betaalt direct aan de AI-provider.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Welke data wordt naar de AI gestuurd?</summary>
                    <div class="bb-faq-body">
                        <p>Alleen de transactiebeschrijving (de tekst zoals 'die op je bankafschrift staat). <strong>Niet</strong>: bedrag, IBAN, eigen naam, datum.</p>
                        <p>De AI ziet dus "Albert Heijn 1234" en geeft "Boodschappen" terug. Meer niet.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Kan ik AI volledig uitzetten?</summary>
                    <div class="bb-faq-body">
                        <p>Ja, gewoon geen API-sleutel invullen — dan stuurt BankBird nooit iets ergens heen. Categorisatie doe je dan via merchant-patronen of handmatig.</p>
                    </div>
                </details>
            </div>
        </div>

        {{-- OPEN SOURCE & LICENTIE --}}
        <div id="opensource">
            <div class="bb-faq-cat-header">
                <div class="bb-faq-cat-icon" style="background:linear-gradient(135deg,#0B1F3A,#1565C0);box-shadow:0 4px 12px rgba(11,31,58,0.3);">⚖️</div>
                <div>
                    <h2 class="bb-faq-cat-title">Open source & licentie</h2>
                    <p class="bb-faq-cat-sub">Wat is open source en wat mag je</p>
                </div>
            </div>
            <div class="bb-faq-list">
                <details class="bb-faq-item">
                    <summary>Wat betekent "open source" precies?</summary>
                    <div class="bb-faq-body">
                        <p>Open source betekent dat de volledige broncode van BankBird publiek beschikbaar is. Iedereen mag de code lezen, kopiëren, aanpassen, en gebruiken. Geen geheime algoritmes, geen verborgen functionaliteit, geen "vendor lock-in".</p>
                        <p>De code staat op <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" rel="noopener">GitHub</a>. Je kunt 'm zelf doorlezen.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Onder welke licentie staat BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>BankBird wordt gepubliceerd onder de <a href="https://www.gnu.org/licenses/agpl-3.0.html" target="_blank" rel="noopener"><strong>GNU Affero General Public License v3.0</strong></a> (AGPL-3.0).</p>
                        <p>De korte samenvatting: gebruiken mag, aanpassen mag, distribueren mag — maar als je BankBird (of een afgeleide versie) als <em>online dienst</em> aanbiedt aan anderen, moet je je aangepaste broncode ook publiek delen onder dezelfde licentie. Dit voorkomt dat een bedrijf BankBird's code stilletjes overneemt en als gesloten SaaS-product verkoopt.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Mag ik BankBird zelf aanpassen voor eigen gebruik?</summary>
                    <div class="bb-faq-body">
                        <p><strong>Ja, vrij.</strong> Voor jezelf — of binnen je gezin, vriendenkring, bedrijf — mag je alles aanpassen wat je wilt. Andere features toevoegen, look-and-feel veranderen, eigen banken integreren: ga je gang.</p>
                        <p>Je hoeft die aanpassingen niet te delen zolang je BankBird alleen voor jezelf of intern gebruikt.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Mag ik BankBird verkopen?</summary>
                    <div class="bb-faq-body">
                        <p>Technisch wel, maar in de praktijk niet zinvol — iedereen kan het origineel <strong>gratis</strong> downloaden van GitHub. Als je iemand wilt helpen tegen vergoeding (installatie, aanpassen, hosting), prima. Maar BankBird zelf onder eigen merk verkopen tegen klanten, zonder waarde toe te voegen, raden we af — en de AGPL-licentie verplicht je sowieso je aanpassingen open te delen.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Mag ik BankBird hosten als dienst voor anderen?</summary>
                    <div class="bb-faq-body">
                        <p>Ja, mits je aan de <strong>AGPL-voorwaarden</strong> voldoet: alle aanpassingen die je maakt aan de code moet je publiek beschikbaar maken voor je gebruikers, onder dezelfde licentie. Dit is hét kernpunt van AGPL versus de "gewone" GPL.</p>
                        <p>Praktisch: als je een gehoste BankBird-versie aanbiedt, moet je een link naar je eigen aangepaste broncode tonen.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Mag ik BankBird's logo of naam gebruiken?</summary>
                    <div class="bb-faq-body">
                        <p>De broncode is open onder AGPL, maar het <strong>logo en de naam "BankBird"</strong> zijn ons handelsmerk. Voor een eigen fork: kies graag een eigen naam en eigen logo — dat voorkomt verwarring bij gebruikers.</p>
                    </div>
                </details>
                <details class="bb-faq-item">
                    <summary>Wat als ik wil bijdragen aan BankBird?</summary>
                    <div class="bb-faq-body">
                        <p>Heel welkom. Bugs vinden, features voorstellen, code contribueren — alles via <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" rel="noopener">GitHub</a>. Open een issue voor ideeën, of stuur een pull request voor concrete wijzigingen.</p>
                    </div>
                </details>
            </div>
        </div>

        {{-- Dual CTA: install of GitHub --}}
        <div class="bb-grid-2" style="margin-top:3rem;gap:1rem;align-items:stretch;">
            <div style="background:linear-gradient(135deg,#0D47A1,#1565C0,#1E88E5);border-radius:1.5rem;padding:2rem;color:white;position:relative;overflow:hidden;">
                <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
                <h3 style="font-size:1.25rem;font-weight:800;margin:0 0 0.625rem;color:white;position:relative;z-index:1;">Klaar om te installeren?</h3>
                <p style="font-size:0.9375rem;color:rgba(255,255,255,0.85);margin:0 0 1.25rem;line-height:1.6;position:relative;z-index:1;">
                    Eén prompt aan Claude of Codex — vier stappen, vijf minuten.
                </p>
                <a href="{{ url('/install') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#1565C0;border-radius:0.75rem;font-weight:800;font-size:0.9375rem;padding:0.625rem 1.25rem;text-decoration:none;position:relative;z-index:1;">
                    🚀 Naar installatie
                </a>
            </div>
            <div style="background:white;border:1px solid rgba(30,136,229,0.12);border-radius:1.5rem;padding:2rem;">
                <h3 style="font-size:1.25rem;font-weight:800;color:#0B1F3A;margin:0 0 0.625rem;">Vraag niet beantwoord?</h3>
                <p style="font-size:0.9375rem;color:#6B7A99;margin:0 0 1.25rem;line-height:1.6;">
                    Open een issue op GitHub — we helpen je verder en voegen het antwoord hier toe.
                </p>
                <a href="https://github.com/AivionStudiosPlayground/bankbird/issues" target="_blank" rel="noopener" class="bb-btn-outline">
                    Stel je vraag
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
