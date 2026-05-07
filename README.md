# BankBird

Persoonlijke financiële administratie — importeer je ING bankafschriften (PDF), categoriseer transacties en houd je uitgaven bij. Ontworpen voor lokaal gebruik op je eigen computer.

## Functies

- PDF-import van ING bankafschriften
- Automatische koppeling van transacties aan merchants via patroonherkenning
- Categorieën met drill-down rapporten
- Optionele AI-categorisatie via Claude of OpenAI (opt-in, API-sleutel vereist)
- Multi-user met per-gebruiker data-isolatie
- Twee-factor authenticatie (TOTP)
- IBANs versleuteld opgeslagen

## Installatie

De aanbevolen manier is via [Laravel Herd](https://herd.laravel.com/) — een gratis tool die PHP, Composer en Node.js bundelt en BankBird automatisch op de achtergrond beschikbaar maakt op `http://bankbird.test`. Geen terminal openen, geen "elke keer iets opstarten".

**Stap 1 — Installeer Laravel Herd**

Download van [herd.laravel.com](https://herd.laravel.com/) en doorloop de installer. Eenmalig. Herd start vanaf nu automatisch met je computer.

**Stap 2 — Clone de repository**

```bash
git clone https://github.com/AivionStudiosPlayground/bankbird.git
cd bankbird
```

**Stap 3 — Vraag Claude (of Codex) de installatie te doen**

Open Claude Code of Codex CLI in deze map en geef deze prompt:

> Installeer BankBird (https://github.com/AivionStudiosPlayground/bankbird) voor me.

De assistent leest het [install-protocol](AGENTS.md#end-user-installation-protocol) en doet de rest: dependencies installeren, database opzetten, het project aan Herd koppelen, een admin-account aanmaken, en de browser openen op de werkende app.

Als alles klaar is open je `http://bankbird.test/admin` in je browser. Voor altijd — ook na een herstart.

## Dagelijks gebruik

Open je browser → `http://bankbird.test/admin` → inloggen. That's it. Je hoeft niets op te starten en geen terminal te openen.

Claude/Codex heb je alleen nog nodig voor updates, hulp bij fouten, of nieuwe features.

## HTTPS (optioneel)

Default draait BankBird op HTTP — dat is veilig op je eigen computer en bespaart configuratie. Wil je tóch een groen slotje? Run één keer in de project-map:

```bash
herd secure
```

Volg de Windows-prompt om Herd's lokale certificaat te vertrouwen. Daarna werkt `https://bankbird.test`.

## Geavanceerd: handmatige installatie

Voor ontwikkelaars die zelf elke stap willen doen, of installeren zonder Herd:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan make:filament-user
```

Of in één commando (na `composer install`):

```bash
composer run setup
php artisan make:filament-user
```

Zonder Herd start je de dev-server zelf:

```bash
composer run dev
```

Open dan `http://127.0.0.1:8000/admin`. Let op: deze server moet je elke keer handmatig starten.

> **Vereisten zonder Herd:** PHP 8.4, Composer, Node.js 20+. PHP 8.5 wordt nog niet ondersteund (wachten op Laravel 12).

## Configuratie

Alle instellingen zijn beschikbaar via het **Instellingen**-menu in de UI, waaronder:

- Bedrijfsnaam, logo en favicon
- AI-categorisatie (opt-in) — vul je eigen Claude of OpenAI API-sleutel in
- Twee-factor authenticatie activeren via je profiel

> **Let op:** Als je AI-categorisatie inschakelt, worden beschrijvingen van je transacties naar Claude (Anthropic) of OpenAI verstuurd. Gebruik dit alleen als je daarmee akkoord gaat.

## Online gebruik

BankBird werkt standaard met SQLite (lokaal, geen server nodig). Voor online/multi-user gebruik:

1. Zet in `.env` de MySQL-verbinding aan (zie commentaar in `.env.example`)
2. Zorg dat je databaseserver TLS en encryptie at-rest ingeschakeld heeft
3. Stel `APP_ENV=production` en een sterk `APP_KEY` in
4. Draai achter een HTTPS-proxy (bijv. Nginx of [Laravel Cloud](https://cloud.laravel.com/))

## Licentie

[GNU Affero General Public License v3.0](LICENSE) — open source, maar aanpassingen die je als dienst aanbiedt moet je ook open source maken.
