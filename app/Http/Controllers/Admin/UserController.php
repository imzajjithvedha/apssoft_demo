<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(session('users')) {
            $name = session('name');
            $role = session('role');

            session()->forget('name');
            session()->forget('role');
        }
        else {
            $name = null;
            $role = null;
        }

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            if(session('users')) {
                $users_query = session('users');
                session()->forget('users');
            }
            else {
                $users_query = User::where('status', '!=', '0')->orderBy('id', 'asc')->get();
            }

            $total_records = $users_query->count();
            $users = $users_query->skip($start)->take($length);
            $records_filtered = $users->count();

            foreach($users as $key => $user) {
                $user->action = '
                <a id="'.$user->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$user->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                $user->name = $user->first_name . ' ' . $user->last_name;

                if($user->role == 'admin') {
                    $user->role = '<span class="badge role-admin">Admin</span>';
                }
                else {
                    $user->role = '<span class="badge role-user">User</span>';
                }

                if($user->status == '1') {
                    $user->status = '<span class="badge text-bg-success">Activate</span>';
                }
                else {
                    $user->status = '<span class="badge text-bg-danger">Deactivate</span>';
                }
            }

            return response()->json([
                'data' => $users,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.users', [
            'name' => $name,
            'role' => $role
        ]);
    }
                                                                              
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|string|min:6|max:100|',
            'password_confirmation' => 'required|same:password'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Creation Failed!');
        }

        $user = new User();
        $data = $request->except('password', 'password_confirmation');
        $data['password'] = bcrypt($request->password);
        $user->create($data);

        return redirect()->route('admin.users.index')->with('success', 'Successfully Created!');
    }

    public function edit(User $user)
    {
        return response($user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user->id
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update Failed!');
        }

        $data = $request->except('password', 'password_confirmation');

        if($request->new_password != null) {
            $validator = $request->validate([ 
                'new_password' => 'required|string|min:6|max:100|',
                'password_confirmation' => 'required|same:new_password',
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update Failed!');
            }

            $data['password'] = bcrypt($request->new_password);
        }
        
        $user->fill($data)->save();
        
        return redirect()->route('admin.users.index')->with('success', "Successfully Updated!");
    }

    public function delete(User $user)
    {
        $user->status = '0';
        $user->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['users', 'name', 'role'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.users.index');
        }

        $name = $request->name;
        $role = $request->role;

        $users = User::where('status', '!=', '0');

        if($name != null) {
            $users->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');
        }

        if($role != 'all') {
            $users->where('role', $role);
        }

        $users = $users->orderBy('id', 'asc')->get();

        session([
            'users' => $users,
            'name' => $name,
            'role' => $role,
        ]);

        return redirect()->route('admin.users.index');
    }
}