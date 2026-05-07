# BankBird — Agent Instructions

This file tells AI coding agents (OpenAI Codex, Claude Code, Gemini, etc.) how to work with this codebase effectively.

## Project overview

BankBird is a personal finance app built on Laravel 11 + Filament v5. It imports ING bank statements (PDF), auto-matches transactions to merchants via pattern rules, and supports optional AI categorisation (Claude / OpenAI, opt-in only). It is designed primarily for local use but also supports multi-user online deployments.

There is no customer-facing frontend — the entire UI is a Filament admin panel at `/admin`.

## Stack & key versions

| Package | Version |
|---|---|
| PHP | 8.4 |
| Laravel | 11.x |
| Filament | 5.x |
| Livewire | 4.x |
| Tailwind CSS | 4.x |
| PHPUnit | 10.x |

Database: SQLite by default (local), MySQL optional (online).

## Environment setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # only needed for SQLite
php artisan migrate --seed
npm run build
php artisan make:filament-user   # create first admin user
```

Run the dev server:
```bash
composer run dev
```

## Project structure

```
app/
  Enums/              AccountType, TransactionType, ImportStatus
  Filament/
    Pages/            ManageSettings, MonthlyReport, CategoryDrilldown, ...
    Resources/        AccountResource, TransactionResource, MerchantResource, ImportResource, ...
  Models/             Account, Transaction, Merchant, Category, Import, AppSetting, User
  Services/
    PdfImportService          ING PDF parser + import orchestration
    MerchantPatternService    Pattern matching + retroactive sync
    AiCategorizationService   Optional Claude / OpenAI categorisation
    MerchantMapperService     Description normalisation
database/
  migrations/
  seeders/            CategorySeeder (default categories)
```

## Coding conventions

- Follow existing patterns in sibling files before writing anything new.
- PHP 8.4: use constructor property promotion, named arguments, match expressions where appropriate.
- Always declare return types and parameter types: `function foo(User $user): bool`.
- Curly braces on all control structures, even single-line bodies.
- Enum keys in TitleCase: `AccountType::Checking`.
- Model casts go in a `casts(): array` method, not a `$casts` property.
- No comments explaining *what* code does — only *why* when it's non-obvious.
- Do not add error handling for impossible scenarios. Trust framework guarantees.

## Laravel 11 specifics

- Middleware is registered in `bootstrap/app.php`, not `Kernel.php`.
- Service providers go in `bootstrap/providers.php`.
- Console commands in `app/Console/Commands/` auto-register — no manual registration needed.
- When modifying a column in a migration, include **all** previously defined attributes or they will be dropped.

## Filament v5 specifics

- Resources live in `app/Filament/Resources/`.
- Pages auto-discovered from `app/Filament/Pages/`.
- Use `Filament\Schemas\Schema` (not `Filament\Forms\Form`) for form definitions in pages.
- Use `Filament\Schemas\Components\Section` for layout sections in pages.
- The panel config is in `app/Providers/Filament/AdminPanelProvider.php`.

## Security model

- **Encrypted fields**: `accounts.iban` and `transactions.counterpart_iban` use Laravel's `encrypted` cast. Never query these columns in raw SQL — always go through Eloquent.
- **Encrypted cast + pluck**: use `->get()->pluck(...)` (collection) not `->pluck(...)` (query builder) when building IBAN lookup maps, otherwise the cast is bypassed.
- **Per-user data isolation**: `Account` and `Transaction` both have a global scope that filters by `auth()->id()`. Use `withoutGlobalScopes()` in jobs, commands, or internal recalculation methods that run outside a user request.
- **AI keys**: Claude and OpenAI API keys are stored encrypted in `app_settings` via `AppSetting::current()`. Never read them from `.env` directly in application code — use `AiCategorizationService`.
- **2FA**: Filament's TOTP `AppAuthentication` is active. The `User` model implements `HasAppAuthentication` and `HasAppAuthenticationRecovery`.

## Artisan commands

```bash
php artisan migrate              # run migrations
php artisan migrate:fresh --seed # reset + reseed (dev only)
php artisan make:filament-user   # create an admin user
php artisan tinker               # interactive REPL
php artisan route:list --except-vendor  # inspect routes
```

## Code formatting

After modifying any PHP file, run:
```bash
vendor/bin/pint --dirty
```

Pint enforces the project's code style automatically.

## Testing

```bash
php artisan test                          # all tests
php artisan test tests/Feature/Foo.php   # single file
php artisan test --filter=testName       # single test
```

- All tests are PHPUnit classes in `tests/Feature/` or `tests/Unit/`.
- Use model factories; never hardcode IDs or create records without a factory.
- Do not delete or skip existing tests without explicit approval.
- Cover happy paths, failure paths, and edge cases.

## Do not change without approval

- Composer or npm dependencies
- Database schema for existing columns (add new migrations instead)
- The `app/Providers/Filament/AdminPanelProvider.php` panel ID or path
- Any existing migration file

## End-user installation protocol

This section is for agents (Claude Code, Codex CLI, etc.) helping a non-technical user install BankBird on their own machine. The user prompt will typically be: *"Installeer BankBird voor me."*

**Operating principle**: the user does not know what PHP, Composer, or a terminal is. Run all checks yourself. Only ask the user to act when there is a Windows/macOS dialog they must click (UAC, installer wizard). Do **not** dump commands like `php -v` on them.

### 0. Confirm starting state

The user has cloned the repo and is sitting in the project root. Verify:
- `composer.json` exists in the current working directory.
- The `.git` directory is present.

If not, ask the user where they cloned it.

### 1. Detect Laravel Herd

Herd is the recommended runtime. It bundles PHP 8.4, Composer and Node, runs as a background service, and serves `*.test` domains automatically — eliminating "how do I start the app?" forever.

Detect:
```bash
herd --version
```

- **Found**: skip to step 3.
- **Not found**: continue to step 2.

### 2. Install Herd (if missing)

Tell the user, in plain language, what you're about to do and ask permission **once**:

> "Voor de soepelste ervaring installeer ik Laravel Herd — een gratis tool die BankBird altijd op de achtergrond beschikbaar maakt op `http://bankbird.test`. Ik download de installer en start hem. Windows vraagt je éénmalig om Ja te klikken op een beveiligingsvenster (UAC). Akkoord?"

