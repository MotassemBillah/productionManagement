<?php

namespace App;
use DB;
use Session;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //Function for View Generel Setting
    public static function get_setting()
    {
        $result=DB::table('tbl_settings')->first();
        return $result;
    }

        //Function for Delete Agent by ID
    public static function update_setting($data)
    {
        
        $id = $data->input('hid');
        $insert_data = array();
        $user_id = Auth::user()->id;
        $insert_data['title']=$data->input('site_name');
        $insert_data['owner']=$data->input('author_name');
        $insert_data['address']=$data->input('author_address');
        $insert_data['description']=$data->input('site_description');
        $insert_data['email']=$data->input('author_email');
        $insert_data['mobile']=$data->input('author_mobile');
        $insert_data['phone']=$data->input('author_phone');
        $insert_data['copyright']=$data->input('copyright');
        $insert_data['other_contact']=$data->input('other_contacts');
        $insert_data['modified_by']=$user_id;

        $update_agent=DB::table('tbl_settings')->where('_key','=',$id)->update($insert_data); 
    }


}
