<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class EmptyBagStock extends Model {

    protected $table = 'empty_bag_stock';
    public $timestamps = false;

    public function head_name($id) {
        return Head::find($id)->name;
    }

    public function subhead_name($id) {
        $_name = "";
        if (!empty($id)) {
            $_name = SubHead::find($id)->name;
        }
        return $_name;
    }

    public function particular_name($id) {
        $_name = "";
        if (!empty($id)) {
            $_name = Particular::find($id)->name;
        }
        return $_name;
    }

    public function headDebit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new EmptyBagStock();
        $query = $model->where('particular_id', $head_id);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function headCredit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new EmptyBagStock();
        $query = $model->where('particular_id', $head_id);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function headBalance($head_id, $from_date = NULL, $end_date = NULL) {
        if (!is_null($from_date)) {
            $data = $this->headDebit($head_id, $from_date, $end_date) - $this->headCredit($head_id, $from_date, $end_date);
        } else {
            $data = $this->headDebit($head_id) - $this->headCredit($head_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function totalReceiveByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['type', 'Receive'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'Receive'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalPaymentByDate($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['type', 'Payment'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['type', 'Payment'], ['date', $date]])->get();
        }
        return $dataset;
    }

}
