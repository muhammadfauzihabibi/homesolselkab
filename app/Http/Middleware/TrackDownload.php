<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackDownload
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful downloads
        if ($response->getStatusCode() === 302 && $request->routeIs('frontend.unduhan.download')) {
            // Additional tracking logic can be added here
            // e.g., store in separate analytics table, send to Google Analytics, etc.
        }

        return $response;
    }
}