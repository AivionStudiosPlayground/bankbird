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

        $this->seedDataFor($user);

        AppSetting::current()->update(['logo_height' => '4rem']);
    }

    /**
     * Seed categorieën, merchants, twee accounts en zes maanden transacties
     * voor de gegeven gebruiker. Wordt zowel door DemoSeeder als DevDataSeeder
     * gebruikt zodat lokaal-dev en demo dezelfde fixture-set delen.
     */
    public function seedDataFor(
        User $user,
        string $betaalIban = 'NL91INGB0001234567',
        string $spaarIban = 'NL91INGB0009876543',
    ): void {
        // Deterministic seed: random amounts/days reproduce exactly across runs,
        // so re-seeding is genuinely idempotent (same hash → firstOrCreate skips).
        mt_srand(20260509);

        $this->call(CategorySeeder::class);

        $categories = Category::all()->keyBy('name');
        $merchants = (new MerchantSeeder)->run();

        $betaal = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'ING Betaalrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Betaal,
                'iban' => $betaalIban,
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
                'iban' => $spaarIban,
                'color' => '#14b8a6',
                'icon' => 'wallet',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $snsBetaal = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'SNS Betaalrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Betaal,
                'iban' => 'NL12SNSB0123456789',
                'color' => '#0066B3',
                'icon' => 'banknotes',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $snsSpaar = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'SNS Spaarrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Spaar,
                'iban' => 'NL77SNSB0987654321',
                'color' => '#0099D8',
                'icon' => 'wallet',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $knabBetaal = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Knab Zakelijke Betaalrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Betaal,
                'iban' => 'NL34KNAB0011223344',
                'color' => '#1A0033',
                'icon' => 'banknotes',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $knabSpaar = Account::withoutGlobalScopes()->firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Knab BTW-Spaarrekening'],
            [
                'user_id' => $user->id,
                'type' => AccountType::Spaar,
                'iban' => 'NL56KNAB0099887766',
                'color' => '#5A2C82',
                'icon' => 'wallet',
                'balance' => 0,
                'is_active' => true,
            ]
        );

        $this->generateTransactions($user, $betaal, $spaar, $merchants, $categories);
        $this->generateSnsTransactions($user, $snsBetaal, $snsSpaar, $betaal, $merchants, $categories);
        $this->generateKnabTransactions($user, $knabBetaal, $knabSpaar, $categories);

        foreach ([$betaal, $spaar, $snsBetaal, $snsSpaar, $knabBetaal, $knabSpaar] as $account) {
            Account::recalculateBalance($account->id);
        }
    }

    /** @param array<string, Merchant> $merchants */
    protected function generateTransactions(
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
    protected function createMonthTransactions(
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
        $this->tx($user, $betaal, null, $month->copy()->day(1), $transferAmount, TransactionType::Debit, 'Overboeking naar spaarrekening', $cat['Sparen'] ?? null, $spaar->iban);
        $this->tx($user, $spaar, null, $month->copy()->day(1), $transferAmount, TransactionType::Credit, 'Overboeking van betaalrekening', $cat['Sparen'] ?? null, $betaal->iban);

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

    /** @param array<string, Merchant> $merchants */
    protected function generateSnsTransactions(
        User $user,
        Account $snsBetaal,
        Account $snsSpaar,
        Account $ingBetaal,
        array $merchants,
        EloquentCollection $categories,
    ): void {
        $start = Carbon::create(2025, 11, 1);
        $end = Carbon::create(2026, 4, 30);

        for ($month = $start->copy(); $month->lte($end); $month->addMonth()) {
            // Maandelijkse toelage van ING → SNS (zichtbaar op beide rekeningen).
            $toelage = 15_000;
            $this->tx($user, $ingBetaal, null, $month->copy()->day(5), $toelage, TransactionType::Debit, 'Overboeking naar SNS-rekening', $categories['Sparen'] ?? null, $snsBetaal->iban);
            $this->tx($user, $snsBetaal, null, $month->copy()->day(5), $toelage, TransactionType::Credit, 'Maandelijkse toelage', $categories['Inkomen'] ?? null, $ingBetaal->iban);

            // Lichte uitgaven vanaf de SNS-rekening.
            $this->tx($user, $snsBetaal, $merchants['Albert Heijn'], $month->copy()->day(rand(7, 12)), rand(1_500, 3_500), TransactionType::Debit, 'Albert Heijn', $categories['Boodschappen'] ?? null);
            $this->tx($user, $snsBetaal, $merchants['Lidl'], $month->copy()->day(rand(13, 18)), rand(1_200, 2_800), TransactionType::Debit, 'Lidl', $categories['Boodschappen'] ?? null);
            $this->tx($user, $snsBetaal, $merchants['Bol.com'], $month->copy()->day(rand(15, 22)), rand(1_500, 4_000), TransactionType::Debit, 'bol.com bestelling', $categories['Overig'] ?? null);

            if ($month->month % 2 === 0) {
                $this->tx($user, $snsBetaal, $merchants['Thuisbezorgd'], $month->copy()->day(rand(20, 26)), rand(1_800, 3_200), TransactionType::Debit, 'Thuisbezorgd.nl', $categories['Restaurant/Eten'] ?? null);
            }

            // Vaste maandelijkse SNS-bankkosten (terug te zien in echte SNS-afschriften).
            $this->tx($user, $snsBetaal, null, $month->copy()->day(25), 400, TransactionType::Debit, 'Kosten gebruik betaalrekening inclusief 1 betaalpas', $categories['Overig'] ?? null);

            // Maandelijkse overboeking naar SNS-spaar.
            $sparen = 5_000;
            $this->tx($user, $snsBetaal, null, $month->copy()->day(28), $sparen, TransactionType::Debit, 'Overboeking naar SNS spaar', $categories['Sparen'] ?? null, $snsSpaar->iban);
            $this->tx($user, $snsSpaar, null, $month->copy()->day(28), $sparen, TransactionType::Credit, 'Inleg vanaf SNS betaal', $categories['Sparen'] ?? null, $snsBetaal->iban);
        }

        // Kwartaalrente op SNS-spaar.
        foreach ([Carbon::create(2025, 12, 31), Carbon::create(2026, 3, 31)] as $renteDate) {
            $this->tx($user, $snsSpaar, null, $renteDate, rand(125, 285), TransactionType::Credit, 'Rente '.$renteDate->translatedFormat('F Y'), $categories['Inkomen'] ?? null);
        }
    }

    protected function generateKnabTransactions(
        User $user,
        Account $knabBetaal,
        Account $knabSpaar,
        EloquentCollection $categories,
    ): void {
        $start = Carbon::create(2025, 11, 1);
        $end = Carbon::create(2026, 4, 30);

        $klanten = [
            ['NL95INGB0007997221', 'Tomi Sushi & Grill Restaurant', 'F2026-0016'],
            ['NL87RABO0113510993', 'Lotus V.O.F.', 'F2025-0259'],
            ['NL05INGB0397962800', 'Chuang Chen Holding BV', 'F2026-0012'],
            ['NL38ABNA0471897116', 'RUN GROUP HORECA HOL BV', 'F2025-0249'],
            ['NL51INGB0008780318', 'Restaurant MIDO', 'F2026-0024'],
        ];

        for ($month = $start->copy(); $month->lte($end); $month->addMonth()) {
            // Vaste Knab-kosten — terug te zien op elk Knab zakelijk afschrift.
            $this->tx($user, $knabBetaal, null, $month->copy()->day(2), 1_100, TransactionType::Debit, 'Pakketkosten', $categories['Overig'] ?? null);
            $this->tx($user, $knabBetaal, null, $month->copy()->day(2), rand(525, 850), TransactionType::Debit, 'Transactiekosten '.$month->copy()->subMonth()->translatedFormat('M Y'), $categories['Overig'] ?? null);
            $this->tx($user, $knabBetaal, null, $month->copy()->day(5), 150, TransactionType::Debit, 'Knab Boekhoudkoppeling 1,50 EUR (incl. 0,26 EUR BTW)', $categories['Overig'] ?? null);

            // 2-3 ontvangen factuurbetalingen per maand.
            $totaalOntvangen = 0;
            $aantal = rand(2, 3);
            for ($i = 0; $i < $aantal; $i++) {
                [$iban, $naam, $factuur] = $klanten[($month->month + $i) % count($klanten)];
                $bedrag = rand(85_000, 320_000);
                $totaalOntvangen += $bedrag;
                $this->tx($user, $knabBetaal, null, $month->copy()->day(5 + $i * 6), $bedrag, TransactionType::Credit, $naam.' Ontvangen betaling, '.$factuur, $categories['Inkomen'] ?? null, $iban);
            }

            // Periodieke abonnementen.
            $this->tx($user, $knabBetaal, null, $month->copy()->day(20), 1_000, TransactionType::Debit, 'Periodieke overboeking, Microsoft OneDrive Data Licentie', $categories['Abonnementen'] ?? null, 'NL22INGB0658468022');

            // Loonvoorschot uitgaand.
            $this->tx($user, $knabBetaal, null, $month->copy()->day(25), rand(60_000, 120_000), TransactionType::Debit, 'Overboeking, loonvoorschot', $categories['Overig'] ?? null, 'NL12SNSB8840480323');

            // BTW-stroom: ~21% van ontvangen omzet apart zetten op spaarrekening.
            $btw = (int) round($totaalOntvangen * 0.21);
            if ($btw > 0) {
                $this->tx($user, $knabBetaal, null, $month->copy()->day(15), $btw, TransactionType::Debit, 'Overboeking, BTW sparen betaling', $categories['Sparen'] ?? null, $knabSpaar->iban);
                $this->tx($user, $knabSpaar, null, $month->copy()->day(15), $btw, TransactionType::Credit, 'Ontvangen betaling, BTW reservering', $categories['Sparen'] ?? null, $knabBetaal->iban);
            }
        }

        // Kwartaalafdracht BTW vanaf de spaarrekening (Q4 2025 → eind januari 2026).
        $this->tx($user, $knabSpaar, null, Carbon::create(2026, 1, 31), 285_000, TransactionType::Debit, 'Overboeking naar Belastingdienst, BTW Q4 2025', $categories['Overig'] ?? null, 'NL86INGB0002445588');
    }

    protected function tx(
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
        $hash = md5("seed-user{$user->id}-acc{$account->id}-{$date->toDateString()}-{$description}-{$amountCents}");

        Transaction::withoutGlobalScopes()->firstOrCreate(
            ['import_hash' => $hash],
            [
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
            ]
        );
    }
}
