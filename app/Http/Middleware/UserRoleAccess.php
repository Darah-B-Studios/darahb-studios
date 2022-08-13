<?php

namespace App\Http\Middleware;

use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // check the role of the current user
            $user_role = auth()->user()->role;
            $current_route = Route::currentRouteName();
            if (
                UserPermission::roleHasAccessTo($user_role, $current_route) ||
                in_array($current_route, $this->defaultUserAccessRole()[$user_role])
            ) {
                return $next($request);
            }

            abort(403, "Unauthorized action");
        } catch (\Throwable $th) {
            abort(403, "You are not allowed to access this page");
        }
    }


    /**
     * THe default user access role
     *
     * @return void
     */
    private function defaultUserAccessRole()
    {
        return [
            'admin' => [
                'pages',
                'navigation-menus',
                'dashboard',
                'users',
                'user-permissions'
            ]
        ];
    }
}