After explicit approval:

1. Determine the correct installer URL by fetching `https://herd.laravel.com/` and selecting the OS-specific download link (Windows `.exe` or macOS `.dmg`).
2. Download to a temp location.
3. Launch the installer and wait for it to exit.
4. Re-run `herd --version` to confirm. If Herd added itself to PATH but the current shell hasn't picked it up, instruct the user to open a fresh terminal — but resume the install yourself in that new shell rather than handing the work back.

If the user declines Herd, fall back to the **No-Herd path** at the bottom of this section.

### 3. Link the project to Herd

In the project root:

```bash
herd link bankbird
```

This registers the folder as `http://bankbird.test`. Verify success by checking that `herd links` (or equivalent) lists `bankbird`.

### 4. Run setup

One command does the rest:

```bash
composer install
composer run setup
```

`composer run setup` (defined in `composer.json`) handles: `.env` creation, `APP_KEY` generation, SQLite file, migrations + seeders, `npm install`, and `npm run build`.

### 5. Create the first admin user

```bash
php artisan make:filament-user
```

This is interactive. Either:
- Pass values yourself if the user has already given you a name + email + password, or
- Ask the user for those three things in one message — not three separate prompts.

### 6. Smoke test

Do **not** declare success until this passes:

```bash
curl -sI http://bankbird.test/admin/login
```

Expected: `HTTP/1.1 200` (or `302` redirect to login). Then fetch the body:

```bash
curl -s http://bankbird.test/admin/login
```

Verify the response:
- Contains a `<form` element.
- Does **not** contain the strings `Deprecated:`, `Warning:`, `Fatal error`, `Whoops`.
- Contains Livewire's `wire:` attributes (proof Livewire markup rendered, not a static error page).

If any check fails, diagnose and fix before continuing — never report "klaar" on a half-broken install.

### 7. Hand off

Open the user's default browser to `http://bankbird.test/admin`, then send one short message:

> "BankBird draait. Open je browser op http://bankbird.test/admin en log in met de gegevens die je net hebt ingevuld. Herd start automatisch met je computer mee — je hoeft hierna niets meer op te starten."

Do **not** explain `composer run dev`, `php artisan serve`, or any developer tooling. Those are irrelevant to this user.

### No-Herd path (fallback only)

Only used if the user declined Herd installation. Be honest about the tradeoff:

> "Zonder Herd moet je de lokale server elke keer handmatig starten met `composer run dev`. Wil je dat liever?"

If they confirm:
1. Verify `php --version` (must be `8.4.x`), `composer --version`, `node --version` (≥ 20). If any are missing, stop and tell the user which one — do not try to install language runtimes yourself.
2. `composer install` → `composer run setup` → `php artisan make:filament-user`.
3. Smoke-test against `http://127.0.0.1:8000/admin/login` after starting `composer run dev` in the background.
4. Tell them: *"Open `http://127.0.0.1:8000/admin`. Let op: deze server moet je elke keer opnieuw starten met `composer run dev` als je 'm gebruikt."*

**Use `127.0.0.1`, not `localhost`** — on Windows `localhost` often resolves to `::1` (IPv6) while `php artisan serve` only listens on IPv4.
