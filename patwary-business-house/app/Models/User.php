<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'institute_id', 'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }

    public static function get_user_info_by_id($id) {
        $user = User::findOrfail($id);
        return $user;
    }

    public static function get_user_permisstion_by_id($id) {
        $permissions = DB::table('user_permissions')->where('user_id', '=', $id)->first()->permissions;
        return json_decode($permissions, true);
    }

}
