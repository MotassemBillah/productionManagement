<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'inv_category';
    public $timestamps = false;

    public function business_type() {
        return $this->belongsTo('App\Models\BusinessType', 'business_type_id');
    }

    public function products() {
        return $this->hasMany('App\Models\Inv\Product', 'category_id', 'id')->where('is_deleted', '=', 0);
    }

    public function getList() {
        $query = $this->where('is_deleted', 0);
        $query->orderBy("name", "ASC");
        $_dataset = $query->get();
        return $_dataset;
    }

    public function custom_labels() {
        return [
            "id" => "ID",
            "business_type_id" => "Business Type",
            "type" => "Type",
            "name" => "Name",
            "unit" => "Unit",
            "description" => "Description",
        ];
    }

    public function tableColumnsAsLabel() {
        $_arr = [];
        $columns = $this->getTableColumns();
        foreach ($columns as $ck => $cv) {
            $_arr[$cv] = $cv;
        }
        return $_arr;
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}
