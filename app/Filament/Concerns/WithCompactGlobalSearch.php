<?php

namespace App\Filament\Concerns;

use Filament\Actions\Action;
use Filament\GlobalSearch\GlobalSearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Beperkt het aantal global-search resultaten per resource tot een klein
 * aantal en voegt een "alle resultaten bekijken" link toe wanneer er meer
 * matches zijn dan getoond. De link wijst naar de index-pagina met
 * `?search=...` zodat de tabel direct gefilterd opent.
 *
 * Verwacht dat het implementerende resource een statische
 * `globalSearchSeeMoreUrl(string $search): string` levert.
 */
trait WithCompactGlobalSearch
{
    public static function getGlobalSearchResultsLimit(): int
    {
        return 5;
    }

    public static function getGlobalSearchResults(string $search): Collection
    {
        $query = static::getGlobalSearchEloquentQuery();

        static::applyGlobalSearchAttributeConstraints($query, $search);
        static::modifyGlobalSearchQuery($query, $search);

        $limit = static::getGlobalSearchResultsLimit();
        $total = (clone $query)->count();

        $results = $query
            ->limit($limit)
            ->get()
            ->map(function (Model $record): ?GlobalSearchResult {
                $url = static::getGlobalSearchResultUrl($record);

                if (blank($url)) {
                    return null;
                }

                return new GlobalSearchResult(
                    title: static::getGlobalSearchResultTitle($record),
                    url: $url,
                    details: static::getGlobalSearchResultDetails($record),
                    actions: array_map(
                        fn (Action $action) => $action->hasRecord() ? $action : $action->record($record),
                        static::getGlobalSearchResultActions($record),
                    ),
                );
            })
            ->filter()
            ->values();

        if ($total > $limit) {
            $extra = $total - $limit;
            $label = static::getPluralModelLabel();

            $results->push(new GlobalSearchResult(
                title: "Alle {$total} {$label} bekijken",
                url: static::globalSearchSeeMoreUrl($search),
                details: ['' => "+{$extra} extra resultaat".($extra === 1 ? '' : 'en')],
            ));
        }

        return $results;
    }
}
