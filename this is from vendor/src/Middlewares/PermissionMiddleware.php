<?php

namespace Spatie\Permission\Middlewares;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission, $guard = null)
    {
         $id = Auth::user()->id;
       
        $role = Role::join("model_has_roles","model_has_roles.role_id","=","roles.id")
            ->where("model_has_roles.model_id",$id)
            ->get();
        $role_id = null;
        foreach($role as $item)
        {
            $role_id =$item->id;
        }
       
        $mypermission = Role::where('id',$role_id)->with('permissions')->get();
        $http_uri_check='';
        foreach ($mypermission as $key => $value) 
        {
            foreach($value->permissions as $item)
            {
                 if(strpos($item->http_uri,$permission) !== false)
                 {
                    $http_uri_check=$item->http_uri;
                 }
            }
        }

        $authGuard = app('auth')->guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions =[];
        //= is_array($permission)
        //     ? $permission
        //     : explode('|', $permission);

       //dd($permissions);

        // foreach ($permissions as $permission) {
           // dd($permission);
            //dd($authGuard->user());
        if($authGuard->user()->can($http_uri_check))
        {
            return $next($request);
        }
        // }

        throw UnauthorizedException::forPermissions($permissions);
    }

}
