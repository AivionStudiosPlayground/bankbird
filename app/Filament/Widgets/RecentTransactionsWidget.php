<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Laatste transacties';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    public int $maxItems = 6;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->orderByDesc('date')
                    ->orderByDesc('id')
                    ->limit($this->maxItems)
            )
            ->columns([
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y'),

                ImageColumn::make('merchant.logo_url')
                    ->label('')
                    ->disk(null)
                    ->imageHeight(20)
                    ->square()
                    ->extraImgAttributes(['class' => 'object-contain'])
                    ->grow(false),

                TextColumn::make('description')
                    ->label('Omschrijving')
                    ->limit(40),

                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('—'),

                TextColumn::make('amount')
                    ->label('Bedrag')
                    ->money('EUR')
                    ->color(fn (Transaction $record): string => $record->type === TransactionType::Debit ? 'danger' : 'success')
                    ->alignEnd()
                    ->weight('semibold'),
            ])
            ->paginated(false);
    }
}
