<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasActiveMonth;
use App\Models\Transaction;
use Filament\Support\RawJs;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CategoryBreakdownThisMonth extends ApexChartWidget
{
    use HasActiveMonth;

    protected static ?string $chartId = 'categoryBreakdownThisMonth';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 2;

    public function getHeading(): ?string
    {
        return 'Uitgaven per categorie — '.$this->activeMonth()->locale('nl')->translatedFormat('F Y');
    }

    protected function getOptions(): array
    {
        $month = $this->activeMonth();
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $rows = Transaction::query()
            ->where('type', 'debit')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('category_id')
            ->whereHas('category', fn ($q) => $q->where('name', '!=', 'Sparen'))
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(fn ($group) => [
                'name' => $group->first()->category->name,
                'amount' => round($group->sum('amount'), 2),
                'color' => $group->first()->category->color,
            ])
            ->sortByDesc('amount')
            ->values();

        $height = max(220, $rows->count() * 32 + 60);

        if ($rows->isEmpty()) {
            return [
                'chart' => ['type' => 'bar', 'height' => 360, 'width' => '100%'],
                'series' => [],
                'noData' => ['text' => 'Geen uitgaven in deze maand', 'style' => ['fontSize' => '14px']],
            ];
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => $height,
                'width' => '100%',
                'toolbar' => ['show' => false],
                'fontFamily' => 'inherit',
                'animations' => ['enabled' => true, 'easing' => 'easeinout', 'speed' => 500],
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => true,
                    'borderRadius' => 4,
                    'borderRadiusApplication' => 'end',
                    'distributed' => true,
                    'barHeight' => '70%',
                    'dataLabels' => ['position' => 'top'],
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
                'textAnchor' => 'start',
                'offsetX' => 8,
                'style' => ['fontSize' => '11px', 'fontWeight' => 600, 'colors' => ['#1a2332']],
            ],
            'series' => [['name' => 'Uitgaven', 'data' => $rows->pluck('amount')->toArray()]],
            'xaxis' => [
                'categories' => $rows->pluck('name')->toArray(),
                'axisBorder' => ['show' => false],
                'axisTicks' => ['show' => false],
            ],
            'yaxis' => [
                'labels' => ['style' => ['fontSize' => '12px']],
            ],
            'colors' => $rows->pluck('color')->toArray(),
            'legend' => ['show' => false],
            'grid' => [
                'borderColor' => 'rgba(148,163,184,0.15)',
                'strokeDashArray' => 4,
                'yaxis' => ['lines' => ['show' => false]],
                'padding' => ['left' => 10, 'right' => 10],
            ],
            'fill' => ['opacity' => 1],
            'stroke' => ['show' => false],
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
            {
                dataLabels: {
                    formatter: function(v) { return '€ ' + Math.round(v); }
                },
                xaxis: {
                    labels: {
                        formatter: function(v) {
                            return v >= 1000 ? '€ ' + (v/1000).toFixed(1) + 'k' : '€ ' + v;
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(v) { return '€ ' + v.toFixed(2).replace('.', ','); }
                    }
                }
            }
        JS);
    }
}
