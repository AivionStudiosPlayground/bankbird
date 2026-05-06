<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\RestrictsInDemoMode;
use App\Filament\Resources\ImportResource\Pages;
use App\Models\Import;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
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
            ->emptyStateIcon('heroicon-o-arrow-up-tray')
            ->emptyStateHeading('Nog geen imports')
            ->emptyStateDescription('Importeer je eerste bankafschrift in PDF-formaat om transacties toe te voegen.')
            ->defaultSort('created_at', 'desc');
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
