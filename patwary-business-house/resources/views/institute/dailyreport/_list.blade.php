{{ print_header("Daily Report (".( date_dmy($date) ). ")") }}
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
                        <th class="text-center" colspan="5">Receives</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Customer</th>
                        <th class="" style="width:30%;">Description</th>
                        <th class="text-right" style="width:10%;">Amount</th>
                    </tr>                  
                    <?php
                    $counter = 0;
                    $total_debit = 0;
                    ?>
                    @foreach ($receives as $receive)
                    <?php
                    $counter++;
                    $total_debit += $receive->debit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($receive->cr_particular_id) ? $receive->particular_name($receive->cr_particular_id) : $receive->subhead_name($receive->cr_subhead_id) }} </td>
                        <td class="">{{ $receive->description }}</td>
                        <td class="text-right">{{ $receive->credit }}</td>
                    </tr>    
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="3">Total</th>
                        <th class="text-right">{{ $total_debit }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right mp_50" style="padding:0px 0px 0px 5px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Payments</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Account</th>
                        <th class="" style="width:30%;">Description</th>
                        <th class="text-right" style="width:10%;">Amount</th>
                    </tr>  
                    <?php
                    $counter = 0;
                    $total_credit = 0;
                    ?>
                    @foreach ($payments as $payment)
                    <?php
                    $counter++;
                    $total_credit += $payment->credit;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($payment->dr_particular_id) ? $payment->particular_name($payment->dr_particular_id) : $payment->subhead_name($payment->dr_subhead_id) }} </td>
                        <td class="">{{ $payment->description }}</td>
                        <td class="text-right">{{ $payment->credit }}</td>
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
