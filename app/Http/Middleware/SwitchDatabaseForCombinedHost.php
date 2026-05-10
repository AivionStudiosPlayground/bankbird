<?php

namespace App\Http\Middleware;

use App\Support\Demo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Wisselt de default database-connection per request wanneer we op de
 * lokale gecombineerde host draaien. Demo-paden krijgen sqlite_demo,
 * dev-paden en marketing krijgen sqlite_dev. Productie is host-based
 * gescheiden en raakt deze middleware nooit (Demo::isLocalCombined()
 * returnt false zodra de host afwijkt van app.local_host).
 */
class SwitchDatabaseForCombinedHost
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Demo::isLocalCombined()) {
            return $next($request);
        }

        // Livewire's update endpoint is global (/livewire-xxx/update) and shares no path prefix
        // with the panel that rendered it. Without this, demo-panel form submits would route to
        // sqlite_dev and 419 on every CSRF check. Fall back to the Referer to identify the panel.
        $isDemo = Demo::active() || $this->refererStartsWithDemo($request);

        config(['database.default' => $isDemo ? 'sqlite_demo' : 'sqlite_dev']);

        return $next($request);
    }

    private function refererStartsWithDemo(Request $request): bool
    {
        $referer = $request->headers->get('referer');

        if (! $referer) {
            return false;
        }

        $path = ltrim((string) parse_url($referer, PHP_URL_PATH), '/');

        return $path === 'demo' || str_starts_with($path, 'demo/');
    }
}
