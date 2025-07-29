<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactorEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  $user = $request->user();

        if ($user && $user->requiresTwoFactorEmail() && !$request->session()->get('2fa_email_verified')) {
            return redirect()->route('two-factor.email.challenge');
        }

        
        return $next($request);
    }
}
