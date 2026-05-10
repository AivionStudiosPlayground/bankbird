<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class YearOverview extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.year-overview';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Rapporten';
    }

    public static function getNavigationLabel(): string
    {
        return 'Jaaroverzicht';
    }

    public function getTitle(): string
    {
        return 'Jaaroverzicht';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(['year' => (string) now()->year]);
    }

    public function form(Schema $schema): Schema
    {
        $years = [];
        for ($y = now()->year; $y >= now()->year - 5; $y--) {
            $years[(string) $y] = (string) $y;
        }

        return $schema
            ->components([
                Select::make('year')
                    ->label('Jaar')
                    ->options($years)
                    ->default((string) now()->year)
                    ->live(),
            ])
            ->statePath('data');
    }

    /**
     * @return array<int, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn () => $this->downloadPdf()),
        ];
    }

    public function downloadPdf(): StreamedResponse
    {
        $report = $this->getYearData();
        $year = $report['year'];

        $start = Carbon::create($year, 1, 1)->startOfYear();
        $end = $start->copy()->endOfYear();

        $totalExpenses = $report['totalExpenses'];

        $categoryBreakdown = Transaction::where('type', 'debit')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('category_id')
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(function ($group) use ($totalExpenses) {
                $amount = $group->sum('amount');

                return [
                    'name' => $group->first()->category->name,
                    'color' => $group->first()->category->color,
                    'amount' => $amount,
                    'percentage' => $totalExpenses > 0 ? round(($amount / $totalExpenses) * 100, 1) : 0,
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('amount')
            ->values();

        $topMerchants = Transaction::where('type', 'debit')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('merchant_id')
            ->with('merchant.category')
            ->get()
            ->groupBy('merchant_id')
            ->map(fn ($group) => [
                'name' => $group->first()->merchant->name,
                'logo_url' => $group->first()->merchant->logo_url,
                'category' => $group->first()->merchant->category?->name,
                'category_color' => $group->first()->merchant->category?->color,
                'amount' => $group->sum('amount'),
                'count' => $group->count(),
            ])
            ->sortByDesc('amount')
            ->take(10)
            ->values();

        $pdf = Pdf::loadView('pdf.year-overview', [
            'report' => $report,
            'categoryBreakdown' => $categoryBreakdown,
            'topMerchants' => $topMerchants,
            'logoPath' => public_path('images/bankbird-logo.png'),
            'generatedAt' => now()->locale('nl')->translatedFormat('j F Y, H:i'),
            'version' => config('app.version'),
        ])
            ->setPaper('A4')
            ->setOption('isPhpEnabled', true);

        $filename = 'bankbird-jaaroverzicht-'.$year.'.pdf';

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf'],
        );
    }

    public function getYearData(): array
    {
        $year = (int) ($this->data['year'] ?? now()->year);
        $rows = [];
        $totalIncome = 0;
        $totalExpenses = 0;

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $income = (float) Transaction::where('type', 'credit')->whereBetween('date', [$start, $end])->sum('amount');
            $expenses = (float) Transaction::where('type', 'debit')->whereBetween('date', [$start, $end])->sum('amount');
            $net = $income - $expenses;

            $totalIncome += $income;
            $totalExpenses += $expenses;

            $rows[] = [
                'month' => $start->locale('nl')->translatedFormat('F'),
                'monthKey' => $start->format('Y-m'),
                'income' => $income,
                'expenses' => $expenses,
                'net' => $net,
            ];
        }

        return [
            'rows' => $rows,
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'totalNet' => $totalIncome - $totalExpenses,
            'year' => $year,
        ];
    }
}
