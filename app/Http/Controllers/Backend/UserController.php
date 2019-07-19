<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\User;
use App\Models\Role;
use Hash;
use DB;

class UserController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }


    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        return view('backend.users.index')
        ->with('users', $users);
    }


    public function create()
    {
        $roles = Role::select('display_name','id')->get();
        return view('backend.users.create', compact('roles'));
    }


    public function store(CreateUserRequest $request)
    {
        $validator = \Validator::make($data = $request->all(), User::rules());
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);

        foreach ($request->input('roles') as $role) {
            $user->attachRole($role);
        }

        Flash::success('User saved successfully.');

        return redirect(route('admin.users.index'));
    }


    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            // Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        return view('backend.users.show')->with('user', $user);
    }


    public function edit($id)
    {
        $roles = Role::select('display_name','id')->get();
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }
        $uRoles = $user->roles->pluck('id','id')->toArray();


        return view('backend.users.edit', compact('user', 'roles', 'uRoles'));
    }


    public function update($id, UpdateUserRequest $request)
    {
        
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $input = $request->all();

        $validator = \Validator::make($input = $request->all(), User::rules($id));

        if ($validator->fails()) return back()->withErrors($validator)->withInput();


        $input['password'] = Hash::make($input['password']);
        // dd($input['password']);
        $user = $this->userRepository->update($input, $id);

        DB::table('role_user')->where('user_id', $id)->delete();

        foreach ($request->input('roles') as $role) {
            $user->attachRole($role);
        }

        Flash::success('User updated successfully.');

        return redirect(route('admin.users.index'));
    }


    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('admin.users.index'));
    }
}
