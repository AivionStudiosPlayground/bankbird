<?php

namespace App\Support;

use App\Models\User;

class Demo
{
    public const USER_EMAIL = 'demo@bankbird.app';

    public static function active(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        return request()->getHost() === config('app.demo_host', 'demo.bankbird.app');
    }

    public static function isMarketingSite(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        return request()->getHost() === config('app.home_host', 'bankbird.app');
    }

    public static function isDemoUser(?User $user): bool
    {
        return $user !== null && $user->email === self::USER_EMAIL;
    }
}
