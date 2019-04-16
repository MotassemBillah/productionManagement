<?php

namespace App\Models\Rice;

use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model {

    protected $table = 'rice_production_items';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Rice\Production', 'production_id');
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id', 'id');
    }

    public function categoryName($id) {
        $data = "";
        if (!empty($id)) {
            $data = \App\Models\Inv\Category::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function productName($id) {
        $data = "";
        if (!empty($id)) {
            $data = \App\Models\Inv\Product::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function drawerName($id) {
        $data = "";
        if (!empty($id)) {
            $data = \App\Models\Rice\Drawer::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

}
