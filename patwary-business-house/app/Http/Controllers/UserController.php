<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Validator;
use Hash;

class UserController extends HomeController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        check_user_access('manage_user');
        $model = new User();
        $dataset = is_Admin() ? $model->where('id', '!=', Auth::id())->get() : $model->where([['institute_id', institute_id()], ['id', '!=', Auth::id()]])->get();
        return view('institute.user.index', compact('dataset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('institute.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = User::where('_key', $id)->first();
        return view('institute.user.user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        check_user_access('manage_user');
        $user = User::where('_key', $id)->first();
        return view('institute.user.edit_user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        check_user_access('manage_user');
        $input = $request->all();

        $rule = array(
            'name' => 'required',
            'email' => 'required|email',
        );

        $valid = Validator::make($input, $rule);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->locale = $request->input('locale');
            $user->updated_by = Auth::id();

            $user->save();
            return redirect('user')->with('success', 'User has been Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function change_user_password() {
        return view('institute.user.change_password');
    }

    public function update_user_password(Request $r) {
        $input = $r->all();
        $id = Auth::id();

        $rule = array(
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        );

        $valid = Validator::make($input, $rule);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        } else {

            $user = User::find($id);
            $old = $user->password;
            $kk = $r->input('old_password');

            if (Hash::check($kk, $old)) {
                $user->password = bcrypt($r->input('password'));
                $user->updated_by = Auth::id();
                $user->save();
                return redirect()->back()->with('success', 'Password has been Changed Successfully.');
            } else {
                return redirect()->back()->with('danger', 'You are not authorized no change the Password.');
            }
        }
    }

    public function user_access_by_id($id) {
        check_user_access('user_access');
        $user = User::where('_key', $id)->first();
        return view('institute.user.user_access', compact('user'));
    }

    public function update_user_access_by_id(Request $r) {
        //pr($_POST);
        check_user_access('user_access');
        $user_id = $r->input('user_id');
        $new_access = $r->input('access');
        $access_item = json_encode($new_access);
        $items = array(
            'permissions' => $access_item,
        );
        $update_access_item = DB::table('user_permissions')->where('user_id', '=', $user_id)->update($items);
        return redirect('user')->with('success', 'User Permission has been Updated Successfully.');
    }

}
