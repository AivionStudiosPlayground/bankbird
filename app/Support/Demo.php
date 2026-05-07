<?php

namespace App\Support;

class Demo
{
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
}
