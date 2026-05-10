<?php

namespace App\Filament\Resources;

use App\Enums\TransactionType;
use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Category;
use App\Models\Transaction;
use App\Services\AiCategorizationService;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionResource extends Resource
{
    use RestrictsInDemoMode;

    protected static ?string $model = Transaction::class;

    protected static ?string $recordTitleAttribute = 'description';

    /**
     * @return array<int, string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['description', 'raw_description', 'counterpart_iban'];
    }

    /**
     * @param  Transaction  $record
     * @return array<string, string>
     */
    public static function getGlobalSearchResultDetails($record): array
    {
        $sign = $record->type === TransactionType::Credit ? '+' : '-';

        return array_filter([
            'Datum' => optional($record->date)->format('d-m-Y'),
            'Bedrag' => $sign.' € '.number_format((float) $record->amount, 2, ',', '.'),
            'Categorie' => $record->category?->name,
        ]);
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-list-bullet';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Financiën';
    }

    public static function getModelLabel(): string
    {
        return 'Transactie';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Transacties';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date')
                ->label('Datum')
                ->required()
                ->displayFormat('d-m-Y'),

            TextInput::make('description')
                ->label('Omschrijving')
                ->required()
                ->maxLength(500),

            TextInput::make('amount')
                ->label('Bedrag')
                ->numeric()
                ->prefix('€')
                ->required()
                ->minValue(0),

            Select::make('type')
                ->label('Type')
                ->options(TransactionType::class)
                ->required(),

            Select::make('account_id')
                ->label('Rekening')
                ->relationship('account', 'name')
                ->required()
                ->searchable()
                ->preload(),

            Select::make('category_id')
                ->label('Categorie')
                ->relationship('category', 'name')
                ->getOptionLabelFromRecordUsing(fn (Category $record) => $record->name)
                ->options(function () {
                    return Category::with('parent')
                        ->get()
                        ->groupBy(fn ($c) => $c->parent?->name ?? 'Hoofdcategorieën')
                        ->map(fn ($group) => $group->pluck('name', 'id'))
                        ->toArray();
                })
                ->nullable()
                ->searchable()
                ->preload(),

            Select::make('merchant_id')
                ->label('Merchant')
                ->relationship('merchant', 'name')
                ->nullable()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y')
                    ->sortable(),

                ImageColumn::make('account.bank_logo_url')
                    ->label('Bank')
                    ->disk(null)
                    ->imageHeight(24)
                    ->square()
                    ->extraImgAttributes(fn (Transaction $record): array => [
                        'class' => 'object-contain',
                        'title' => $record->account?->bank_name ?? '—',
                    ]),

                TextColumn::make('account.name')
                    ->label('Rekening')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('description')
                    ->label('Omschrijving')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                ImageColumn::make('merchant.logo_url')
                    ->label('')
                    ->imageHeight(24)
                    ->square()
                    ->extraImgAttributes(['class' => 'object-contain'])
                    ->grow(false)
                    ->toggleable(),

                TextColumn::make('merchant.name')
                    ->label('Merchant')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('—'),

                TextColumn::make('amount')
                    ->label('Bedrag')
                    ->money('EUR')
                    ->color(fn (Transaction $record): string => $record->type === TransactionType::Debit ? 'danger' : 'success')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('account_id')
                    ->label('Rekening')
                    ->relationship('account', 'name'),

                SelectFilter::make('category_id')
                    ->label('Categorie')
                    ->relationship('category', 'name'),

                SelectFilter::make('type')
                    ->label('Type')
                    ->options(TransactionType::class),

                SelectFilter::make('merchant_id')
                    ->label('Merchant')
                    ->relationship('merchant', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('counterpart_iban')
                    ->label('Tegenrekening')
                    ->form([
                        TextInput::make('counterpart_iban')->label('IBAN'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['counterpart_iban'] ?? null,
                        fn ($q, $v) => $q->where('counterpart_iban', $v)
                    )),

                Filter::make('date_range')
                    ->label('Datumbereik')
                    ->form([
                        DatePicker::make('from')->label('Van')->displayFormat('d-m-Y'),
                        DatePicker::make('until')->label('Tot en met')->displayFormat('d-m-Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $v) => $q->whereDate('date', '>=', $v))
                            ->when($data['until'], fn ($q, $v) => $q->whereDate('date', '<=', $v));
                    }),

                Filter::make('uncategorized')
                    ->label('Ongecategoriseerd')
                    ->query(fn (Builder $query): Builder => $query->whereNull('category_id'))
                    ->toggle(),
            ])
            ->actions([
                EditAction::make()->icon('heroicon-o-pencil'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('ai_categorize')
                        ->label('AI categoriseren')
                        ->icon('heroicon-o-sparkles')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('AI categorisatie starten')
                        ->modalDescription('Geselecteerde transacties worden gecategoriseerd via de geconfigureerde AI-provider. Uw transactiegegevens worden verstuurd naar externe servers (Anthropic of OpenAI).')
                        ->visible(fn () => app(AiCategorizationService::class)->isEnabled())
                        ->action(function (Collection $records) {
                            try {
                                app(AiCategorizationService::class)->categorizeTransactions($records);

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
                        }),

                    BulkAction::make('export_csv')
                        ->label('Exporteren naar CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('gray')
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');
                                fputcsv($handle, ['Datum', 'Rekening', 'Omschrijving', 'Merchant', 'Categorie', 'Bedrag', 'Type'], ';');
                                foreach ($records as $t) {
                                    fputcsv($handle, [
                                        $t->date->format('d-m-Y'),
                                        $t->account->name ?? '',
                                        $t->description,
                                        $t->merchant?->name ?? '',
                                        $t->category?->name ?? '',
                                        number_format((float) $t->amount, 2, ',', '.'),
                                        $t->type->getLabel(),
                                    ], ';');
                                }
                                fclose($handle);
                            }, 'transacties-'.now()->format('Y-m-d').'.csv', [
                                'Content-Type' => 'text/csv; charset=UTF-8',
                            ]);
                        }),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-list-bullet')
            ->emptyStateHeading('Geen transacties gevonden')
            ->emptyStateDescription('Importeer een bankafschrift of pas de filters aan.')
            ->defaultSort('date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
