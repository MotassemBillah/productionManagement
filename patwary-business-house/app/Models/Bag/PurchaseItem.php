<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\RawCategory;
use App\Models\RawProduct;

class PurchaseItem extends Model {

    protected $table = 'purchase_item';
    public $timestamps = false;

    public function purchase() {
        return $this->belongsTo('App\Models\Purchase', 'purchase_id');
    }

    public function productName($id) {
        $data = "";
        if (!empty($id)) {
            $data = RawProduct::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }
    
    public function categoryName($id) {
        $data = "";
        if (!empty($id)) {
            $data = RawCategory::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }
    
    public function unitName($id) {
        $data = "";
        if (!empty($id)) {
            $data = RawProduct::find($id);
        }
        $_name = !empty($data) ? $data->unit : '';
        return $_name;
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
            $dataset = $this->where([['type', 'in'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'in'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalProductionByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['type', 'out'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'out'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalPurchaseBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('type', 'in')->orderBy('date', 'DESC')->get();
        return $dataset;
    }

    public function totalProductionBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('type', 'out')->orderBy('date', 'DESC')->get();
        return $dataset;
    }

}
