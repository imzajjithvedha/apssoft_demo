<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\UserRoles as Middleware;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, String $role)
    {
        $user = Auth::user();

        if($user->role == $role && $user->status == '1') {
            return $next($request);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}