<?php

namespace App\Support;

class Demo
{
    public static function active(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        if (request()->getHost() === config('app.demo_host', 'demo.bankbird.app')) {
            return true;
        }

        return self::isLocalCombined() && self::pathStartsWith('demo');
    }

    public static function isMarketingSite(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        if (request()->getHost() === config('app.home_host', 'bankbird.app')) {
            return true;
        }

        return self::isLocalCombined()
            && ! self::pathStartsWith('demo')
            && ! self::pathStartsWith('dev');
    }

    public static function isLocalCombined(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        $localHost = config('app.local_host');

        return $localHost !== null && $localHost !== '' && request()->getHost() === $localHost;
    }

    public static function panelPath(): string
    {
        if (self::isLocalCombined()) {
            return self::active() ? 'demo' : 'dev';
        }

        return self::active() ? '' : 'admin';
    }

    private static function pathStartsWith(string $segment): bool
    {
        $path = request()->path();

        return $path === $segment || str_starts_with($path, $segment.'/');
    }
}
