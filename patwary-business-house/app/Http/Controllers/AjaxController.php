<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Response;
use DB;

class AjaxController extends Controller {

    // Function for User Activation
    public function make_user_active_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {
            $result = DB::table('users')->where('id', '=', $id);
            if (!$result->update(['status' => 1])) {
                throw new Exception("Error while Updating Records from Users.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'User has been Activated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Function for User Deactivation    
    public function make_user_inactive_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {

            $result = DB::table('users')->where('id', '=', $id);
            if (!$result->update(['status' => 0])) {
                throw new Exception("Error while Updating Records from Users.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'User has been Deactivated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Function for Delete Users
    public function delete_users_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $user = DB::table('users')->where('id', '=', $id);
                if (!$user->delete()) {
                    throw new Exception("Error while Deleting Records from User.");
                }
                $permisstion = DB::table('user_permissions')->where('user_id', '=', $id);
                if (!$permisstion->delete()) {
                    throw new Exception("Error while Deleting Records from Users Permission.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Users has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Function for Institute Activation
    public function make_institute_active_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {
            $result = DB::table('institutes')->where('id', '=', $id);
            if (!$result->update(['status' => 1])) {
                throw new Exception("Error while Updating Records from Institute.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Institute has been Activated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Function for Institute Deactivation    
    public function make_institute_inactive_by_id($id) {
        $resp = array();
        DB::beginTransaction();
        try {

            $result = DB::table('institutes')->where('id', '=', $id);
            if (!$result->update(['status' => 0])) {
                throw new Exception("Error while Updating Records from Institute.");
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Institute has been Deactivated Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

    // Function for Delete Users
    public function delete_institute_by_id() {
        $resp = array();
        DB::beginTransaction();
        try {
            foreach ($_POST['data'] as $id) {
                $institute = DB::table('institutes')->where('id', '=', $id);
                if (!$institute->delete()) {
                    throw new Exception("Error while Deleting Records from Institute.");
                }

                $institute_permissions = DB::table('institute_permissions')->where('institute_id', '=', $id);
                if (!$institute_permissions->delete()) {
                    throw new Exception("Error while Deleting Records from Users Institute Permission.");
                }

                $setting = DB::table('general_settings')->where('institute_id', '=', $id);
                if (!$setting->delete()) {
                    throw new Exception("Error while Deleting Records from General Setting.");
                }

                $users = DB::table('users')->where('institute_id', '=', $id);
                if (!$users->delete()) {
                    throw new Exception("Error while Deleting Records from Users.");
                }

                $user_permissions = DB::table('user_permissions')->where('institute_id', '=', $id);
                if (!$user_permissions->delete()) {
                    throw new Exception("Error while Deleting Records from User Permission.");
                }
            }
            DB::commit();
            $resp['success'] = true;
            $resp['message'] = 'Institute has been Deleted Successfully';
        } catch (Exception $e) {
            DB::rollback();
            $resp['success'] = false;
            $resp['message'] = $e->getMessage();
        }
        return $resp;
    }

}
