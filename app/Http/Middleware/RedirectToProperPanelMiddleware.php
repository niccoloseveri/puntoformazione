<?php

namespace App\Http\Middleware;

use App\Filament\Pages\Dashboard;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RedirectToProperPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->notAdmin()) {
            return redirect()->to(Dashboard::getUrl(panel: 'user'));
        }
        return $next($request);
    }
}
