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

        $connection = Demo::active() ? 'sqlite_demo' : 'sqlite_dev';

        config(['database.default' => $connection]);

        return $next($request);
    }
}
