<?php

namespace App\Models;

use DB;
use Session;
use Auth;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

    protected $table = 'transactions';
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

    public function headDebit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['dr_head_id', $head_id], ['dr_subhead_id', NULL], ['dr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function headCredit($head_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['cr_head_id', $head_id], ['cr_subhead_id', NULL], ['cr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumHeadBalance($head_id, $from_date = NULL, $end_date = NULL) {
        if (!is_null($from_date)) {
            $data = $this->headDebit($head_id, $from_date, $end_date) - $this->headCredit($head_id, $from_date, $end_date);
        } else {
            $data = $this->headDebit($head_id) - $this->headCredit($head_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function subheadDebit($subhead_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['dr_subhead_id', $subhead_id], ['dr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function subheadCredit($subhead_id, $from_date = NULL, $end_date = NULL) {
        $model = new Transaction();
        $query = $model->where([['cr_subhead_id', $subhead_id], ['cr_particular_id', NULL]]);
        if (!is_null($from_date)) {
            $query->whereBetween('date', [$from_date, $end_date]);
        }
        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumsubHeadBalance($subhead_id, $from_date = NULL, $end_date = NULL) {
        if (!is_null($from_date)) {
            $data = $this->subheadDebit($subhead_id, $from_date, $end_date) - $this->subheadCredit($subhead_id, $from_date, $end_date);
        } else {
            $data = $this->subheadDebit($subhead_id) - $this->subheadCredit($subhead_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumDebit($head_id = null) {
        if (!is_null($head_id)) {
            $data = Transaction::where('dr_head_id', $head_id)->sum('debit');
        } else {
            $data = Transaction::sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumDebitByDate($date, $head_id = null) {
        if (!is_null($head_id)) {
            $data = Transaction::where('head_id', $head_id)->sum('debit');
        }
        $data = Yii::app()->db->createCommand()->select('SUM(debit) as total')->where($_where)->from($this->tableName())->queryRow();
        return !empty($data['total']) ? doubleval($data['total']) : 0;
    }

    public function sumCredit($head_id = null) {
        if (!is_null($head_id)) {
            $data = Transaction::where('cr_head_id', $head_id)->sum('credit');
        } else {
            $data = Transaction::sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumBalance($head_id = null) {
        if (!is_null($head_id)) {
            $data = $this->sumDebit($head_id) - $this->sumCredit($head_id);
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

    public function sumPartDebit($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = Transaction::where('dr_particular_id', $particular_id)->sum('debit');
        } else {
            $data = Transaction::sum('debit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumPartCredit($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = Transaction::where('cr_particular_id', $particular_id)->sum('credit');
        } else {
            $data = Transaction::sum('credit');
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumPartBalance($particular_id = null) {
        if (!is_null($particular_id)) {
            $data = $this->sumPartDebit($particular_id) - $this->sumPartCredit($particular_id);
        }
        return !empty($data) ? doubleval($data) : 0;
    }

    public function head_debit_between_date($head_id, $from_date = null, $end_date = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('dr_head_id', $head_id)->orWhere('cr_head_id', $head_id);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumDebitBetweenDate($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('dr_head_id', $head_id);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumCreditBetweenDate($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where('cr_head_id', $head_id);
        }

        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumCreditReceiveVoucher($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', RECEIVE_VOUCHER], ['cr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', RECEIVE_VOUCHER);
        }

        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumDebitPaymentVoucher($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', PAYMENT_VOUCHER], ['dr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', PAYMENT_VOUCHER);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function totalPaymentByDate_Old($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['voucher_type', 'Payment Voucher'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['voucher_type', 'Payment Voucher'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalReceiveByDate_Old($date = null) {
        if (is_null($date)) {
            $dataset = $this->where([['voucher_type', 'Receive Voucher'], ['date', date('Y-m-d')]])->get();
        } else {
            $dataset = $this->where([['voucher_type', 'Receive Voucher'], ['date', $date]])->get();
        }
        return $dataset;
    }

    public function totalPaymentByDate($date = null, $head = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        if (is_null($date)) {
            if (is_null($head)) {
                $query = $query->where([['voucher_type', 'Payment Voucher'], ['date', date('Y-m-d')]]);
            } else {
                $query = $query->where([['voucher_type', 'Payment Voucher'], ['date', date('Y-m-d')], ['cr_head_id', $head]]);
            }
        } else {
            if (is_null($head)) {
                $query = $query->where([['voucher_type', 'Payment Voucher'], ['date', $date]]);
            } else {
                $query = $query->where([['voucher_type', 'Payment Voucher'], ['date', $date], ['cr_head_id', $head]]);
            }
        }
        return $query->get();
    }

    public function totalReceiveByDate($date = null, $head = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        if (is_null($date)) {
            if (is_null($head)) {
                $query = $query->where([['voucher_type', 'Receive Voucher'], ['date', date('Y-m-d')]]);
            } else {
                $query = $query->where([['voucher_type', 'Receive Voucher'], ['date', date('Y-m-d')], ['dr_head_id', $head]]);
            }
        } else {
            if (is_null($head)) {
                $query = $query->where([['voucher_type', 'Receive Voucher'], ['date', $date]]);
            } else {
                $query = $query->where([['voucher_type', 'Receive Voucher'], ['date', $date], ['dr_head_id', $head]]);
            }
        }
        return $query->get();
    }

    public function totalPaymentBetweenDate($from_date, $end_date, $head_id = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        $query = $query->whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', PAYMENT_VOUCHER], ['cr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', PAYMENT_VOUCHER);
        }
        return $query;
    }

    public function totalReceiveBetweenDate($from_date, $end_date, $head_id = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        $query = $query->whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', RECEIVE_VOUCHER], ['dr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', RECEIVE_VOUCHER);
        }
        return $query;
    }

    public function sumPaymentByDate($from_date, $end_date, $head_id = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        $query = $query->whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', PAYMENT_VOUCHER], ['cr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', PAYMENT_VOUCHER);
        }

        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumReceiveByDate($from_date, $end_date, $head_id = null, $institute_id) {
        $query = $this->where('institute_id', $institute_id);
        $query = $query->whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', RECEIVE_VOUCHER], ['dr_head_id', $head_id]]);
        } else {
            $query->where('voucher_type', RECEIVE_VOUCHER);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumSubPaymentVoucherBetweenDate($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', PAYMENT_VOUCHER], ['cr_subhead_id', $head_id]]);
        } else {
            $query->where('voucher_type', PAYMENT_VOUCHER);
        }

        $data = $query->sum('credit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function sumSubReceiveVoucherBetweenDate($from_date, $end_date, $head_id = null) {
        $query = Transaction::whereBetween('date', [$from_date, $end_date]);
        if (!is_null($head_id)) {
            $query->where([['voucher_type', RECEIVE_VOUCHER], ['dr_subhead_id', $head_id]]);
        } else {
            $query->where('voucher_type', RECEIVE_VOUCHER);
        }

        $data = $query->sum('debit');
        return !empty($data) ? doubleval($data) : 0;
    }

    public function debitClosingBySubHead($id) {
        $data = '';
        $sum_debit = $this->where('dr_subhead_id', $id)->sum('debit');
        $sum_credit = $this->where('cr_subhead_id', $id)->sum('credit');
        if ($sum_debit > $sum_credit) {
            $result = $sum_debit - $sum_credit;
        } else {
            $result = $data;
        }
        return $result;
    }

    public function creditClosingBySubHead($id) {
        $data = '';
        $sum_debit = $this->where('dr_subhead_id', $id)->sum('debit');
        $sum_credit = $this->where('cr_subhead_id', $id)->sum('credit');
        if ($sum_credit > $sum_debit) {
            $result = $sum_credit > $sum_debit;
        } else {
            $result = $data;
        }
        return $result;
    }

}
