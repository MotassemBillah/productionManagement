<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use DB;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        $valid = Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
        ]);

        if (is_Admin()) {
            $valid = Validator::make($data, [
                        'name' => 'required|string|max:255',
                        'institute_id' => 'required',
                        'user_role_id' => 'required',
                        'user_type' => 'required',
                        'email' => 'required|string|email|max:255|unique:users',
                        'password' => 'required|string|min:6|confirmed',
            ]);
        }
        return $valid;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // Laravel Auth Default User Create
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => bcrypt($data['password']),
    //     ]);
    // }

    protected function create(array $data) {

        if (Auth::user()->type == 'admin') {
            $institute_id = $data['institute_id'];
            $user_type = $data['user_type'];
        } else {
            $institute_id = institute_id();
            $user_type = 'institute';
        }

        $user_info = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'institute_id' => $institute_id,
            'user_role_id' => $data['user_role_id'],
            'type' => $user_type,
            'password' => bcrypt($data['password']),
            'created_by' => Auth::id(),
            '_key' => uniqueKey(),
        );

        $default_access_items = default_user_access_items();
        $items = json_encode($default_access_items);

        $user_permissions = array(
            'permissions' => $items,
        );

        DB::beginTransaction();
        try {

            $create_user = User:: insert($user_info);
            $user_id = DB::getPdo()->lastInsertId();

            if (!$create_user) {
                throw new Exception("Query Problem on Creating User");
            }

            $user_permissions ['user_id'] = $user_id;
            $user_permissions ['institute_id'] = $institute_id;
            $user_permissions ['_key'] = $user_info['_key'];

            $create_permisstion = DB::table('user_permissions')->insert($user_permissions);

            if (!$create_permisstion) {
                throw new Exception("Query Problem on Creating Permission");
            }

            DB::commit();
            return redirect('user')->with('success', 'New User has been Created Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

}
