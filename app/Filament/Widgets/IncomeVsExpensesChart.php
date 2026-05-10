<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Support\RawJs;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class IncomeVsExpensesChart extends ApexChartWidget
{
    protected static ?string $chartId = 'incomeVsExpenses';

    protected static ?string $heading = 'Inkomsten vs uitgaven (12 maanden)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public int $monthsRange = 12;

    public function getHeading(): ?string
    {
        return 'Inkomsten vs uitgaven ('.$this->monthsRange.' maanden)';
    }

    protected function getOptions(): array
    {
        $labels = [];
        $income = [];
        $expenses = [];
        $months = max(1, (int) $this->monthsRange);

        for ($i = $months - 1; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $labels[] = $month->locale('nl')->translatedFormat('M Y');
            $income[] = (float) Transaction::where('type', 'credit')
                ->whereBetween('date', [$start, $end])
                ->whereDoesntHave('category', fn ($q) => $q->where('name', 'Sparen'))
                ->sum('amount');
            $expenses[] = (float) Transaction::where('type', 'debit')
                ->whereBetween('date', [$start, $end])
                ->whereDoesntHave('category', fn ($q) => $q->where('name', 'Sparen'))
                ->sum('amount');
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 260,
                'width' => '100%',
                'toolbar' => ['show' => false],
                'fontFamily' => 'inherit',
                'animations' => ['enabled' => true, 'easing' => 'easeinout', 'speed' => 500],
            ],
            'series' => [
                ['name' => 'Inkomsten', 'data' => $income],
                ['name' => 'Uitgaven',  'data' => $expenses],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => ['rotate' => 0, 'style' => ['fontSize' => '12px']],
                'axisBorder' => ['show' => false],
                'axisTicks' => ['show' => false],
            ],
            'colors' => ['#22c55e', '#ef4444'],
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'right',
                'fontSize' => '13px',
                'markers' => ['width' => 12, 'height' => 12, 'radius' => 12],
                'itemMargin' => ['horizontal' => 12],
            ],
            'grid' => [
                'borderColor' => 'rgba(148,163,184,0.15)',
                'strokeDashArray' => 4,
                'xaxis' => ['lines' => ['show' => false]],
                'padding' => ['left' => 10, 'right' => 10],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 4,
                    'borderRadiusApplication' => 'end',
                    'columnWidth' => '78%',
                ],
            ],
            'dataLabels' => ['enabled' => false],
            'fill' => ['opacity' => 1],
            'stroke' => ['show' => true, 'width' => 2, 'colors' => ['transparent']],
            'states' => ['hover' => ['filter' => ['type' => 'lighten', 'value' => 0.05]]],
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
            {
                yaxis: {
                    labels: {
                        formatter: function(v) {
                            return v >= 1000 ? '€ ' + (v/1000).toFixed(1) + 'k' : '€ ' + v;
                        },
                        style: { fontSize: '12px' }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(v) { return '€ ' + v.toFixed(2).replace('.', ','); }
                    },
                    style: { fontSize: '13px' }
                }
            }
        JS);
    }
}
