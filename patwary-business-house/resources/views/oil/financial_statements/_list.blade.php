{{ print_header("Financial Statement Report (".( date_dmy($from_date) ). ")") }}
<div class="table-responsive">
    <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
        <tbody>
            <tr>
                <td><strong>Opening Balance :</strong> {{ $opening_balance }}&nbsp;TK</td>
            </tr>
        </tbody>
    </table>
    <div class="clearfix">               
        <div class="col-md-6 mp_50" style="padding:0px 5px 0px 0px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="3">Receives</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Account</th>
                        <th class="text-right" style="width:10%;">Amount</th>
                    </tr>                  
                    <?php
                    $counter = 0;
                    $total_debit = 0;
                    ?>
                    @foreach ($receives as $receive)
                    <?php
                    $counter++;
                    $sum_debit = $modelTrans->sumSubReceiveVoucherBetweenDate($from_date, $end_date, $receive->dr_subhead_id);
                    $total_debit += $sum_debit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($receive->dr_particular_id) ? $receive->particular_name($receive->dr_particular_id) : $receive->subhead_name($receive->dr_subhead_id) }} </td>
                        <td class="text-right">{{ $sum_debit }}</td>
                    </tr>    
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="2">Total</th>
                        <th class="text-right">{{ $total_debit }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right mp_50" style="padding:0px 0px 0px 5px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="3">Payments</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Account</th>
                        <th class="text-right" style="width:10%;">Amount</th>
                    </tr>  
                    <?php
                    $counter = 0;
                    $total_credit = 0;
                    ?>
                    @foreach ($payments as $payment)
                    <?php
                    $counter++;
                    $sum_debit = $modelTrans->sumSubPaymentVoucherBetweenDate($from_date, $end_date, $payment->cr_subhead_id);
                    $total_credit += $sum_debit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($payment->cr_particular_id) ? $payment->particular_name($payment->cr_particular_id) : $payment->subhead_name($payment->cr_subhead_id) }} </td>
                        <td class="text-right">{{ $sum_debit }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="2">Total</th>
                        <th class="text-right">{{ $total_credit }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="clearfix" style="margin-top: 20px;">
    <table class="table table-bordered tbl_thin" style="margin: 0;">
        <tr class="">
            <th class="text-center">Total Receives : {{ $total_debit }} TK</th>
        </tr>
        <tr class="">
            <th class="text-center">Total Payments : {{ $total_credit }} TK</th>
        </tr>
        <tr class="bg-info">
            <th class="text-center">Closing Balance : {{ $closing_balance }} TK</th>
        </tr>
    </table>
</div>