<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\ImportResource\Pages;
use App\Models\Account;
use App\Models\Import;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImportResource extends Resource
{
    use RestrictsInDemoMode;

    protected static ?string $model = Import::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-arrow-up-tray';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Financiën';
    }

    public static function getModelLabel(): string
    {
        return 'Import';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Imports';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Datum')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),

                ImageColumn::make('account.bank_logo_url')
                    ->label('Bank')
                    ->disk(null)
                    ->imageHeight(28)
                    ->square()
                    ->extraImgAttributes(fn (Import $record): array => [
                        'class' => 'object-contain',
                        'title' => $record->account?->bank_name ?? '—',
                    ]),

                TextColumn::make('account.name')
                    ->label('Rekening')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('filename')
                    ->label('Bestandsnaam')
                    ->limit(40),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('total')
                    ->label('Totaal'),

                TextColumn::make('new')
                    ->label('Nieuw')
                    ->color('success'),

                TextColumn::make('duplicates')
                    ->label('Dubbel')
                    ->color('gray'),
            ])
            ->recordActions([
                self::deleteAction(),
            ])
            ->emptyStateIcon('heroicon-o-arrow-up-tray')
            ->emptyStateHeading('Nog geen imports')
            ->emptyStateDescription('Importeer je eerste bankafschrift in PDF-formaat om transacties toe te voegen.')
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Verwijder-actie met keuze: alleen de import-registratie weg
     * (transacties behouden, import_id losgekoppeld) of inclusief alle
     * gekoppelde transacties (incl. saldo-herberekening).
     *
     * @param  string|null  $redirectUrl  Bij gebruik op een detail-pagina: waar
     *                                    naartoe redirecten na delete. Op een
     *                                    table-row laat je dit null (Livewire
     *                                    refresht de tabel automatisch).
     */
    public static function deleteAction(?string $redirectUrl = null): Action
    {
        return Action::make('deleteImport')
            ->label('Verwijderen')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->modalIconColor('danger')
            ->modalHeading('Import verwijderen')
            ->modalDescription(fn (Import $record): string => "Hoe wil je de import \"{$record->filename}\" verwijderen?")
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Annuleren')
            ->extraModalFooterActions(fn (Action $action) => [
                Action::make('deleteImportOnly')
                    ->label('Alleen import (transacties behouden)')
                    ->color('warning')
                    ->icon('heroicon-o-document-minus')
                    ->action(function (array $mountedActions) use ($redirectUrl) {
                        /** @var Import $record */
                        $record = $mountedActions[0]->getRecord();

                        $record->transactions()->update(['import_id' => null]);
                        $record->delete();

                        Notification::make()
                            ->success()
                            ->title('Import verwijderd')
                            ->body('Transacties zijn behouden.')
                            ->send();

                        if ($redirectUrl) {
                            return redirect($redirectUrl);
                        }
                    })
                    ->cancelParentActions(),

                Action::make('deleteImportAndTransactions')
                    ->label('Inclusief alle transacties')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Definitief verwijderen?')
                    ->modalDescription('Het bestand én alle gekoppelde transacties worden definitief verwijderd. Het saldo van de rekening wordt opnieuw berekend.')
                    ->modalSubmitActionLabel('Ja, alles verwijderen')
                    ->action(function (array $mountedActions) use ($redirectUrl) {
                        /** @var Import $record */
                        $record = $mountedActions[0]->getRecord();

                        $accountId = $record->account_id;
                        $count = $record->transactions()->count();

                        $record->transactions()->delete();
                        $record->delete();

                        if ($accountId) {
                            Account::recalculateBalance($accountId);
                        }

                        Notification::make()
                            ->success()
                            ->title("Import + {$count} transacties verwijderd")
                            ->body('Saldo is opnieuw berekend.')
                            ->send();

                        if ($redirectUrl) {
                            return redirect($redirectUrl);
                        }
                    })
                    ->cancelParentActions(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImports::route('/'),
            'create' => Pages\CreateImport::route('/create'),
            'view' => Pages\ViewImport::route('/{record}'),
        ];
    }
}
