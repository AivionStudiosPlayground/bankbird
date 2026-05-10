<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasActiveMonth;
use App\Models\Merchant;
use App\Models\Transaction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopMerchantsThisMonth extends BaseWidget
{
    use HasActiveMonth;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public int $maxItems = 10;

    public function getHeading(): string
    {
        return 'Top merchants — '.$this->activeMonth()->locale('nl')->translatedFormat('F Y');
    }

    public function table(Table $table): Table
    {
        $month = $this->activeMonth();
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $stats = Transaction::query()
            ->selectRaw('merchant_id, SUM(amount) as total_amount, COUNT(*) as tx_count')
            ->where('type', 'debit')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('merchant_id')
            ->whereHas('category', fn ($q) => $q->where('name', '!=', 'Sparen'))
            ->groupBy('merchant_id');

        return $table
            ->query(
                Merchant::query()
                    ->joinSub($stats, 'merchant_stats', fn ($join) => $join->on('merchants.id', '=', 'merchant_stats.merchant_id'))
                    ->select('merchants.*', 'merchant_stats.total_amount', 'merchant_stats.tx_count')
                    ->orderByDesc('merchant_stats.total_amount')
                    ->limit($this->maxItems)
            )
            ->columns([
                ImageColumn::make('logo_url')
                    ->label('')
                    ->disk(null)
                    ->imageHeight(24)
                    ->square()
                    ->extraImgAttributes(['class' => 'object-contain'])
                    ->grow(false),

                TextColumn::make('name')
                    ->label('Merchant')
                    ->weight('semibold'),

                TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('—'),

                TextColumn::make('tx_count')
                    ->label('#')
                    ->alignEnd(),

                TextColumn::make('total_amount')
                    ->label('Totaal')
                    ->money('EUR')
                    ->color('danger')
                    ->alignEnd()
                    ->weight('semibold'),
            ])
            ->paginated(false);
    }
}
