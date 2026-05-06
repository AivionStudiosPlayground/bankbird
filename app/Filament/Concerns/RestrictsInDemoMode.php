<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

trait RestrictsInDemoMode
{
    public static function canCreate(): bool
    {
        return ! config('app.demo_mode', false);
    }

    public static function canEdit(Model $record): bool
    {
        return ! config('app.demo_mode', false);
    }

    public static function canDelete(Model $record): bool
    {
        return ! config('app.demo_mode', false);
    }

    public static function canDeleteAny(): bool
    {
        return ! config('app.demo_mode', false);
    }
}
