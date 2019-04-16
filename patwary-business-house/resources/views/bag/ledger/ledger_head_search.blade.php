<?php
$sum_debit = $all_debit->sum('debit');
$sum_credit = $all_credit->sum('credit');
$dr_opening = 0;
$cr_opening = 0;
$dr_closing = 0;
$cr_closing = 0;
$counter = 0;
$total_credit = 0;
$balance = 0;
$dr_class = '';
$cr_class = '';
if ($sum_debit > $sum_credit) {
    $cr_opening = $sum_debit - $sum_credit;
    $dr_closing = $cr_opening;
    $balance = $sum_debit;
    $dr_class = 'hide';
} else {
    $dr_opening = $sum_credit - $sum_debit;
    $cr_closing = $dr_opening;
    $balance = $sum_credit;
    $cr_class = 'hide';
}
?>
<div class="table-responsive">
    <h3 class="text-center well">{{ $head->find($head_id)->name }} Ledger</h3>
    <div class="clearfix">                
        <div class="col-md-6 mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="4">Debit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th class="text-right" style="width:15%;">Amount</th>
                    </tr>  
                    <?php
                    $counter = 0;
                    $total_debit = 0;
                    ?>
                    @foreach ($all_debit as $debit)
                    <?php
                    $counter++;
                    $total_debit += $debit->debit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ date_dmy($debit->pay_date) }}</td>
                        <td>{{ !empty($debit->cr_subhead_id) ? $debit->subhead_name($debit->cr_subhead_id) : $debit->head_name($debit->cr_head_id) }} {{ !empty($debit->cr_particular_id) ? ' -> '.$debit->particular_name($debit->cr_particular_id) : '' }}</td>
                        <td class="text-right">{{ $debit->debit }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="3">Total</th>
                        <th class="text-right">{{ $total_debit }}</th>
                    </tr>
                </table>
            </div>
        </div> 
        <div class="col-md-6 pull-right mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="4">Credit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th class="text-right" style="width:15%;">Amount</th>
                    </tr>                  
                    <?php
                    $counter = 0;
                    $total_credit = 0;
                    ?>
                    @foreach ($all_credit as $credit)
                    <?php
                    $counter++;
                    $total_credit += $credit->credit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ date_dmy($credit->pay_date) }}</td>
                        <td>{{ !empty($credit->dr_subhead_id) ? $credit->subhead_name($credit->dr_subhead_id) : $credit->head_name($credit->dr_head_id) }} {{ !empty($credit->dr_particular_id) ? ' -> '.$credit->particular_name($credit->dr_particular_id) : '' }}</td>
                        <td class="text-right">{{ $credit->credit }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="3">Total</th>
                        <th class="text-right">{{ $total_credit }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table tbl_remove_border">
            <tr class="">
                <th class="text-right"><span class="{{ $dr_class }}">Debit Opening Balance :</span></th>
                <th class="text-right"><span class="{{ $dr_class }}">{{ $dr_opening }}</span></th>
                <th class="text-right"><span class="{{ $cr_class }}">Credit Opening Balance :</span></th>
                <th class="text-right"><span class="{{ $cr_class }}">{{ $cr_opening }}</span></th>
            </tr>
            <tr class="bg-info">
                <th class="text-right">Balance :</th>
                <th class="text-right">{{ $balance }}</th>
                <th class="text-right">Balance :</th>
                <th class="text-right">{{ $balance }}</th>
            </tr>
            <tr class="">
                <th class="text-right"><span class="{{ $cr_class }}">Debit Closing Balance :</span></th>
                <th class="text-right"><span class="{{ $cr_class }}">{{ $dr_closing }}</span></th>
                <th class="text-right"><span class="{{ $dr_class }}">Credit Closing Balance :</span></th>
                <th class="text-right"><span class="{{ $dr_class }}">{{ $cr_closing }}</span></th>
            </tr>
        </table>
    </div>
</div>
