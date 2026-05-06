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

## Installatie via Claude (aanbevolen)

De eenvoudigste manier om BankBird te installeren is door Claude te vragen het voor je te doen.

**Vereisten:**
- [PHP 8.4+](https://www.php.net/downloads) (bijv. via [Laravel Herd](https://herd.laravel.com/))
- [Composer](https://getcomposer.org/)
- [Node.js 20+](https://nodejs.org/)

**Stap 1** — Clone de repository:
```bash
git clone https://github.com/AivionStudiosPlayground/bankbird.git
cd bankbird
```

**Stap 2** — Vraag Claude (via claude.ai of Claude Code):
> "Installeer BankBird voor me vanuit deze map. Zorg dat alles klaar staat om te gebruiken."

Claude regelt de rest: `.env` aanmaken, `composer install`, database aanmaken, migraties draaien en een admin-account aanmaken.

## Handmatige installatie

```bash
# Afhankelijkheden installeren
composer install
npm install

# Omgeving instellen
cp .env.example .env
php artisan key:generate

# Database aanmaken en migreren
touch database/database.sqlite
php artisan migrate --seed

# Frontend bouwen
npm run build

# Eerste gebruiker aanmaken
php artisan make:filament-user
```

Open daarna `http://localhost/admin` in je browser (of de URL die je webserver aangeeft).

## Lokaal starten (development)

```bash
composer run dev
```

Dit start de Laravel dev-server, queue worker en Vite tegelijk.

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
