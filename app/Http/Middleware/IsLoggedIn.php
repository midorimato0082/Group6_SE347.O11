<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user.id'))
            return redirect('login')->with('fail', 'Bạn cần phải đăng nhập trước.');
        else if (session('user.is_admin') != 1)
            return redirect('error/401');

        return $next($request);
    }
}
