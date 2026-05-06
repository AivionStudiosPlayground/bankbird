<?php

namespace Database\Seeders;

use App\Enums\AccountType;
use App\Enums\TransactionType;
use App\Models\Account;
use App\Models\AppSetting;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@bankbird.app'],
            [
                'name' => 'Demo Gebruiker',
                'password' => Hash::make('demo'),
            ]
        );

        $this->call(CategorySeeder::class);

        $categories = Category::all()->keyBy('name');
        $merchants = $this->seedMerchants($categories);

        $betaal = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'ING Betaalrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Betaal,
                'iban' => 'NL91INGB0001234567',
                'color' => '#FF6200',
                'icon' => 'banknotes',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $spaar = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'ING Spaarrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Spaar,
                'iban' => 'NL91INGB0009876543',
                'color' => '#14b8a6',
                'icon' => 'wallet',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $this->generateTransactions($user, $betaal, $spaar, $merchants, $categories);

        Account::recalculateBalance($betaal->id);
        Account::recalculateBalance($spaar->id);

        AppSetting::current()->update(['logo_height' => '4rem']);
    }

    /** @return array<string, Merchant> */
    private function seedMerchants(EloquentCollection $categories): array
    {
        $definitions = [
            ['name' => 'Albert Heijn',       'cat' => 'Boodschappen',    'logo' => 'https://logo.clearbit.com/ah.nl',              'patterns' => ['albert heijn', 'ah.nl']],
            ['name' => 'Jumbo',              'cat' => 'Boodschappen',    'logo' => 'https://logo.clearbit.com/jumbo.com',          'patterns' => ['jumbo']],
            ['name' => 'Lidl',               'cat' => 'Boodschappen',    'logo' => 'https://logo.clearbit.com/lidl.nl',            'patterns' => ['lidl']],
            ['name' => 'Shell',              'cat' => 'Transport',        'logo' => 'https://logo.clearbit.com/shell.com',          'patterns' => ['shell']],
            ['name' => 'NS Reizigers',       'cat' => 'Transport',        'logo' => 'https://logo.clearbit.com/ns.nl',              'patterns' => ['ns reizigers', 'ov-chipkaart']],
            ['name' => 'McDonald\'s',        'cat' => 'Restaurant/Eten', 'logo' => 'https://logo.clearbit.com/mcdonalds.com',      'patterns' => ["mcdonald's", 'mcdonalds']],
            ['name' => 'Thuisbezorgd',       'cat' => 'Restaurant/Eten', 'logo' => 'https://logo.clearbit.com/thuisbezorgd.nl',   'patterns' => ['thuisbezorgd']],
            ['name' => 'HEMA',               'cat' => 'Kleding',          'logo' => 'https://logo.clearbit.com/hema.nl',            'patterns' => ['hema']],
            ['name' => 'Zalando',            'cat' => 'Kleding',          'logo' => 'https://logo.clearbit.com/zalando.nl',         'patterns' => ['zalando']],
            ['name' => 'Netflix',            'cat' => 'Abonnementen',     'logo' => 'https://logo.clearbit.com/netflix.com',        'patterns' => ['netflix']],
            ['name' => 'Spotify',            'cat' => 'Abonnementen',     'logo' => 'https://logo.clearbit.com/spotify.com',        'patterns' => ['spotify']],
            ['name' => 'Basic-Fit',          'cat' => 'Gezondheid',       'logo' => 'https://logo.clearbit.com/basic-fit.com',      'patterns' => ['basic-fit', 'basicfit']],
            ['name' => 'Pathé',              'cat' => 'Entertainment',    'logo' => 'https://logo.clearbit.com/pathe.nl',           'patterns' => ['pathé', 'pathe']],
            ['name' => 'Bol.com',            'cat' => 'Overig',           'logo' => 'https://logo.clearbit.com/bol.com',            'patterns' => ['bol.com']],
            ['name' => 'Energiedirect',      'cat' => 'Wonen',            'logo' => null,                                           'patterns' => ['energiedirect']],
            ['name' => 'CZ Zorgverzekering', 'cat' => 'Gezondheid',       'logo' => 'https://logo.clearbit.com/cz.nl',              'patterns' => ['cz zorgverzekering', 'cz groep']],
            ['name' => 'Etos',               'cat' => 'Gezondheid',       'logo' => 'https://logo.clearbit.com/etos.nl',            'patterns' => ['etos']],
            ['name' => 'Werkgever BV',       'cat' => 'Inkomen',          'logo' => null,                                           'patterns' => ['werkgever bv', 'salarisbetaling']],
        ];

        $result = [];

        foreach ($definitions as $def) {
            $category = $categories[$def['cat']] ?? null;
            $merchant = Merchant::firstOrCreate(
                ['normalized_name' => Str::slug($def['name'])],
                [
                    'name' => $def['name'],
                    'category_id' => $category?->id,
                    'logo_url' => $def['logo'],
                    'match_patterns' => $def['patterns'],
                ]
            );
            $result[$def['name']] = $merchant;
        }

        return $result;
    }

    /** @param array<string, Merchant> $merchants */
    private function generateTransactions(
        User $user,
        Account $betaal,
        Account $spaar,
        array $merchants,
        EloquentCollection $categories,
    ): void {
        $start = Carbon::create(2025, 11, 1);
        $end = Carbon::create(2026, 4, 30);

        $now = Carbon::now();

        for ($month = $start->copy(); $month->lte($end); $month->addMonth()) {
            $this->createMonthTransactions($user, $betaal, $spaar, $merchants, $categories, $month->copy(), $now);
        }
    }

    /** @param array<string, Merchant> $merchants */
    private function createMonthTransactions(
        User $user,
        Account $betaal,
        Account $spaar,
        array $merchants,
        EloquentCollection $categories,
        Carbon $month,
        Carbon $now,
    ): void {
        $cat = $categories;

        // Salary — 25th
        $this->tx($user, $betaal, $merchants['Werkgever BV'], $month->copy()->day(25), 2_850_00, TransactionType::Credit, 'Salarisbetaling november '.$month->format('Y'), $cat['Inkomen'] ?? null);

        // Fixed expenses — 1st
        $this->tx($user, $betaal, null, $month->copy()->day(1), 95_000, TransactionType::Debit, 'Huur woning', $cat['Wonen'] ?? null, 'NL02ABNA0123456789');
        $this->tx($user, $betaal, $merchants['CZ Zorgverzekering'], $month->copy()->day(1), 13_499, TransactionType::Debit, 'CZ Zorgverzekering maandpremie', $cat['Gezondheid'] ?? null);

        // Transfer to savings — 1st
        $transferAmount = 20_000;
        $this->tx($user, $betaal, null, $month->copy()->day(1), $transferAmount, TransactionType::Debit, 'Overboeking naar spaarrekening', $cat['Sparen'] ?? null, 'NL91INGB0009876543');
        $this->tx($user, $spaar, null, $month->copy()->day(1), $transferAmount, TransactionType::Credit, 'Overboeking van betaalrekening', $cat['Sparen'] ?? null, 'NL91INGB0001234567');

        // Fixed subscriptions
        $this->tx($user, $betaal, $merchants['Netflix'], $month->copy()->day(5), 1_799, TransactionType::Debit, 'Netflix abonnement', $cat['Abonnementen'] ?? null);
        $this->tx($user, $betaal, $merchants['Spotify'], $month->copy()->day(10), 1_199, TransactionType::Debit, 'Spotify Premium', $cat['Abonnementen'] ?? null);
        $this->tx($user, $betaal, $merchants['Basic-Fit'], $month->copy()->day(15), 2_699, TransactionType::Debit, 'Basic-Fit lidmaatschap', $cat['Gezondheid'] ?? null);
        $this->tx($user, $betaal, $merchants['Energiedirect'], $month->copy()->day(20), 12_000, TransactionType::Debit, 'Energiedirect voorschot', $cat['Wonen'] ?? null);

        // Groceries — weekly (Albert Heijn ~2x, Jumbo ~1x, Lidl ~1x)
        foreach ([4, 8, 14, 21] as $day) {
            $this->tx($user, $betaal, $merchants['Albert Heijn'], $month->copy()->day($day), rand(3_500, 8_200), TransactionType::Debit, 'Albert Heijn', $cat['Boodschappen'] ?? null);
        }
        foreach ([7, 17, 27] as $day) {
            $this->tx($user, $betaal, $merchants['Jumbo'], $month->copy()->day($day), rand(3_200, 6_500), TransactionType::Debit, 'Jumbo supermarkt', $cat['Boodschappen'] ?? null);
        }
        $this->tx($user, $betaal, $merchants['Lidl'], $month->copy()->day(11), rand(2_800, 5_500), TransactionType::Debit, 'Lidl', $cat['Boodschappen'] ?? null);

        // Transport
        $this->tx($user, $betaal, $merchants['Shell'], $month->copy()->day(9), rand(5_500, 8_000), TransactionType::Debit, 'Shell tankstation', $cat['Transport'] ?? null);
        $this->tx($user, $betaal, $merchants['NS Reizigers'], $month->copy()->day(13), rand(1_200, 2_800), TransactionType::Debit, 'NS OV-chipkaart', $cat['Transport'] ?? null);
        if ($month->month % 2 === 0) {
            $this->tx($user, $betaal, $merchants['NS Reizigers'], $month->copy()->day(22), rand(800, 2_000), TransactionType::Debit, 'NS OV-chipkaart', $cat['Transport'] ?? null);
        }

        // Food & delivery
        $this->tx($user, $betaal, $merchants["McDonald's"], $month->copy()->day(rand(12, 18)), rand(800, 1_800), TransactionType::Debit, "McDonald's", $cat['Restaurant/Eten'] ?? null);
        if ($month->month % 2 !== 0) {
            $this->tx($user, $betaal, $merchants['Thuisbezorgd'], $month->copy()->day(rand(20, 26)), rand(2_500, 4_500), TransactionType::Debit, 'Thuisbezorgd.nl', $cat['Restaurant/Eten'] ?? null);
        }

        // Shopping (varies)
        $this->tx($user, $betaal, $merchants['Bol.com'], $month->copy()->day(rand(5, 28)), rand(1_500, 8_500), TransactionType::Debit, 'bol.com bestelling', $cat['Overig'] ?? null);

        if ($month->month % 3 === 0) {
            $this->tx($user, $betaal, $merchants['Zalando'], $month->copy()->day(rand(10, 25)), rand(4_000, 12_000), TransactionType::Debit, 'Zalando', $cat['Kleding'] ?? null);
        }

        if ($month->month % 4 === 0) {
            $this->tx($user, $betaal, $merchants['HEMA'], $month->copy()->day(rand(8, 20)), rand(1_200, 4_500), TransactionType::Debit, 'HEMA', $cat['Kleding'] ?? null);
        }

        // Entertainment
        if ($month->month % 2 === 0) {
            $this->tx($user, $betaal, $merchants['Pathé'], $month->copy()->day(rand(15, 28)), rand(1_500, 2_800), TransactionType::Debit, 'Pathé bioscoop', $cat['Entertainment'] ?? null);
        }

        // Health / pharmacy
        if ($month->month % 3 === 1) {
            $this->tx($user, $betaal, $merchants['Etos'], $month->copy()->day(rand(5, 25)), rand(800, 2_500), TransactionType::Debit, 'Etos', $cat['Gezondheid'] ?? null);
        }
    }

    private function tx(
        User $user,
        Account $account,
        ?Merchant $merchant,
        Carbon $date,
        int $amountCents,
        TransactionType $type,
        string $description,
        ?Category $category,
        ?string $counterpartIban = null,
    ): void {
        Transaction::withoutGlobalScopes()->create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'merchant_id' => $merchant?->id,
            'category_id' => $category?->id,
            'date' => $date->toDateString(),
            'description' => $description,
            'raw_description' => strtoupper($description),
            'amount' => $amountCents / 100,
            'type' => $type,
            'counterpart_iban' => $counterpartIban,
            'imported_at' => now(),
            'import_hash' => md5("demo-{$account->id}-{$date->toDateString()}-{$description}-{$amountCents}"),
        ]);
    }
}
