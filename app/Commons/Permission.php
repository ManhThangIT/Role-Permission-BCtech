<?php 
namespace App\Commons;

use App\Models\Permission as Permission;
use App\Models\Role as Role;
use Laratrust\Traits\LaratrustUserTrait;


class Pemission
{
    public static function sync()
    {
        $routes = \Route::getRoutes();
        // dd($route);
        $permissions = [];

        foreach($routes as $route)
        {
            $name = $route->getName();
            // dd($name);
            if (substr($name, 0, 5) == 'admin' && count(explode('.', $name)) > 2) {
                $action     = $route->getAction();
                // dd($action);
                if ( isset($action['role']) ) {
                    //foreach ($action['role'] as $role) {
                    $role = $action['role'];
                    // dd($role);
                    $role = substr($role, 6, strlen($role));
                    // dd($role);
                    $oneDot = explode('.', $role);
                    // dd($oneDot);
                    if( isset( $oneDot[1] ) ) {
                        $permissions[ str_replace('-', '_', substr($role, 0, strlen($role) - strlen(end($oneDot)) - 1)) ][] = end($oneDot);
                    }
                    //}
                } else {
                    $routeName = substr( $name, 6, strlen( $name ) );
                    $oneDot = explode('.', $routeName);
                    if( isset( $oneDot[1] ) ) {
                        $permissions[ str_replace('-', '_', substr($routeName, 0, strlen($routeName) - strlen(end($oneDot)) - 1)) ][] = end($oneDot);
                    }
                }
            }
        }

        foreach ($permissions as $key => $value) {
            // dd($permissions);
            foreach ($value as $k => $v) {
                if ( $v == 'view' || $v == 'index' || $v == 'show' )
                    $value[$k] = 'read';
                if ( $v == 'delete' || $v == 'destroy' )
                    $value[$k] = 'delete';
                if ( $v == 'create' || $v == 'store' )
                    $value[$k] = 'create';
                if ( $v == 'edit' || $v == 'update' )
                    $value[$k] = 'update';
            }

            $permissions[$key] = array_unique( ($value) );
            // dd($permissions[$key]);
        }

        foreach ($permissions as $key => $value) {
            // dd($key);
            foreach ($value as $v) {
                // dd($value);
                if (is_null(Permission::where('name', $key . '.' . $v)->first())) {
                    $permission = Permission::Create([
                        'name'          => $key . '.' . $v,
                        'display_name'  => (\Lang::has($v) ? $v : ucfirst($v)) . ' ' . (\Lang::has($key) ? ($key) : ucfirst($key)),
                        'description'   => ucfirst($v) . ' ' . ucfirst($key),
                        'module'        => $key,
                        'action'        => $v
                    ]);

                    //add to system role
                    Role::first()->attachPermission($permission);
                }
            }
        }

    }
}
