<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'inv_product';
    public $timestamps = false;

    public function business_type() {
        return $this->belongsTo('App\Models\BusinessType', 'business_type_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Inv\Category', 'category_id');
    }

    public function getList($id = null) {
        $query = $this->where('is_deleted', 0);
        if (!is_null($id)) {
            $query->where('category_id', $id);
        }
        $query->orderBy("name", "ASC");
        $_dataset = $query->get();
        return $_dataset;
    }

    public function name($id = null) {
        $query = $this->where('is_deleted', 0);
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        $_data = $query->first();
        return !empty($_data) ? $_data->name : "";
    }

}
