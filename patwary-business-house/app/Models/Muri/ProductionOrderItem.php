<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionOrderItem extends Model {

    protected $table = 'production_items';
    public $timestamps = false;

    public function order() {
        return $this->belongsTo('App\ProductionOrder', 'production_id');
    }

}
