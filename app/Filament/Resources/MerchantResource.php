<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Concerns\WithCompactGlobalSearch;
use App\Filament\Resources\MerchantResource\Pages;
use App\Models\Merchant;
use App\Services\MerchantPatternService;
use App\Support\Demo;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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
    use WithCompactGlobalSearch;

    protected static ?string $model = Merchant::class;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'normalized_name'];
    }

    /**
     * @param  Merchant  $record
     * @return array<string, string>
     */
    public static function getGlobalSearchResultDetails($record): array
    {
        return array_filter([
            'Categorie' => $record->category?->name,
        ]);
    }

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
                ->maxLength(500)
                ->nullable()
                ->placeholder('https://logo.clearbit.com/example.com')
                ->helperText('Externe URL of relatief pad. Wordt overschreven door een upload hieronder.'),

            FileUpload::make('logo_upload')
                ->label('Logo uploaden')
                ->image()
                ->disk('public')
                ->directory('merchants')
                ->maxSize(2048)
                ->imagePreviewHeight('80')
                ->dehydrated(false)
                ->helperText('Optioneel — upload een eigen logo (PNG, JPG, SVG, max 2 MB). Heeft voorrang op de URL hierboven.'),

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
                    ->disk(null)
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
                    ->formatStateUsing(function ($state): string {
                        if (! $state) {
                            return '—';
                        }
                        $arr = is_array($state) ? $state : (json_decode($state, true) ?? []);

                        return $arr ? implode(', ', $arr) : '—';
                    })
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
                        if (Demo::active()) {
                            Notification::make()->warning()->title('Demo-modus')->body('Synchroniseren is uitgeschakeld in de demo.')->send();

                            return;
                        }

                        $count = app(MerchantPatternService::class)->syncMerchant($record);

                        Notification::make()
                            ->success()
                            ->title("{$count} transactie(s) gesynchroniseerd")
                            ->send();
                    }),
            ])
            ->emptyStateIcon('heroicon-o-building-storefront')
            ->emptyStateHeading('Nog geen merchants')
            ->emptyStateDescription('Merchants worden automatisch aangemaakt bij het importeren van afschriften, of voeg er handmatig één toe.')
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }

    public static function globalSearchSeeMoreUrl(string $search): string
    {
        return Pages\ListMerchants::getUrl().'?search='.rawurlencode($search);
    }

    /**
     * Wanneer een logo-upload is gedaan, gebruik dat pad als logo_url.
     * Anders blijft de handmatig ingevulde URL behouden.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function resolveLogoSource(array $data): array
    {
        $upload = $data['logo_upload'] ?? null;
        unset($data['logo_upload']);

        if (is_array($upload)) {
            $upload = reset($upload) ?: null;
        }

        if (is_string($upload) && $upload !== '') {
            $data['logo_url'] = 'storage/'.ltrim($upload, '/');
        }

        return $data;
    }
}
