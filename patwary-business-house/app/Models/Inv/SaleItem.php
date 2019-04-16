<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model {

    protected $table = 'inv_sale_items';
    public $timestamps = false;

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }

    public function business_type() {
        return $this->belongsTo('App\Models\BusinessType', 'business_type_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Inv\Category', 'category_id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Inv\Product', 'product_id');
    }

}
