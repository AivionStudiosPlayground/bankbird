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
use Livewire\Attributes\Url;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MonthlyReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.monthly-report';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-calendar';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Rapporten';
    }

    public static function getNavigationLabel(): string
    {
        return 'Maandrapport';
    }

    public function getTitle(): string
    {
        return 'Maandrapport';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public ?array $data = [];

    #[Url]
    public string $month = '';

    public function mount(): void
    {
        $this->form->fill([
            'month' => $this->month ?: now()->format('Y-m'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        $months = [];
        for ($i = 0; $i < 24; $i++) {
            $date = now()->subMonths($i);
            $months[$date->format('Y-m')] = $date->locale('nl')->translatedFormat('F Y');
        }

        return $schema
            ->components([
                Select::make('month')
                    ->label('Maand')
                    ->options($months)
                    ->default(now()->format('Y-m'))
                    ->live(),
            ])
            ->statePath('data');
    }

    public function getReportData(): array
    {
        $monthKey = $this->data['month'] ?? now()->format('Y-m');
        $start = Carbon::parse($monthKey.'-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $totalIncome = Transaction::where('type', 'credit')->whereBetween('date', [$start, $end])->sum('amount');
        $totalExpenses = Transaction::where('type', 'debit')->whereBetween('date', [$start, $end])->sum('amount');
        $net = $totalIncome - $totalExpenses;

        $categoryBreakdown = Transaction::where('type', 'debit')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('category_id')
            ->with('category')
            ->get()
            ->groupBy('category_id')
            ->map(function ($group) use ($totalExpenses) {
                $amount = $group->sum('amount');

                return [
                    'id' => $group->first()->category->id,
                    'name' => $group->first()->category->name,
                    'color' => $group->first()->category->color,
                    'amount' => $amount,
                    'percentage' => $totalExpenses > 0 ? round(($amount / $totalExpenses) * 100, 1) : 0,
                    'count' => $group->count(),
                ];
            })
            ->sortByDesc('amount')
            ->values();

        return compact('totalIncome', 'totalExpenses', 'net', 'categoryBreakdown', 'start', 'end');
    }

    public function goToCategory(int $id): void
    {
        $month = $this->data['month'] ?? now()->format('Y-m');
        $url = CategoryMerchants::getUrl().'?'.http_build_query(['categoryId' => $id, 'month' => $month]);

        $this->redirect($url, navigate: true);
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
        $report = $this->getReportData();

        $monthLabel = $report['start']->locale('nl')->translatedFormat('F Y');
        $filename = 'bankbird-maandrapport-'.$report['start']->format('Y-m').'.pdf';

        $topMerchants = Transaction::where('type', 'debit')
            ->whereBetween('date', [$report['start'], $report['end']])
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

        $pdf = Pdf::loadView('pdf.monthly-report', [
            'report' => $report,
            'monthLabel' => $monthLabel,
            'topMerchants' => $topMerchants,
            'logoPath' => public_path('images/bankbird-logo.png'),
            'generatedAt' => now()->locale('nl')->translatedFormat('j F Y, H:i'),
            'version' => config('app.version'),
        ])
            ->setPaper('A4')
            ->setOption('isPhpEnabled', true);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf'],
        );
    }
}
