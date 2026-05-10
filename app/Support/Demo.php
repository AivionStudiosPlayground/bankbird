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

        // Marketing-host serveert publieke pagina's op `/`, dus het admin-paneel
        // staat daar onder `/admin` om botsingen te voorkomen. Op alle andere
        // hosts (productie demo-host, dev-host en self-hosted installaties)
        // bestaat geen publieke marketing-site en draait het admin-paneel
        // direct op de root.
        if (self::isMarketingSite()) {
            return 'admin';
        }

        return '';
    }

    /**
     * Bouwt een URL binnen het admin-paneel die rekening houdt met de actieve
     * panel-path. Gebruik dit overal in plaats van een hardcoded `/admin/...`
     * zodat self-hosted installaties (panel op root) en marketing-host (panel
     * op `/admin`) allebei werken.
     *
     * Voorbeeld: `Demo::panelUrl('updates')` →
     * - `https://bankbird.app/admin/updates` (marketing)
     * - `https://demo.bankbird.app/updates` (demo)
     * - `https://bankbird.test/updates` (self-hosted)
     * - `https://bankbird.app.test/dev/updates` (lokaal combined)
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
