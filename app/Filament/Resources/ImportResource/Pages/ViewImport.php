<?php

namespace App\Filament\Resources\ImportResource\Pages;

use App\Enums\TransactionType;
use App\Filament\Resources\ImportResource;
use App\Models\Import;
use App\Models\Transaction;
use App\Services\AiCategorizationService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Locked;

class ViewImport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ImportResource::class;

    protected string $view = 'filament.resources.import-resource.pages.view-import';

    #[Locked]
    public ?int $recordId = null;

    public function mount(int|string $record): void
    {
        $this->recordId = (int) $record;
    }

    public function getRecord(): Import
    {
        return Import::findOrFail($this->recordId);
    }

    public function table(Table $table): Table
    {
        $record = $this->getRecord();

        return $table
            ->query(Transaction::query()->where('import_id', $record->id))
            ->columns([
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Omschrijving')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge(),

                TextColumn::make('amount')
                    ->label('Bedrag')
                    ->money('EUR')
                    ->color(fn (Transaction $record): string => $record->type === TransactionType::Debit ? 'danger' : 'success'),

                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('—'),
            ])
            ->defaultSort('date', 'desc');
    }

    protected function getHeaderActions(): array
    {
        $aiService = app(AiCategorizationService::class);

        return [
            Action::make('categorize')
                ->label('AI Categoriseren')
                ->icon('heroicon-o-sparkles')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('AI categorisatie starten')
                ->modalDescription(
                    'Alle ongecategoriseerde transacties van deze import worden automatisch gecategoriseerd. '
                    .'Uw transactiegegevens worden verstuurd naar externe servers (Anthropic of OpenAI).'
                )
                ->visible($aiService->isEnabled())
                ->action(function () {
                    try {
                        app(AiCategorizationService::class)->categorizeImport($this->getRecord());

                        Notification::make()
                            ->success()
                            ->title('Categorisatie voltooid')
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('Categorisatie mislukt')
                            ->body($e->getMessage())
                            ->send();
                    }

                    $this->resetTable();
                }),

            ImportResource::deleteAction(ListImports::getUrl())
                ->record($this->getRecord()),

            Action::make('back')
                ->label('Terug naar overzicht')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ListImports::getUrl()),
        ];
    }

    public function getTitle(): string
    {
        return "Import: {$this->getRecord()->filename}";
    }
}
