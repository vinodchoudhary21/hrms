<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('ADMIN') || session()->has('ADMINUSERID')) {
            return $next($request);
        }

        return redirect()->route('Admin.Adminlogout'); // ये route नीचे step 5 में define होगा
    }
}
