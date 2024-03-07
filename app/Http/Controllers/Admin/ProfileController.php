<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);

        return view('admin.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user->id
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->old_password != null && $request->new_password != null && $request->confirm_password != null) {

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|string|min:6|max:100|',
                'confirm_password' => 'required|same:new_password',
            ]);
    
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(Hash::check($request->old_password, $user->password)) {
                $data = $request->except('old_password', 'new_password', 'confirm_password'); 
                $data['password'] = bcrypt($request->new_password);
                $user->fill($data)->save();

                Auth::guard('web')->logout();
                Auth::logoutOtherDevices($request->new_password);

                return redirect()->route('login');
            }
            else {
                return redirect()->route('admin.profile.index')->with('error', "Old password is wrong!");
            }
        }
        else {
            $data = $request->except('old_password', 'new_password', 'confirm_password');
            $user->fill($data)->save();

            return redirect()->route('admin.profile.index')->with('success', "Successfully Updated!");
        }
    }
}
