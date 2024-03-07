<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;

class RedirectServiceProvider
{
    /**
     * Redirect to the appropriate dashboard based on user role.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public static function redirectToDashboard()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard.index');
            default:
                return '/login';
        }
    }
}
