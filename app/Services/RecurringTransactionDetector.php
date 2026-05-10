<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class RecurringTransactionDetector
{
    /**
     * Een patroon kwalificeert als terugkerend wanneer er in het detectie-
     * venster ten minste twee verschillende kalendermaanden een transactie
     * was, EN de laatste transactie binnen het inactiviteits-venster valt
     * (anders geldt het patroon als uitgevallen).
     */
    private const DETECTION_WINDOW_DAYS = 95;   // ~3 maanden + buffer

    private const INACTIVITY_DAYS = 30;

    private const MINIMUM_DISTINCT_MONTHS = 2;

    /**
     * Detecteer terugkerende transacties.
     *
     * @return Collection<int, array{
     *     key: string,
     *     type: 'income'|'expense',
     *     name: string,
     *     subtitle: ?string,
     *     logo_url: ?string,
     *     average_amount: float,
     *     last_amount: float,
     *     occurrences: int,
     *     day_of_month: int,
     *     last_date: Carbon,
     *     filter_url: ?string,
     *     merchant_id: ?int,
     *     counterpart_iban: ?string,
     * }>
     */
    public function detect(?TransactionType $type = null): Collection
    {
        $start = Carbon::now()->subDays(self::DETECTION_WINDOW_DAYS)->startOfDay();
        $inactivityCutoff = Carbon::now()->subDays(self::INACTIVITY_DAYS)->startOfDay();

        $query = Transaction::query()
            ->whereBetween('date', [$start, Carbon::now()->endOfDay()])
            ->with(['merchant.category']);

        if ($type !== null) {
            $query->where('type', $type);
        }

        $transactions = $query->get();

        // Groeperen: bij voorkeur op merchant; anders op counterpart_iban;
        // anders op een hash van de description (laatste redmiddel voor
        // posten als "Huur woning" zonder IBAN of merchant).
        $groups = $transactions->groupBy(function (Transaction $tx) {
            if ($tx->merchant_id) {
                return 'merchant:'.$tx->merchant_id;
            }

            if ($tx->counterpart_iban) {
                return 'iban:'.$tx->counterpart_iban;
            }

            return 'description:'.md5(mb_strtolower((string) $tx->description));
        });

        return $groups
            ->map(fn (Collection $group, string $key) => $this->summarise($group, $key, $inactivityCutoff))
            ->filter()
            ->sortByDesc('average_amount')
            ->values();
    }

    /**
     * @return array<string, mixed>|null
     */
    private function summarise(Collection $group, string $key, Carbon $inactivityCutoff): ?array
    {
        $distinctMonths = $group
            ->map(fn (Transaction $tx) => Carbon::parse($tx->date)->format('Y-m'))
            ->unique();

        if ($distinctMonths->count() < self::MINIMUM_DISTINCT_MONTHS) {
            return null;
        }

        /** @var Transaction $last */
        $last = $group->sortByDesc('date')->first();

        if (Carbon::parse($last->date)->lt($inactivityCutoff)) {
            return null;
        }

        $type = $last->type === TransactionType::Credit ? 'income' : 'expense';

        return [
            'key' => $key,
            'type' => $type,
            'name' => $this->resolveName($last),
            'subtitle' => $this->resolveSubtitle($last),
            'logo_url' => $last->merchant?->logo_url,
            'average_amount' => round((float) $group->avg('amount'), 2),
            'last_amount' => (float) $last->amount,
            'occurrences' => $group->count(),
            'day_of_month' => $this->dominantDayOfMonth($group),
            'last_date' => Carbon::parse($last->date),
            'filter_url' => $this->buildFilterUrl($last),
            'merchant_id' => $last->merchant_id,
            'counterpart_iban' => $last->counterpart_iban,
        ];
    }

    private function resolveName(Transaction $tx): string
    {
        return $tx->merchant?->name
            ?? $tx->description
            ?: 'Onbekende post';
    }

    private function resolveSubtitle(Transaction $tx): ?string
    {
        if ($tx->merchant) {
            return $tx->merchant->category?->name;
        }

        if ($tx->counterpart_iban) {
            return $tx->counterpart_iban;
        }

        return null;
    }

    /**
     * Meest voorkomende dag-van-de-maand binnen de groep — geeft een
     * indicatie van wanneer de afschrijving valt ("rond de 25e").
     */
    private function dominantDayOfMonth(Collection $group): int
    {
        return (int) $group
            ->map(fn (Transaction $tx) => (int) Carbon::parse($tx->date)->format('j'))
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();
    }

    private function buildFilterUrl(Transaction $tx): ?string
    {
        if (! class_exists(TransactionResource::class)) {
            return null;
        }

        $filters = [];

        if ($tx->merchant_id) {
            $filters['merchant_id'] = ['value' => $tx->merchant_id];
        } elseif ($tx->counterpart_iban) {
            $filters['counterpart_iban'] = ['counterpart_iban' => $tx->counterpart_iban];
        }

        if (empty($filters)) {
            return null;
        }

        return TransactionResource::getUrl('index', [
            'tableFilters' => $filters,
        ]);
    }
}
