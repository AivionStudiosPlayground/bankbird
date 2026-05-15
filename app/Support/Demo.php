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

        return '';
    }

    /**
     * Bouwt een URL binnen het admin-paneel die rekening houdt met de actieve
     * panel-path. Gebruik dit overal in plaats van een hardcoded `/admin/...`
     * zodat self-hosted installaties (panel op root) en lokale combined-host
     * (panel op `/demo` of `/dev`) allebei werken.
     */
    public static function panelUrl(string $path = ''): string
    {
        $segments = trim(self::panelPath().'/'.ltrim($path, '/'), '/');

        return url('/'.$segments);
    }

    private static function pathStartsWith(string $segment): bool
    {
        $path = request()->path();

        return $path === $segment || str_starts_with($path, $segment.'/');
    }
}
