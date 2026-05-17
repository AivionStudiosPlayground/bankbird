<?php

namespace App\Filament\Resources\ImportResource\Pages;

use App\Enums\AccountType;
use App\Filament\Resources\ImportResource;
use App\Models\Account;
use App\Services\PdfImportService;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateImport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ImportResource::class;

    protected string $view = 'filament.resources.import-resource.pages.create-import';

    public ?array $data = [];

    /**
     * Files persisted to disk after analyze(), waiting for save().
     * Each entry: [path, name, iban (?detected), account_id (?auto or user-selected)]
     * @var array<int,array{path:string,name:string,iban:?string,account_id:?int}>
     */
    public array $persistedFiles = [];

    public bool $analyzed = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('pdf_file')
                    ->label('ING Bankafschrift(en) (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480)
                    ->multiple()
                    ->reorderable()
                    ->panelLayout('grid')
                    ->required()
                    ->helperText('Eén of meerdere ING PDF-bankafschriften (max 20 MB per bestand). Per bestand wordt de rekening gedetecteerd.'),
            ])
            ->statePath('data');
    }

    public function getAccountOptions(): array
    {
        return Account::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($a) => [$a->id => $a->name . ($a->iban ? ' — ' . $a->iban : '')])
            ->all();
    }

    public function getReadyToImportProperty(): bool
    {
        if (empty($this->persistedFiles)) {
            return false;
        }

        foreach ($this->persistedFiles as $file) {
            if (empty($file['account_id'])) {
                return false;
            }
        }

        return true;
    }

    public function createAccountAction(): Action
    {
        return Action::make('createAccount')
            ->label('Nieuwe rekening')
            ->modalHeading('Nieuwe rekening aanmaken')
            ->modalSubmitActionLabel('Aanmaken')
            ->modalWidth('md')
            ->schema([
                TextInput::make('name')
                    ->label('Naam')
                    ->required()
                    ->maxLength(100),

                Select::make('type')
                    ->label('Type')
                    ->options(AccountType::class)
                    ->required(),

                TextInput::make('iban')
                    ->label('IBAN / Rekeningnummer')
                    ->maxLength(34),

                ColorPicker::make('color')
                    ->label('Kleur')
                    ->default('#6366f1'),

                Select::make('icon')
                    ->label('Icoon')
                    ->options([
                        'banknotes' => 'Bankbiljetten',
                        'credit-card' => 'Creditcard',
                        'building-library' => 'Bank',
                        'wallet' => 'Portemonnee',
                        'currency-euro' => 'Euro',
                        'arrow-trending-up' => 'Groei',
                        'home' => 'Huis',
                    ])
                    ->default('banknotes'),

                Toggle::make('is_active')
                    ->label('Actief')
                    ->default(true),
            ])
            ->action(function (array $arguments, array $data): void {
                $account = Account::create($data);
                $index = $arguments['index'] ?? null;

                if ($index !== null && array_key_exists($index, $this->persistedFiles)) {
                    $this->persistedFiles[$index]['account_id'] = $account->id;
                }

                Notification::make()
                    ->success()
                    ->title('Rekening aangemaakt')
                    ->body("{$account->name} is geselecteerd voor deze import.")
                    ->send();
            });
    }

    public function analyze(): void
    {
        $raw = $this->data['pdf_file'] ?? null;

        if (! $raw) {
            Notification::make()->danger()->title('Geen bestand geselecteerd')->send();
            return;
        }

        $rawFiles = is_array($raw) ? array_values($raw) : [$raw];

        $pendingDir = storage_path('app/imports-pending');
        if (! is_dir($pendingDir)) {
            mkdir($pendingDir, 0755, true);
        }

        // Pre-fetch all IBAN→account_id mappings.
        // get() is required so the encrypted cast decrypts IBANs before building the lookup map.
        $accountByIban = Account::where('is_active', true)
            ->whereNotNull('iban')
            ->get()
            ->pluck('id', 'iban')
            ->all();

        $service        = app(PdfImportService::class);
        $persistedFiles = [];

        foreach ($rawFiles as $rawFile) {
            $tempPath     = null;
            $originalName = null;

            if ($rawFile instanceof TemporaryUploadedFile) {
                $tempPath     = $rawFile->getRealPath();
                $originalName = $rawFile->getClientOriginalName();
            } elseif (is_string($rawFile)) {
                $candidate = storage_path('app/livewire-tmp/' . basename($rawFile));
                if (file_exists($candidate)) {
                    $tempPath = $candidate;
                } elseif (file_exists(storage_path('app/' . $rawFile))) {
                    $tempPath = storage_path('app/' . $rawFile);
                }
                $originalName = basename($rawFile);
            }

            if (! $tempPath || ! file_exists($tempPath)) {
                continue;
            }

            $persistedPath = $pendingDir . DIRECTORY_SEPARATOR . Str::uuid()->toString() . '.pdf';
            copy($tempPath, $persistedPath);

            $iban = $service->detectAccountIban($persistedPath);

            $persistedFiles[] = [
                'path'       => $persistedPath,
                'name'       => $originalName ?? basename($persistedPath),
                'iban'       => $iban,
                'account_id' => $iban ? ($accountByIban[$iban] ?? null) : null,
            ];
        }

        if (empty($persistedFiles)) {
            $this->data['pdf_file'] = null;
            $this->resetErrorBag();

            Notification::make()
                ->danger()
                ->title('Upload verlopen')
                ->body('Geen geldige bestanden gevonden — selecteer opnieuw.')
                ->send();
            return;
        }

        $this->persistedFiles = $persistedFiles;
        $this->analyzed       = true;
    }

    public function save(): void
    {
        if (! $this->ready_to_import) {
            Notification::make()
                ->danger()
                ->title('Niet alle bestanden zijn aan een rekening gekoppeld')
                ->send();
            return;
        }

        $service = app(PdfImportService::class);

        $totalNew        = 0;
        $totalDuplicates = 0;
        $imports         = [];
        $failures        = [];

        foreach ($this->persistedFiles as $file) {
            if (! file_exists($file['path'])) {
                $failures[] = $file['name'] . ' (niet gevonden)';
                continue;
            }

            try {
                $account = Account::findOrFail($file['account_id']);

                $uploaded = new UploadedFile(
                    $file['path'],
                    $file['name'],
                    'application/pdf',
                    null,
                    true
                );

                $import = $service->handle($uploaded, $account, $file['name']);

                @unlink($file['path']);

                $imports[]        = $import;
                $totalNew        += $import->new;
                $totalDuplicates += $import->duplicates;
            } catch (\Exception $e) {
                $failures[] = $file['name'] . ' — ' . $e->getMessage();
            }
        }

        $count = count($imports);

        if ($count === 0) {
            Notification::make()
                ->danger()
                ->title('Import mislukt')
                ->body(implode("\n", $failures) ?: 'Onbekende fout.')
                ->send();
            return;
        }

        $body = "{$totalNew} nieuwe transacties geïmporteerd in {$count} bestand(en). {$totalDuplicates} dubbelen overgeslagen.";
        if (! empty($failures)) {
            $body .= "\nFouten: " . implode('; ', $failures);
        }

        Notification::make()
            ->success()
            ->title('Import voltooid')
            ->body($body)
            ->send();

        $this->reset(['persistedFiles', 'analyzed', 'data']);
        $this->form->fill();

        if ($count === 1) {
            $this->redirect(ViewImport::getUrl(['record' => $imports[0]->id]));
        } else {
            $this->redirect(ListImports::getUrl());
        }
    }

    public function getTitle(): string
    {
        return 'PDF importeren';
    }
}
