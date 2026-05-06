<?php

namespace App\Filament\Pages;

use App\Models\Account;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read Schema $form
 */
class BackupPage extends Page
{
    protected string $view = 'filament.pages.backup';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Backup';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('backup_file')
                    ->label('Selecteer back-upbestand')
                    ->disk('local')
                    ->directory('tmp/backups')
                    ->acceptedFileTypes(['application/json', 'text/plain', '.json'])
                    ->maxSize(51200)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function downloadBackup(): mixed
    {
        $categories = Category::with('children')->whereNull('parent_id')->get()->map(fn (Category $cat) => [
            'id' => $cat->id,
            'name' => $cat->name,
            'icon' => $cat->icon,
            'color' => $cat->color,
            'is_system' => $cat->is_system,
            'children' => $cat->children->map(fn (Category $child) => [
                'id' => $child->id,
                'name' => $child->name,
                'icon' => $child->icon,
                'color' => $child->color,
                'is_system' => $child->is_system,
                'parent_id' => $child->parent_id,
            ])->values()->all(),
        ])->values()->all();

        $merchants = Merchant::all()->map(fn (Merchant $m) => [
            'id' => $m->id,
            'name' => $m->name,
            'normalized_name' => $m->normalized_name,
            'category_id' => $m->category_id,
            'logo_url' => $m->logo_url,
            'match_patterns' => $m->match_patterns,
        ])->values()->all();

        $accounts = Account::all()->map(fn (Account $a) => [
            'id' => $a->id,
            'name' => $a->name,
            'type' => $a->type?->value,
            'iban' => $a->iban,
            'color' => $a->color,
            'icon' => $a->icon,
            'balance' => (float) $a->balance,
            'is_active' => $a->is_active,
        ])->values()->all();

        $transactions = Transaction::with(['account'])
            ->get()
            ->map(fn (Transaction $t) => [
                'account_id' => $t->account_id,
                'date' => $t->date?->format('Y-m-d'),
                'description' => $t->description,
                'raw_description' => $t->raw_description,
                'amount' => (float) $t->amount,
                'type' => $t->type?->value,
                'category_id' => $t->category_id,
                'merchant_id' => $t->merchant_id,
                'counterpart_iban' => $t->counterpart_iban,
                'import_hash' => $t->import_hash,
                'imported_at' => $t->imported_at?->toIso8601String(),
            ])->values()->all();

        $backup = [
            'version' => 1,
            'created_at' => now()->toIso8601String(),
            'categories' => $categories,
            'merchants' => $merchants,
            'accounts' => $accounts,
            'transactions' => $transactions,
        ];

        $json = json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filename = 'bankbird-backup-'.now()->format('Y-m-d').'.json';

        return response()->streamDownload(
            fn () => print ($json),
            $filename,
            ['Content-Type' => 'application/json'],
        );
    }

    public function restoreBackupAction(): Action
    {
        return Action::make('restoreBackup')
            ->label('Terugzetten')
            ->requiresConfirmation()
            ->modalHeading('Back-up terugzetten?')
            ->modalDescription('Hiermee worden je rekeningen, categorieën, merchants en transacties aangevuld vanuit het back-upbestand. Bestaande gegevens worden niet overschreven.')
            ->modalSubmitActionLabel('Ja, terugzetten')
            ->color('warning')
            ->icon('heroicon-o-arrow-path')
            ->action(fn () => $this->performRestore());
    }

