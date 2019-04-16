<?php

namespace App\Models\Inv;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use App\Models\Head;
use App\Models\SubHead;
use App\Models\Particular;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    protected $table = 'inv_transactions';
    public $timestamps = false;

    public function head_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = Head::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function subhead_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = SubHead::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function particular_name($id) {
        $data = "";
        if (!empty($id)) {
            $data = Particular::find($id);
        }
        $_name = !empty($data) ? $data->name : '';
        return $_name;
    }

    public function institute() {
        return $this->belongsTo('App\Models\Institute', 'institute_id');
    }

    // sum
    public function sum_debit($head_id = null) {
        if (!is_null($head_id)) {
            $data = Transaction::where('dr_head_id', $head_id)->sum('debit');
        } else {
            $data = Transaction::sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sum_credit($head_id = null) {
        if (!is_null($head_id)) {
            $data = Transaction::where('cr_head_id', $head_id)->sum('credit');
        } else {
            $data = Transaction::sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sum_balance($head_id = null) {
        if (!is_null($head_id)) {
            $data = $this->sumDebit($head_id) - $this->sumCredit($head_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    // head sum
    public function head_debit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['dr_head_id', $head_id], ['dr_subhead_id', NULL], ['dr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function head_credit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['cr_head_id', $head_id], ['cr_subhead_id', NULL], ['cr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function head_balance($head_id, $from_date = NULL, $end_date = NULL) {
        if (!is_null($from_date)) {
            $data = $this->headDebit($head_id, $from_date, $end_date) - $this->headCredit($head_id, $from_date, $end_date);
        } else {
            $data = $this->headDebit($head_id) - $this->headCredit($head_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    // subhead sum
    public function subhead_debit($subhead_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['dr_subhead_id', $subhead_id], ['dr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function subhead_credit($subhead_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['cr_subhead_id', $subhead_id], ['cr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function subhead_balance($subhead_id, $from_date = NULL, $end_date = NULL) {
        if (!is_null($from_date)) {
            $data = $this->subheadDebit($subhead_id, $from_date, $end_date) - $this->subheadCredit($subhead_id, $from_date, $end_date);
        } else {
            $data = $this->subheadDebit($subhead_id) - $this->subheadCredit($subhead_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumSubDebit($subhead_id = null) {
        if (!is_null($subhead_id)) {
            $data = Transaction::where('dr_subhead_id', $subhead_id)->sum('debit');
        } else {
            $data = Transaction::sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumSubCredit($subhead_id = null) {
        if (!is_null($subhead_id)) {
            $data = Transaction::where('cr_subhead_id', $subhead_id)->sum('credit');
        } else {
            $data = Transaction::sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumSubBalance($subhead_id = null) {
        if (!is_null($subhead_id)) {
            $data = $this->sumSubDebit($subhead_id) - $this->sumSubCredit($subhead_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    // particular sum
    public function part_debit($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = Transaction::where('dr_particular_id', $particular_id)->sum('debit');
        } else {
            $data = Transaction::sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function part_credit($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = Transaction::where('cr_particular_id', $particular_id)->sum('credit');
        } else {
            $data = Transaction::sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function part_balance($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = $this->sumPartDebit($particular_id) - $this->sumPartCredit($particular_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    // between_date
    public function head_debit_between_date($head_id, $from_date = null, $end_date = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('dr_head_id', $head_id)->orWhere('cr_head_id', $head_id);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function debit_between_date($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('dr_head_id', $head_id);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function credit_between_date($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('cr_head_id', $head_id);
        }

        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

}
