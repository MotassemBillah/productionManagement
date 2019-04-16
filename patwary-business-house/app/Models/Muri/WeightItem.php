<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;

class WeightItem extends Model {

    protected $table = 'weight_items';
    public $timestamps = false;

    public function weights() {
        return $this->belongsTo('App\Weight', 'weight_id');
    }

    public function product_name($id) {
        return Product::find($id)->name;
    }

    public function after_product_name($id) {
        return AfterProduction::find($id)->name;
    }

    public function category_name($id) {
        return Category::find($id)->name;
    }

    public function headName($id) {
        return Head::find($id)->name;
    }

    public function subHeadName($id) {
        return SubHead::find($id)->name;
    }

    public function particularName($id) {
        return Particular::find($id)->name;
    }

    public function totalPurchaseByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['weight_type', 'in'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['weight_type', 'in'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalPurchaseBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('weight_type', 'in')->orderBy('date', 'DESC')->get();
        return $dataset;
    }
    
    public function totalSaleBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('weight_type', 'out')->orderBy('date', 'DESC')->get();
        return $dataset;
    }

    public function totalSaleByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['weight_type', 'out'], ['date', date('Y-m-d')]])->orderBy('date', 'DESC')->get();
        } else {
            $dataset = $this->where([['weight_type', 'out'], ['date', $date]])->orderBy('date', 'DESC')->get();
        }
        return $dataset;
    }

}
