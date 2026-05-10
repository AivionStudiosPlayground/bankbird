@extends('layouts.public')

@section('title', 'Geavanceerde update — BankBird')
@section('description', 'Technische release-notes van BankBird. Wat is er onder de motorkap veranderd en wat betekent dat voor jouw installatie.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-60px;left:-60px;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.07) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;max-width:880px;">
        <a href="{{ url('/updates') }}" style="display:inline-flex;align-items:center;gap:0.4rem;color:rgba(255,255,255,0.75);font-size:0.875rem;font-weight:600;text-decoration:none;margin-bottom:1.5rem;">
            ← Terug naar overzicht
        </a>
        <div class="bb-pill" style="background:rgba(255,138,61,0.2);border-color:rgba(255,138,61,0.4);color:#FFE082;margin-bottom:1rem;">⚙️ Geavanceerde update</div>
        <h1 style="font-size:clamp(1.875rem,3.5vw,2.5rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.15;letter-spacing:-0.02em;">
            Technische release-notes
        </h1>
        <p style="font-size:1rem;color:rgba(255,255,255,0.8);margin:0;max-width:620px;line-height:1.65;">
            Een eerlijk kijkje onder de motorkap: wat is er gewijzigd in de codebase en wat betekent dat voor jouw BankBird-installatie. Alle wijzigingen worden automatisch meegenomen in de update — je hoeft niets handmatig te doen.
        </p>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

<style>
    .tech-card {
        background: white;
        border: 1px solid rgba(30,136,229,0.12);
        border-radius: 1.25rem;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(30,136,229,0.04);
    }
    .tech-card h2 {
        font-size: 1.125rem;
        font-weight: 800;
        color: #0B1F3A;
        margin: 0 0 0.5rem;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-wrap: wrap;
    }
    .tech-card .tag {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.15rem 0.55rem;
        border-radius: 99px;
    }
    .tag-feature { background:#E3F2FD; color:#1565C0; }
    .tag-fix { background:#E8F5E9; color:#1B5E20; }
    .tag-ux { background:#F3E5F5; color:#6A1B9A; }
    .tag-version {
        background: #0B1F3A;
        color: white;
        font-family: 'JetBrains Mono', ui-monospace, monospace;
    }
    .tech-card p {
        font-size: 0.9375rem;
        color: #4A5568;
        line-height: 1.65;
        margin: 0 0 0.875rem;
    }
    .tech-card p:last-child { margin-bottom: 0; }
    .tech-card code {
        background: #F0F6FF;
        color: #1565C0;
        padding: 0.1rem 0.4rem;
        border-radius: 0.3rem;
        font-size: 0.85em;
        font-family: 'JetBrains Mono', ui-monospace, monospace;
    }
    .tech-card .meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.875rem;
    }
    .tech-card .meta-item {
        font-size: 0.7rem;
        font-weight: 600;
        color: #6B7A99;
        background: #F0F6FF;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
        border: 1px solid rgba(30,136,229,0.1);
    }
    .tech-card .status-note {
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #F0FFF8, #E8F5E9);
        border-left: 3px solid #16C784;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        color: #1B5E20;
        line-height: 1.55;
    }
    .tech-card .status-note strong { color: #0A9660; }

    /* Release-bundle: <details> wrapper per versie */
    .release-bundle {
        background: white;
        border: 1px solid rgba(30,136,229,0.15);
        border-radius: 1.25rem;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(30,136,229,0.06);
    }
    .release-bundle[open] {
        box-shadow: 0 8px 24px rgba(30,136,229,0.1);
        border-color: rgba(30,136,229,0.25);
    }
    .release-bundle > summary {
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: linear-gradient(135deg, #F0F6FF, #E3F2FD);
        transition: background 0.18s;
    }
    .release-bundle[open] > summary {
        background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
        border-bottom: 1px solid rgba(30,136,229,0.15);
    }
    .release-bundle > summary::-webkit-details-marker { display: none; }
    .release-bundle .release-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .release-bundle .release-version {
        font-family: 'JetBrains Mono', ui-monospace, monospace;
        font-size: 1rem;
        font-weight: 800;
        color: #0B1F3A;
        background: white;
        padding: 0.3rem 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(30,136,229,0.2);
    }
    .release-bundle .release-date {
        font-size: 0.875rem;
        color: #4A5568;
        font-weight: 500;
    }
    .release-bundle .release-status {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
        background: #FF8A3D;
        color: white;
    }
    .release-bundle .release-toggle {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1565C0;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        flex-shrink: 0;
    }
    .release-bundle .release-toggle svg {
        transition: transform 0.2s;
    }
    .release-bundle[open] .release-toggle svg {
        transform: rotate(180deg);
    }
    .release-bundle .release-body {
        padding: 1.5rem;
    }
    .release-bundle .release-body .tech-card:last-child { margin-bottom: 0; }
    .release-bundle .release-summary-text {
        font-size: 0.8125rem;
        color: #4A5568;
        margin-top: 0.375rem;
        line-height: 1.5;
    }
</style>

<section style="background:#F0F6FF;padding:2.5rem 1.5rem 5rem;">
    <div class="bb-wrap" style="max-width:880px;">

        {{-- ─── Release v2.0.0 (live) ─────────────────────────────────── --}}
        <details class="release-bundle" open>
            <summary>
                <div>
                    <div class="release-meta">
                        <span class="release-version">v2.0.0</span>
                        <span class="release-date">📅 10 mei 2026</span>
                        <span class="release-status">Vrijgegeven</span>
                    </div>
                    <div class="release-summary-text">7 wijzigingen — SNS &amp; Knab PDF-import, vriendelijke 403/404, top-navigation, admin-paneel op root, Vite-beveiligingsupgrade, idempotente demo-seeder, demo-login fix</div>
                </div>
                <span class="release-toggle">
                    <span class="toggle-text">Bekijk wijzigingen</span>
                    <svg width="14" height="14" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5l3 3 3-3"/></svg>
                </span>
            </summary>
            <div class="release-body">

        {{-- 1. PDF importers SNS + Knab --}}
        <div class="tech-card">
            <h2>📄 SNS &amp; Knab PDF-import <span class="tag tag-feature">Nieuwe functie</span></h2>
            <div class="meta">
                <span class="meta-item">Service: <code>PdfImportService</code></span>
                <span class="meta-item">Auto-detectie van bank</span>
            </div>
            <p>Naast de bestaande ING-parser zijn er nu volwaardige parsers voor SNS- en Knab-bankafschriften. Bij een upload wordt automatisch herkend van welke bank de PDF afkomstig is op basis van keywords in de tekst — geen instelling vereist.</p>
            <p><strong>Knab-detail:</strong> de PDF-tekst-extractor verliest de Af/Bij-kolompositie. Debet vs. credit wordt afgeleid uit het keyword <code>Ontvangen</code> in de omschrijving — werkt op alle geteste afschriften.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Bij nieuwe installs is dit standaard meegeleverd. Bestaande installs krijgen het automatisch via de update — je hoeft niets te doen, na het binnenhalen werkt SNS- en Knab-upload meteen.
            </div>
        </div>

        {{-- 2. Custom error pages --}}
        <div class="tech-card">
            <h2>🎨 Vriendelijke 403 &amp; 404 foutpagina's <span class="tag tag-ux">UX-verbetering</span></h2>
            <div class="meta">
                <span class="meta-item">Views: <code>resources/views/errors/</code></span>
            </div>
            <p>Laravel's standaard "Forbidden" en "Not Found"-pagina's zijn vervangen door BankBird-gestylde varianten met duidelijke uitleg en een terug-knop. Een rauwe error-pagina geeft de indruk dat het systeem kapot is, ook als de oorzaak gewone toegangsregels zijn — die verwarring is nu weg.</p>
            <p>De 403 detecteert demo-modus en toont dan "Niet beschikbaar in demo" met dashboard-knop in plaats van een algemene foutmelding.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Niets te doen — alle bestaande installs krijgen de gestylde error-pagina's automatisch zodra de update binnen is.
            </div>
        </div>

        {{-- 3. Top navigation + footer --}}
        <div class="tech-card">
            <h2>🧭 Top navigation + page footer <span class="tag tag-ux">UX-verbetering</span></h2>
            <div class="meta">
                <span class="meta-item">Filament v5 layout switch</span>
                <span class="meta-item">Volledige content-breedte</span>
            </div>
            <p>Het admin-paneel switcht van zijbalk-menu naar een top-navigatie met volledige content-breedte. De vorige sidebar-footer met versie-info is vervangen door een gecentreerde page-footer onderaan elke pagina. Versie-link gaat naar het publieke updates-overzicht in een nieuw tabblad.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Komt automatisch mee in de update. Een hard refresh (Ctrl+F5) kan handig zijn om verouderde browser-cache te legen, maar verder geen actie nodig.
            </div>
        </div>

        {{-- 4. Admin-paneel op root-URL --}}
        <div class="tech-card">
            <h2>🏠 Admin-paneel op root-URL <span class="tag tag-ux">UX-verbetering</span></h2>
            <div class="meta">
                <span class="meta-item">Helper: <code>App\Support\Demo::panelPath()</code></span>
                <span class="meta-item">Helper: <code>App\Support\Demo::panelUrl(...)</code></span>
            </div>
            <p>Self-hosted installaties tonen het admin-paneel niet langer op <code>/admin</code> maar op de root-URL. Een verse installatie op <code>bankbird.test</code> opent dus direct het dashboard, niet <code>bankbird.test/admin</code>. De marketing-host (<code>bankbird.app</code>) houdt <code>/admin</code> om botsingen met de publieke landingspagina's te vermijden, en de combined-host blijft <code>/dev</code> en <code>/demo</code> gebruiken voor lokale ontwikkeling.</p>
            <p>De keuze welke prefix actief is gebeurt centraal in <code>Demo::panelPath()</code> op basis van de host. Alle hardcoded <code>url('/admin/...')</code>-aanroepen in views zijn vervangen door een nieuwe <code>Demo::panelUrl(string $path)</code>-helper die per host het juiste pad samenstelt — admin-banner, sidebar-footer en 404-pagina werken daarmee automatisch op alle deployment-vormen.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Bestaande installaties op <code>bankbird.test/admin</code> verhuizen automatisch naar <code>bankbird.test/</code> na de update. Oude bookmarks naar <code>/admin/...</code> blijven niet werken — vervang ze door de nieuwe URL of klik gewoon door vanaf de root.
            </div>
        </div>

        {{-- 5. Vite 5 → 6 upgrade + Geavanceerde-updates-sectie --}}
        <div class="tech-card">
            <h2>🛡️ Vite 5 → 6 beveiligings-upgrade <span class="tag tag-feature">Beveiliging</span></h2>
            <div class="meta">
                <span class="meta-item">Pakket: <code>vite ^5.0 → ^6.0</code></span>
                <span class="meta-item">Pakket: <code>laravel-vite-plugin ^1.0 → ^1.2</code></span>
            </div>
            <p>Twee moderate <code>npm audit</code>-advisories opgelost: <code>GHSA-4w7w-66w2-5vf9</code> (Vite path traversal in optimized deps <code>.map</code> handling) en <code>GHSA-67mh-4wv8-2f99</code> (esbuild dev-server accepteert verzoeken van willekeurige origins). Beide adviezen raken uitsluitend de <code>npm run dev</code>-ontwikkelserver en zijn niet aanwezig in de productie-build.</p>
            <p>Gekozen voor de minor-major bump van Vite 5 naar 6 in plaats van de automatische <code>npm audit fix --force</code> (die naar Vite 8 zou springen en ook <code>laravel-vite-plugin</code> naar 3.x zou bumpen). Tailwind v4 via <code>@tailwindcss/vite@4.2.4</code> bleef ongemoeid en is compatibel met Vite 5/6/7/8. Geïnstalleerde versies: <code>vite@6.4.2</code>, <code>laravel-vite-plugin@1.3.0</code>. <code>npm audit</code> rapporteert nu 0 kwetsbaarheden.</p>
            <p>Daarnaast is op <code>/updates</code> een nieuwe sectie <strong>"Geavanceerde updates"</strong> toegevoegd waar dependency- en beveiligings-advisories permanent worden gepubliceerd, met severity- en status-badges, lekentaal-uitleg en uitklapbare commando's voor ontwikkelaars.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Geen actie nodig op draaiende installs — de productie-build was nooit kwetsbaar. Bij toekomstige eigen builds maak één keer een <code>npm install</code> en <code>npm run build</code> na de update om de nieuwe versies binnen te halen.
            </div>
        </div>

        {{-- 6. Demo-seeder idempotent --}}
        <div class="tech-card">
            <h2>🌱 Idempotente demo-seeder <span class="tag tag-fix">Bug-fix</span></h2>
            <div class="meta">
                <span class="meta-item">Seeder: <code>DemoSeeder</code></span>
                <span class="meta-item">Reproduceerbaarheid: <code>mt_srand</code></span>
            </div>
            <p>De demo-seeder produceerde bij elke <code>php artisan db:seed</code> nieuwe willekeurige bedragen, wat leidde tot duplicate transacties en verschuivende saldi bij re-runs. Opgelost door <code>mt_srand</code> met een vaste seed te gebruiken voor reproduceerbare bedragen, en <code>firstOrCreate</code> op <code>import_hash</code> om dubbele inserts te voorkomen.</p>
            <p>Resultaat: de demo-database is nu deterministisch — bij elke seed verschijnen exact dezelfde transacties met exact dezelfde bedragen, en re-runs zijn no-ops in plaats van duplicate-creators. Dit maakt het ook makkelijker om regressies in de demo-data te zien tijdens code-review.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Geen actie nodig — de fix is automatisch actief bij de volgende seed.
            </div>
        </div>

        {{-- 7. Demo-login 419 op gecombineerde host --}}
        <div class="tech-card">
            <h2>🔑 Demo-login 419-fix op gecombineerde host <span class="tag tag-fix">Bug-fix</span></h2>
            <div class="meta">
                <span class="meta-item">Middleware: <code>SwitchDatabaseForCombinedHost</code></span>
                <span class="meta-item">Symptoom: 419 Page Expired bij demo-login</span>
            </div>
            <p>Op de gecombineerde lokale host koos het Livewire-update-endpoint de verkeerde database voor demo-form-submits, waardoor de CSRF-token in de demo-database werd gevalideerd tegen de sessie van de productie-database — met een 419-mismatch als gevolg. Opgelost door een Referer-fallback toe te voegen in <code>SwitchDatabaseForCombinedHost</code>: als de host-header geen uitsluitsel geeft, wordt de demo-database gekozen op basis van de oorsprongs-URL van het verzoek.</p>
            <div class="status-note">
                <strong>✅ Bekend bij ons en al opgelost.</strong> Alleen relevant voor lokale combined-host setups. Productie-installaties op een dedicated host hadden hier geen last van.
            </div>
        </div>

            </div>
        </details>

        <div style="text-align:center;margin-top:2rem;">
            <a href="{{ url('/updates') }}" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;color:#1565C0;border:1px solid rgba(30,136,229,0.2);border-radius:0.75rem;padding:0.75rem 1.5rem;font-size:0.9375rem;font-weight:700;text-decoration:none;box-shadow:0 4px 12px rgba(30,136,229,0.08);transition:transform 0.15s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">
                ← Terug naar updates
            </a>
        </div>

    </div>
</section>

@endsection
