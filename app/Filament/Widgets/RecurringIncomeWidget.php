<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Services\RecurringTransactionDetector;
use Filament\Widgets\Widget;

class RecurringIncomeWidget extends Widget
{
    protected string $view = 'filament.widgets.recurring-transactions';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public int $maxItems = 7;

    protected function getViewData(): array
    {
        $items = app(RecurringTransactionDetector::class)
            ->detect(TransactionType::Credit)
            ->take($this->maxItems);

        return [
            'heading' => 'Vaste inkomsten',
            'icon' => 'heroicon-o-arrow-trending-up',
            'amountColor' => '#0A9660',
            'emptyMessage' => 'Nog geen terugkerend inkomen gedetecteerd. Zodra een bron in twee maanden voorkomt, verschijnt hij hier.',
            'items' => $items,
        ];
    }
}
