<?php

namespace AppsLab\Acl\Middleware;

use AppsLab\Acl\Exceptions\UnauthorizedException;
use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if (Auth::guest()){
            return redirect()->route(config('ruhusa.login-route'));
        }

        $permissions = is_array($permissions) ? $permissions : explode("|", $permissions);

        foreach ($permissions as $permission){
            if ($request->user()->can($permission)){
                return $next($request);
            }
        }

        throw UnauthorizedException::unauthorizedTo(config('ruhusa.messages.no-permission'));
    }
}