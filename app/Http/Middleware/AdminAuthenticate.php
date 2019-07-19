<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthenticate
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */

    public function handle($request, Closure $next, $guard = 'admin')
    {
        // dd(1);
        // config(['auth.defaults.guard' => 'admin']);
        // config(['auth.defaults.passwords' => 'users']);

        if (!\Auth::guard($guard)->check()) {
            //echo $request->user()->id;
            // dd(\Auth::guard($guard));
            // if (substr($request->path(), 0, 16) == "admin/log-viewer" || $request->path() == "admin/elfinder/?CKEditor=content&CKEditorFuncNum=1&langCode=vi") {
            //     return $next($request);
            // }

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            \Session::put('loginRedirect_' . $guard, \Request::url());
            return redirect()->guest('admin/login');
        }

        if (substr($request->path(), 0, 16) == "admin/log-viewer" || $request->path() == "admin/elfinder") {
            return $next($request);
        }

        $action = $request->route()->getAction();
        // dd($action);
        if (!isset($action['as']) || \Auth::guard($guard)->user()->hasRole('SuperAdmin')) return $next($request);
        // dd(isset($action['role']));
        if (isset($action['role'])) {
            $data = explode('.', $action['role']);
            if (!isset($data[2])) return $next($request);
            if (\Auth::guard($guard)->user()->can(str_replace('-', '_', $data[1]) . '.' . $data[2]))
                return $next($request);
        }

        $data = explode('.', $action['as']);
        if (count($data) <> 3) return $next($request);
        if ($data[2] == 'index' || $data[2] == 'show')
            $action = 'read';
        elseif ($data[2] == 'edit' || $data[2] == 'update')
            $action = 'update';
        elseif ($data[2] == 'create' || $data[2] == 'store')
            $action = 'create';
        elseif($data[2] == 'destroy')
            $action = 'delete';
        else
            $action = $data[2];
        if (!\Auth::guard($guard)->user()->can(str_replace('-', '_', $data[1]) . '.' . $action))
            // return redirect()->route('admin.403');
            return "Lỗi";


        return $next($request);
    }
}