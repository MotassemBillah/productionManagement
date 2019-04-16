<div class="table-responsive">
    <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
        <tr>
            <td><strong>Opening Balance :</strong> <?= $opening_balance; ?>&nbsp;TK</td>
        </tr>
    </table>
    <div class="clearfix">
        <div class="col-md-6 mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="3">Debit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Account Name</th>
                        <th class="text-right" style="width:15%;">Debit</th>
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
                        <td>{{ !empty($debit->dr_subhead_id) ? $debit->subhead_name($debit->dr_subhead_id) : $debit->head_name($debit->dr_head_id) }} {{ !empty($debit->dr_particular_id) ? ' -> '.$debit->particular_name($debit->dr_particular_id) : '' }}</td>
                        <td class="text-right">{{ $debit->debit }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="2">Total</th>
                        <th class="text-right">{{ $total_debit }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="3">Credit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Name</th>
                        <th class="text-right" style="width:15%;">Credit</th>
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
                        <td>{{ !empty($credit->cr_subhead_id) ? $credit->subhead_name($credit->cr_subhead_id) : $credit->head_name($credit->cr_head_id) }} {{ !empty($credit->cr_particular_id) ? ' -> '.$credit->particular_name($credit->cr_particular_id) : '' }}</td>
                        <td class="text-right">{{ $credit->credit }}</td>
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
    <table class="table table-bordered tbl_invoice_view">
        <tr>
            <td class="text-center"><strong>Total Debit : </strong>{{ !empty($total_debit) ? $total_debit : '' }} TK</td>
        </tr>
        <tr>
            <td class="text-center"><strong>Total Credit : </strong>{{ !empty($total_credit) ? $total_credit : '' }} TK</td>
        </tr>
        <tr>
            <td class="text-center"><strong>Closing Balance : </strong>{{ $closing_balance }}  TK</td>
        </tr>
    </table>
</div>