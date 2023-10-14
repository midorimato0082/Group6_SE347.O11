<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (Session::has('admin_id') && (url('admin') == $request->url()))
    //         return redirect('dashboard');

    //     if (Session::has('user_id') && (url('login') == $request->url()))
    //         return redirect('');

    //     if (Session::has('user_id') && (url('dang-ky') == $request->url()))
    //         return redirect('');

    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        if(Session::has('user.id') && (url('login') == $request->url() || url('register') == $request->url())) {
            return back();
        }
        // if (Session::has('user.id') && (session('user.is_admin') == 1) && (url('login') == $request->url()))
        //     return redirect('dashboard');

        // if (Session::has('user.id') && (url('login') == $request->url()))
        //     return redirect('');

        // if (Session::has('user.id') && (url('register') == $request->url()))
        //     return redirect('');

        return $next($request);
    }
}
