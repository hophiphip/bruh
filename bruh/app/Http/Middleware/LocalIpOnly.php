<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocalIpOnly
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (($request->server('SERVER_ADDR') != $request->server('REMOTE_ADDR')) && (env('APP_ADMIN_PANEL_ACCESS') == false))
        {
            abort(404);
        }

        return $next($request);
    }
}
