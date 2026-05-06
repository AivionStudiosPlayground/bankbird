<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\MerchantResource\Pages;
use App\Models\Merchant;
use App\Services\MerchantPatternService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MerchantResource extends Resource
{
    use RestrictsInDemoMode;

    protected static ?string $model = Merchant::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-building-storefront';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Beheer';
    }

    public static function getModelLabel(): string
    {
        return 'Merchant';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Merchants';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Naam')
                ->required()
                ->maxLength(200),

            TextInput::make('normalized_name')
                ->label('Genormaliseerde naam')
                ->maxLength(200)
                ->disabled()
                ->dehydrated(false)
                ->helperText('Automatisch gegenereerd door de import — alleen ter referentie.'),

            Select::make('category_id')
                ->label('Categorie')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            TextInput::make('logo_url')
                ->label('Logo URL')
                ->url()
                ->maxLength(500)
                ->nullable()
                ->placeholder('https://logo.clearbit.com/example.com')
                ->helperText('Automatisch ingevuld via php artisan merchants:fetch-logos'),

            TagsInput::make('match_patterns')
                ->label('Matchpatronen')
                ->placeholder('Voeg patroon toe...')
                ->helperText('Woorden of zinsdelen die voorkomen in transactieomschrijvingen van deze merchant. Niet hoofdlettergevoelig. Na opslaan worden alle transacties automatisch gesynchroniseerd.')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->imageHeight(28)
                    ->square()
                    ->extraImgAttributes(['class' => 'object-contain']),

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('normalized_name')
                    ->label('Genormaliseerd')
                    ->fontFamily('mono')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->color(fn (Merchant $record) => $record->category ? 'primary' : 'gray')
                    ->placeholder('Niet ingesteld'),

                TextColumn::make('match_patterns')
                    ->label('Patronen')
                    ->formatStateUsing(fn (?array $state) => $state ? implode(', ', $state) : '—')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('transactions_count')
                    ->label('Transacties')
                    ->counts('transactions')
                    ->sortable(),
            ])
            ->actions([
                Action::make('sync')
                    ->label('Synchroniseren')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->action(function (Merchant $record) {
                        $count = app(MerchantPatternService::class)->syncMerchant($record);

                        Notification::make()
                            ->success()
                            ->title("{$count} transactie(s) gesynchroniseerd")
                            ->send();
                    }),
            ])
            ->emptyStateIcon('heroicon-o-building-storefront')
            ->emptyStateHeading('Nog geen merchants')
            ->emptyStateDescription('Merchants worden automatisch aangemaakt bij het importeren van afschriften.')
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchants::route('/'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }
}
