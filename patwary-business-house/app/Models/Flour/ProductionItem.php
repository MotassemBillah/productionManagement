<?php

namespace App\Models\Flour;

use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model {

    protected $table = 'flour_production_items';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\Models\Flour\Production', 'production_id');
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
            $data = \App\Models\Flour\Drawer::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

}
