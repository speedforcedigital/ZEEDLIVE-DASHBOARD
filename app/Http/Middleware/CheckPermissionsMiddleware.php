<?php

namespace App\Http\Middleware;

use App\Models\AccountDetail;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissionsMiddleware
{
    public function handle($request, Closure $next, ...$permissions)
    {
        if (Auth::check()) {
            $getPermissions = AccountDetail::where('user_id', Auth::user()->id)->first();
            $permissionsString = stripslashes($getPermissions->permissions);
            $newPermissionsString = trim($permissionsString, '"');
            $userPermissions = json_decode($newPermissionsString, true);
//            dd($userPermissions);
            foreach ($permissions as $permission) {
                if (!$this->hasPermission($userPermissions, $permission)) {
                    return abort(403, 'Unauthorized. Insufficient permissions.');
                }
            }

            return $next($request);
        }

        return abort(401, 'Unauthenticated.');
    }

    private function hasPermission($userPermissions, $requiredPermission)
    {
//        dd($userPermissions, $requiredPermission);
        foreach ($userPermissions as $item) {
            foreach ($item as $category => $actions) {
                if ($category === $requiredPermission && count(array_intersect($actions, ['list', 'add', 'edit', 'delete', 'view', 'filter', 'verification'])) > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
