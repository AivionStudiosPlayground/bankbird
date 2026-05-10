<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    use RestrictsInDemoMode;

    protected static ?string $model = Category::class;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<int, string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-tag';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Beheer';
    }

    public static function getModelLabel(): string
    {
        return 'Categorie';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Categorieën';
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

            Select::make('parent_id')
                ->label('Hoofdcategorie')
                ->helperText('Optioneel: groepeer deze categorie onder een bovenliggende categorie (bv. "Supermarkt" onder "Eten & Drinken").')
                ->relationship(
                    'parent',
                    'name',
                    fn ($query, ?Category $record) => $query
                        ->whereNull('parent_id')
                        ->when($record, fn ($q) => $q->whereKeyNot($record->getKey()))
                )
                ->nullable()
                ->searchable(),

            Select::make('icon')
                ->label('Icoon')
                ->options([
                    'shopping-cart' => 'Winkelwagen',
                    'fire' => 'Vuur',
                    'truck' => 'Vrachtwagen',
                    'home' => 'Huis',
                    'device-phone-mobile' => 'Telefoon',
                    'scissors' => 'Schaar',
                    'heart' => 'Hart',
                    'musical-note' => 'Muziek',
                    'arrow-trending-up' => 'Groei',
                    'archive-box' => 'Archief',
                    'ellipsis-horizontal' => 'Overig',
                    'tag' => 'Label',
                    'banknotes' => 'Bankbiljetten',
                    'building-storefront' => 'Winkel',
                ])
                ->default('tag'),

            ColorPicker::make('color')
                ->label('Kleur')
                ->default('#94a3b8'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label(''),

                IconColumn::make('icon')
                    ->label('Icoon')
                    ->icon(fn (Category $record): string => 'heroicon-o-'.($record->icon ?: 'tag')),

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Category $record) => Pages\ViewCategory::getUrl(['record' => $record])),

                TextColumn::make('parent.name')
                    ->label('Hoofdcategorie')
                    ->placeholder('—'),

                TextColumn::make('transactions_count')
                    ->label('Transacties')
                    ->counts('transactions')
                    ->sortable(),
            ])
            ->emptyStateIcon('heroicon-o-tag')
            ->emptyStateHeading('Nog geen categorieën')
            ->emptyStateDescription('Maak categorieën aan om je uitgaven overzichtelijk in te delen.')
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
