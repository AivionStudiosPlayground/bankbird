<?php

namespace App\Http\Middleware;

use App\Support\Demo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BlockDemoUserOutsideDemoHost
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Demo::isDemoUser(Auth::user()) || Demo::active()) {
            return $next($request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $demoHost = config('app.demo_host', 'demo.bankbird.app');

        return redirect()->away("https://{$demoHost}/");
    }
}
