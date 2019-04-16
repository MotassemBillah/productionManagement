<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use App\Models\FinishCategory;
use App\Models\FinishProduct;

class SalesItem extends Model {

    protected $table = 'sales_item';
    public $timestamps = false;

    public function sales() {
        return $this->belongsTo('App\Models\Sales', 'sales_id');
    }

    public function productName($id) {
        $data = "";
        if (!empty($id)) {
            $data = FinishProduct::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function categoryName($id) {
        $data = "";
        if (!empty($id)) {
            $data = FinishCategory::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function unitName($id) {
        $data = "";
        if (!empty($id)) {
            $data = FinishProduct::find($id);
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

    public function totalFinishByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['type', 'in'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'in'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalSaleByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['type', 'out'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'out'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalFinishBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('type', 'in')->orderBy('date', 'DESC')->get();
        return $dataset;
    }

    public function totalSaleBetweenDate($from_date, $end_date) {
        $query = $this->whereBetween('date', [$from_date, $end_date]);
        $dataset = $query->where('type', 'out')->orderBy('date', 'DESC')->get();
        return $dataset;
    }

}
