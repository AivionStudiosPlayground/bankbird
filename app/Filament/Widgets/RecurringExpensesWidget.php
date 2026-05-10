<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Services\RecurringTransactionDetector;
use Filament\Widgets\Widget;

class RecurringExpensesWidget extends Widget
{
    protected string $view = 'filament.widgets.recurring-transactions';

    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    public int $maxItems = 7;

    protected function getViewData(): array
    {
        $items = app(RecurringTransactionDetector::class)
            ->detect(TransactionType::Debit)
            ->take($this->maxItems);

        return [
            'heading' => 'Vaste uitgaven',
            'icon' => 'heroicon-o-arrow-trending-down',
            'amountColor' => '#D02B2B',
            'emptyMessage' => 'Nog geen terugkerende uitgaven gedetecteerd. Zodra een afschrijving in twee maanden voorkomt, verschijnt hij hier.',
            'items' => $items,
        ];
    }
}
