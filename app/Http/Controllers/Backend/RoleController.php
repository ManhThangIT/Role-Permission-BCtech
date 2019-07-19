<?php

namespace App\Http\Controllers\Backend;

use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\RoleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Role;
use App\Models\Permission;
use DB;

class RoleController extends Controller
{

    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }


    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        $roles = $this->roleRepository->all();

        return view('backend.roles.index')
        ->with('roles', $roles);
    }


    public function create()
    {
        \App\Commons\Pemission::sync();
        $pGroups = Permission::whereNotNull('module')->groupBy('module')->select('module')->get()->toArray();
        $pGroups = array_column($pGroups, 'module', 'module');
        // dd($pGroups);
        foreach ($pGroups as $key => $value) {
            $tmp = Permission::where('module', $key)->orderBy('action')->select('id', 'display_name', 'action')->get()->toArray();
            $pGroups[$key] = array_column($tmp, 'id', 'action');
        }
        return view('backend.roles.create', compact('pGroups'));
    }

    public function store(Request $request)
    {
        // dd(1);
        $input = $request->all();

        $validator = \Validator::make($input = $request->all(), Role::rules());

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        // dd($input);
        $role = Role::create($input);
        // dd($role);
        // dd($request->get('permissions'));
        foreach ($request->input('permissions') as $permission) {
            // dd($permission);
            $role->attachPermission($permission);
            // dd($roles);
        }

        Flash::success('Role saved successfully.');

        return redirect(route('admin.roles.index'));
    }

    public function show($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('admin.roles.index'));
        }

        return view('backend.roles.show')->with('role', $role);
    }


    public function edit($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        // \App\Commons\Pemission::sync();

        $permissions = array_column($role->permissions()->select("id")->get()->toArray(), 'id', 'id');

        $pGroups = Permission::whereNotNull('module')->groupBy('module')->select('module')->get()->toArray();
        $pGroups = array_column($pGroups, 'module', 'module');
        foreach ($pGroups as $key => $value) {
            $tmp = Permission::where('module', $key)->orderBy('action')->select('id', 'display_name', 'action')->get()->toArray();
            $pGroups[$key] = array_column($tmp, 'id', 'action');
        }


        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('admin.roles.index'));
        }

        return view('backend.roles.edit', compact('role', 'pGroups', 'permission'));
    }


    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('admin.roles.index'));
        }

        $role = $this->roleRepository->update($request->all(), $id);

        DB::table("permission_role")->where("role_id", $id)->delete();
        foreach ($request->input('permissions') as $permission) {
            $role->attachPermission($permission);
        }

        Flash::success('Role updated successfully.');

        return redirect(route('admin.roles.index'));
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('admin.roles.index'));
        }

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('admin.roles.index'));
    }
}