    private function performRestore(): void
    {
        if (config('app.demo_mode', false)) {
            Notification::make()
                ->warning()
                ->title('Demo-modus')
                ->body('Terugzetten is uitgeschakeld in de demo-omgeving.')
                ->send();

            return;
        }

        $state = $this->form->getState();
        $path = $state['backup_file'] ?? null;

        if (! $path) {
            Notification::make()->danger()->title('Geen bestand geselecteerd')->send();

            return;
        }

        $json = Storage::disk('local')->get($path);

        if (! $json) {
            Notification::make()->danger()->title('Bestand kon niet worden gelezen')->send();

            return;
        }

        $backup = json_decode($json, true);

        if (! is_array($backup) || ! isset($backup['categories'], $backup['merchants'])) {
            Notification::make()
                ->danger()
                ->title('Ongeldig back-upbestand')
                ->body('Dit bestand is geen geldige BankBird back-up.')
                ->send();

            return;
        }

        // Pass 1: root categories
        $categoryIdMap = [];

        foreach ($backup['categories'] as $cat) {
            $record = Category::firstOrCreate(
                ['name' => $cat['name'], 'parent_id' => null],
                ['icon' => $cat['icon'], 'color' => $cat['color'], 'is_system' => $cat['is_system'] ?? false],
            );
            $categoryIdMap[$cat['id']] = $record->id;

            // Pass 2: children
            foreach ($cat['children'] ?? [] as $child) {
                $childRecord = Category::firstOrCreate(
                    ['name' => $child['name'], 'parent_id' => $record->id],
                    ['icon' => $child['icon'], 'color' => $child['color'], 'is_system' => $child['is_system'] ?? false],
                );
                $categoryIdMap[$child['id']] = $childRecord->id;
            }
        }

        // Merchants
        $merchantIdMap = [];

        foreach ($backup['merchants'] as $merchant) {
            $mappedCategoryId = isset($merchant['category_id']) ? ($categoryIdMap[$merchant['category_id']] ?? null) : null;

            $record = Merchant::firstOrCreate(
                ['normalized_name' => $merchant['normalized_name']],
                [
                    'name' => $merchant['name'],
                    'category_id' => $mappedCategoryId,
                    'logo_url' => $merchant['logo_url'],
                    'match_patterns' => $merchant['match_patterns'],
                ],
            );
            $merchantIdMap[$merchant['id']] = $record->id;
        }

        // Accounts
        $accountIdMap = [];

        foreach ($backup['accounts'] ?? [] as $account) {
            $record = Account::firstOrCreate(
                ['iban' => $account['iban']],
                [
                    'name' => $account['name'],
                    'type' => $account['type'],
                    'color' => $account['color'],
                    'icon' => $account['icon'],
                    'balance' => $account['balance'],
                    'is_active' => $account['is_active'] ?? true,
                ],
            );
            $accountIdMap[$account['id']] = $record->id;
        }

        // Transactions — skip duplicates based on import_hash
        $restored = 0;

        foreach ($backup['transactions'] ?? [] as $transaction) {
            $hash = $transaction['import_hash'] ?? null;

            if ($hash && Transaction::withoutGlobalScopes()->where('import_hash', $hash)->exists()) {
                continue;
            }

            $mappedAccountId = isset($transaction['account_id'])
                ? ($accountIdMap[$transaction['account_id']] ?? null)
                : null;

            if (! $mappedAccountId) {
                continue;
            }

            Transaction::create([
                'account_id' => $mappedAccountId,
                'date' => $transaction['date'],
                'description' => $transaction['description'],
                'raw_description' => $transaction['raw_description'],
                'amount' => $transaction['amount'],
                'type' => $transaction['type'],
                'category_id' => isset($transaction['category_id']) ? ($categoryIdMap[$transaction['category_id']] ?? null) : null,
                'merchant_id' => isset($transaction['merchant_id']) ? ($merchantIdMap[$transaction['merchant_id']] ?? null) : null,
                'counterpart_iban' => $transaction['counterpart_iban'] ?? null,
                'import_hash' => $hash,
                'imported_at' => $transaction['imported_at'] ?? null,
            ]);

            $restored++;
        }

        Storage::disk('local')->delete($path);

        $this->form->fill();

        Notification::make()
            ->success()
            ->title('Back-up teruggezet')
            ->body("Categorieën, merchants en rekeningen zijn hersteld. {$restored} transacties teruggezet.")
            ->send();
    }
}
