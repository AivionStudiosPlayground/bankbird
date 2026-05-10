<?php

namespace App\Filament\Resources;

use App\Enums\AccountType;
use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    use RestrictsInDemoMode;

    protected static ?string $model = Account::class;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'iban'];
    }

    /**
     * @param  Account  $record
     * @return array<string, string>
     */
    public static function getGlobalSearchResultDetails($record): array
    {
        return array_filter([
            'IBAN' => $record->iban,
            'Saldo' => '€ '.number_format((float) $record->balance, 2, ',', '.'),
        ]);
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-banknotes';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Financiën';
    }

    public static function getModelLabel(): string
    {
        return 'Rekening';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Rekeningen';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label(''),

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge(),

                ImageColumn::make('bank_logo_url')
                    ->label('Bank')
                    ->disk(null)
                    ->imageHeight(28)
                    ->square()
                    ->extraImgAttributes(fn (Account $record): array => [
                        'class' => 'object-contain',
                        'title' => $record->bank_name ?? '—',
                    ]),

                TextColumn::make('iban')
                    ->label('IBAN')
                    ->fontFamily('mono')
                    ->copyable(),

                TextColumn::make('balance')
                    ->label('Saldo')
                    ->money('EUR')
                    ->color(fn (Account $record): string => $record->balance >= 0 ? 'success' : 'danger')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Actief')
                    ->boolean(),
            ])
            ->emptyStateIcon('heroicon-o-banknotes')
            ->emptyStateHeading('Nog geen rekeningen')
            ->emptyStateDescription('Voeg je eerste bankrekening toe om te beginnen met bijhouden.')
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
