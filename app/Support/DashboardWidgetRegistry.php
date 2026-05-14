<?php

namespace App\Support;

use App\Filament\Widgets\AccountStatsOverview;
use App\Filament\Widgets\CategoryBreakdownThisMonth;
use App\Filament\Widgets\IncomeVsExpensesChart;
use App\Filament\Widgets\RecentTransactionsWidget;
use App\Filament\Widgets\RecurringExpensesWidget;
use App\Filament\Widgets\RecurringIncomeWidget;
use App\Filament\Widgets\TopMerchantsThisMonth;
use App\Filament\Widgets\WelcomeBannerWidget;

/**
 * Centrale registry van alle widgets die op het dashboard plaatsbaar
 * zijn.
 *
 * @phpstan-type WidgetSpec array{
 *     id: string,
 *     class: class-string,
 *     label: string,
 *     icon: string,
 *     description: string,
 *     defaultSpan: int,
 *     defaultOptions: array<string, mixed>,
 *     editableOptions: array<int, array<string, mixed>>,
 *     inDefaultLayout: bool,
 * }
 */
class DashboardWidgetRegistry
{
    public const SPAN_CHOICES = [1, 2, 3];

    /**
     * @return array<string, WidgetSpec>
     */
    public static function all(): array
    {
        return [
            'welcome' => [
                'id' => 'welcome',
                'class' => WelcomeBannerWidget::class,
                'label' => 'Welkomstbalk',
                'icon' => 'heroicon-o-sun',
                'description' => 'Begroeting en datum bovenaan het dashboard.',
                'defaultSpan' => 1,
                'defaultOptions' => [],
                'editableOptions' => [],
                'inDefaultLayout' => true,
            ],
            'account-stats' => [
                'id' => 'account-stats',
                'class' => AccountStatsOverview::class,
                'label' => 'Rekeningen-overzicht',
                'icon' => 'heroicon-o-banknotes',
                'description' => 'Vermogen, uitgaven en inkomsten van deze maand vs. vorige maand.',
                'defaultSpan' => 1,
                'defaultOptions' => [],
                'editableOptions' => [],
                'inDefaultLayout' => true,
            ],
            'income-vs-expenses' => [
                'id' => 'income-vs-expenses',
                'class' => IncomeVsExpensesChart::class,
                'label' => 'Inkomsten vs uitgaven',
                'icon' => 'heroicon-o-chart-bar',
                'description' => 'Maandelijkse vergelijking over een instelbaar aantal maanden.',
                'defaultSpan' => 2,
                'defaultOptions' => ['monthsRange' => 12],
                'editableOptions' => [
                    [
                        'name' => 'monthsRange',
                        'label' => 'Aantal maanden',
                        'type' => 'select',
                        'options' => [6 => '6 maanden', 12 => '12 maanden', 24 => '24 maanden'],
                        'default' => 12,
                    ],
                ],
                'inDefaultLayout' => true,
            ],
            'top-merchants' => [
                'id' => 'top-merchants',
                'class' => TopMerchantsThisMonth::class,
                'label' => 'Top merchants',
                'icon' => 'heroicon-o-building-storefront',
                'description' => 'Hoogste uitgaven per merchant in de actieve maand.',
                'defaultSpan' => 3,
                'defaultOptions' => ['maxItems' => 10],
                'editableOptions' => [
                    [
                        'name' => 'maxItems',
                        'label' => 'Maximum aantal',
                        'type' => 'number',
                        'min' => 3,
                        'max' => 25,
                        'default' => 10,
                    ],
                ],
                'inDefaultLayout' => true,
            ],
            'category-breakdown' => [
                'id' => 'category-breakdown',
                'class' => CategoryBreakdownThisMonth::class,
                'label' => 'Categorie-uitgaven',
                'icon' => 'heroicon-o-tag',
                'description' => 'Horizontaal staafdiagram per categorie voor de actieve maand.',
                'defaultSpan' => 2,
                'defaultOptions' => [],
                'editableOptions' => [],
                'inDefaultLayout' => true,
            ],
            'recurring-income' => [
                'id' => 'recurring-income',
                'class' => RecurringIncomeWidget::class,
                'label' => 'Vaste inkomsten',
                'icon' => 'heroicon-o-arrow-trending-up',
                'description' => 'Automatisch gedetecteerde terugkerende bijschrijvingen.',
                'defaultSpan' => 3,
                'defaultOptions' => ['maxItems' => 7],
                'editableOptions' => [
                    [
                        'name' => 'maxItems',
                        'label' => 'Maximum aantal',
                        'type' => 'number',
                        'min' => 3,
                        'max' => 20,
                        'default' => 7,
                    ],
                ],
                'inDefaultLayout' => true,
            ],
            'recent-transactions' => [
                'id' => 'recent-transactions',
                'class' => RecentTransactionsWidget::class,
                'label' => 'Laatste transacties',
                'icon' => 'heroicon-o-list-bullet',
                'description' => 'Meest recente transacties over alle rekeningen.',
                'defaultSpan' => 1,
                'defaultOptions' => ['maxItems' => 6],
                'editableOptions' => [
                    [
                        'name' => 'maxItems',
                        'label' => 'Maximum aantal',
                        'type' => 'number',
                        'min' => 3,
                        'max' => 20,
                        'default' => 6,
                    ],
                ],
                'inDefaultLayout' => true,
            ],
            'recurring-expenses' => [
                'id' => 'recurring-expenses',
                'class' => RecurringExpensesWidget::class,
                'label' => 'Vaste uitgaven',
                'icon' => 'heroicon-o-arrow-trending-down',
                'description' => 'Automatisch gedetecteerde terugkerende afschrijvingen.',
                'defaultSpan' => 3,
                'defaultOptions' => ['maxItems' => 7],
                'editableOptions' => [
                    [
                        'name' => 'maxItems',
                        'label' => 'Maximum aantal',
                        'type' => 'number',
                        'min' => 3,
                        'max' => 20,
                        'default' => 7,
                    ],
                ],
                'inDefaultLayout' => true,
            ],
        ];
    }

