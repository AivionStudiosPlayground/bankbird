# Changelog

Alle relevante wijzigingen aan BankBird. Format gebaseerd op [Keep a Changelog](https://keepachangelog.com/), versies volgen [SemVer](https://semver.org/).

Twee niveaus:
- **Publiek** (`/updates`): wat eindgebruikers merken
- **Technisch** (`/updates/technisch`): hoe het onder de motorkap werkt

## [Unreleased]

### Gewijzigd
- **Frontpage-logos vervangen**: ING-logo gewisseld van SVG naar PNG en Codex-logo van JPG naar WebP voor scherpere weergave in de "Compatibel met"-sectie. (Publiek)
- **Standaard dashboard-layout**: een verse gebruiker ziet voortaan een geherordende layout met bredere welkomstbalk en rekeningen-overzicht (span 2), top-merchants en laatste transacties beperkt tot 3 items, en `Inkomsten vs uitgaven` plus `Categorie-uitgaven` standaard verborgen (in te schakelen via "Aanpassen"). Bestaande opgeslagen layouts worden niet aangepast. (Publiek + technisch)

---

## [2.0.0] - 2026-05-10

Major release. Belangrijkste wijzigingen: uitbreiding van de import-bibliotheek met SNS en Knab, volledige re-design van het admin-paneel naar top-navigatie, nieuwe `/updates`-flow met dependency-advisories, en een beveiligings-upgrade van de build-tools.

### Toegevoegd
- **SNS- en Knab-PDF-import** met automatische bankdetectie. Naast ING worden nu ook bankafschriften van SNS en Knab herkend en uitgelezen zonder handmatige instelling. (Publiek + technisch)
- **Demo-data**: 4 nieuwe rekeningen in de demo (SNS betaal/spaar, Knab zakelijk + BTW-spaar) met realistische maandelijkse transacties, bankkosten en BTW-stromen. (Publiek)
- **Geavanceerde update-pagina** (`/updates/technisch`) met technische release-notes per wijziging. Bereikbaar via submenu onder Updates in de navigatie. (Publiek)
- **"Compatibel met"-sectie** op de frontpage met logos van ondersteunde banken en AI-tools (ING, Knab, SNS, Codex, Claude). Transparant default, 100% bij hover, met disclaimer dat het geen officiële samenwerking betreft. (Publiek)
- **Sectie "Geavanceerde updates"** op `/updates` voor adviezen op onderliggende afhankelijkheden (build-tools, server-software, externe pakketten). Toont per advisory een lekentaal-uitleg, severity- en status-badge, uitklapbare dev-commando's en bronvermelding naar GitHub Security Advisories. (Publiek + technisch)

### Gewijzigd
- **Admin-paneel op root-URL** voor self-hosted installaties. Het paneel staat niet langer onder `/admin` maar direct op `/` — een installatie op `bankbird.test` opent in plaats van `bankbird.test/admin`. De marketing-host (`bankbird.app`) houdt `/admin` om botsingen met de publieke landingspagina's te voorkomen, en de combined-host (`bankbird.app.test`) blijft `/dev` en `/demo` gebruiken. Alle interne `url()`-helpers zijn vervangen door een nieuwe `Demo::panelUrl()`-helper die per host de juiste prefix kiest. (Publiek + technisch)
- **Admin-paneel**: switch van zijbalk naar top-navigatie met volledige content-breedte. Logo-default aangepast naar `5.5rem`. (Publiek)
- **Admin-footer**: gecentreerde page-footer onderaan elke pagina met versie-link naar `bankbird.app/updates` (in nieuw tabblad). Vervangt de oude sidebar-footer. (Publiek)
- **Demo-seeder idempotent**: `mt_srand` voor reproduceerbare bedragen + `firstOrCreate` op `import_hash`. Re-runs van `db:seed` produceren geen duplicates of saldi-drift meer. (Technisch)

### Opgelost
- **Demo-login 419** bij gecombineerde lokale host. Livewire-update-endpoint koos verkeerde DB voor demo-form-submits → CSRF-mismatch. Opgelost door Referer-fallback in `SwitchDatabaseForCombinedHost`-middleware. (Technisch)
- **Vriendelijke 403 & 404 foutpagina's** in BankBird-stijl. 403 detecteert demo-modus en toont passende uitleg + dashboard-knop in plaats van een algemene foutmelding. (Publiek)
- **Demo-merchants**: lokale logo-paden ipv afgeschoten Clearbit-URLs. Logo's verschijnen nu weer correct. (Publiek)
- **Vite 5 → 6 beveiligings-upgrade**. Lost twee moderate `npm audit`-advisories op: `GHSA-4w7w-66w2-5vf9` (Vite path traversal in optimized deps `.map` handling) en `GHSA-67mh-4wv8-2f99` (esbuild dev-server accepteert verzoeken van willekeurige origins). Beide adviezen raken uitsluitend de `npm run dev`-ontwikkelserver en zijn niet aanwezig in de productie-build. `vite ^5.0` → `^6.0`, `laravel-vite-plugin ^1.0` → `^1.2`, geïnstalleerd op respectievelijk 6.4.2 en 1.3.0. `npm audit` rapporteert nu 0 kwetsbaarheden. (Technisch)

---

## [1.0.0] - 2026-05-07

Eerste publieke release van BankBird — een self-hosted, open-source persoonlijke financiën-app voor Nederlandse banken. Volledig lokaal te draaien, geen cloud-afhankelijkheid voor je bankdata.

### Functionaliteit in v1.0.0

- **Bankafschriften (ING)**:
  - PDF-import van ING-afschriften
  - CSV-import van ING-afschriften
- **AI-categorisatie**:
  - Categorisatie via Claude (Anthropic API)
  - Categorisatie via OpenAI / GPT
  - Merchant-patroonherkenning via regex-regels
  - Handmatig categoriseren en bulk-acties
  - Categorie-leren op basis van feedback (gebruiker corrigeert → systeem onthoudt)
- **Rapporten & overzicht**:
  - Maandoverzicht met inkomsten en uitgaven
  - Jaaroverzicht
  - Uitgaven per categorie met drill-down
  - Transactiebeheer met filters (datum, bedrag, categorie, merchant, account)
  - Zoeken in transacties (tekst + omschrijving)
- **Beheer**:
  - Multi-user ondersteuning
  - Tweefactorauthenticatie (2FA)
  - Hiërarchisch categoriebeheer (parent/child)
  - Merchantbeheer met match-patronen
  - Importgeschiedenis met re-run en preview
  - Volledige database back-up en restore (Filament-spatie-backup integratie)
- **Demo & onboarding**:
  - Demo-modus met read-only meldingen
  - Demo-seeder met realistische voorbeeld-data
- **Stack**: Laravel 11, Filament v5, PHP 8.4, Tailwind CSS v4, Vite 5