    /**
     * @return WidgetSpec|null
     */
    public static function find(string $id): ?array
    {
        return self::all()[$id] ?? null;
    }

    /**
     * Default-layout zoals een verse gebruiker hem ziet.
     *
     * Volgorde, span, zichtbaarheid en option-overrides zijn hier expliciet
     * vastgelegd; de spec-defaults in `all()` blijven van toepassing wanneer
     * een widget niet in deze layout voorkomt (dan valt-ie terug op de spec).
     *
     * @return array<int, array{id: string, hidden: bool, span: int, options: array<string, mixed>}>
     */
    public static function defaultLayout(): array
    {
        $template = [
            ['id' => 'welcome', 'hidden' => false, 'span' => 2, 'options' => []],
            ['id' => 'account-stats', 'hidden' => false, 'span' => 2, 'options' => []],
            ['id' => 'income-vs-expenses', 'hidden' => true, 'span' => 2, 'options' => ['monthsRange' => 12]],
            ['id' => 'top-merchants', 'hidden' => false, 'span' => 3, 'options' => ['maxItems' => 3]],
            ['id' => 'category-breakdown', 'hidden' => true, 'span' => 2, 'options' => []],
            ['id' => 'recurring-income', 'hidden' => false, 'span' => 3, 'options' => ['maxItems' => 7]],
            ['id' => 'recent-transactions', 'hidden' => false, 'span' => 3, 'options' => ['maxItems' => 3]],
            ['id' => 'recurring-expenses', 'hidden' => false, 'span' => 1, 'options' => ['maxItems' => 7]],
        ];

        $specs = self::all();

        return collect($template)
            ->filter(fn (array $entry) => isset($specs[$entry['id']]))
            ->map(fn (array $entry) => [
                'id' => $entry['id'],
                'hidden' => $entry['hidden'],
                'span' => $entry['span'],
                'options' => array_merge(
                    $specs[$entry['id']]['defaultOptions'] ?? [],
                    $entry['options']
                ),
            ])
            ->values()
            ->all();
    }
}
