<div class="table-responsive">
    <h3 class="text-center well">{{ $head->find($head_id)->name }} | Ledger</h3>
    <div class="clearfix">
        <div class="col-md-6 col-sm-6 mp_50" style="padding:0;">
            <div class="table-responsive" style="margin: 0;">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Debit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th style="width:100px">Date</th>
                        <th style="width:180px">Account</th>
                        <th style="">Description</th>
                        <th class="text-right" style="width:13%;">Amount</th>
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
                        <td class="text-center" style="width:4%;">{{ $counter }}</td>
                        <td>{{ date_dmy($debit->date) }}</td>
                        <td>{{ !empty($debit->cr_subhead_id) ? $debit->subhead_name($debit->cr_subhead_id) : $debit->head_name($debit->cr_head_id) }} {{ !empty($debit->cr_particular_id) ? ' -> '.$debit->particular_name($debit->cr_particular_id) : '' }}</td>
                        <td class="" style="word-break:break-all;word-wrap:break-word;">{{ $debit->description }}</td>
                        <td class="text-right">{{ $debit->debit }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right">{{ $total_debit }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 mp_50" style="padding:0;">
            <div class="table-responsive" style="margin: 0;">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Credit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th style="width:100px">Date</th>
                        <th style="width:180px">Account</th>
                        <th style="">Description</th>
                        <th class="text-right" style="width:13%;">Amount</th>
                    </tr>
                    <?php
                    $counterc = 0;
                    $total_credit = 0;
                    ?>
                    @foreach ($all_credit as $credit)
                    <?php
                    $counterc++;
                    $total_credit += $credit->credit;
                    ?>
                    <tr>
                        <td class="text-center" style="width:4%;">{{ $counterc }}</td>
                        <td>{{ date_dmy($credit->date) }}</td>
                        <td>{{ !empty($credit->dr_subhead_id) ? $credit->subhead_name($credit->dr_subhead_id) : $credit->head_name($credit->dr_head_id) }} {{ !empty($credit->dr_particular_id) ? ' -> '.$credit->particular_name($credit->dr_particular_id) : '' }}</td>
                        <td class="" style="word-break:break-all;word-wrap:break-word;">{{ $credit->description }}</td>
                        <td class="text-right">{{ $credit->credit }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right">{{ $total_credit }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfix" style="">
        <table class="table table-bordered tbl_thin" style="margin: 0;">
            <tr class="bg-info">
                <th class="text-center">Total Debit : {{ $total_debit }} TK</th>
            </tr>
            <tr class="bg-info">
                <th class="text-center">Total Credit : {{ $total_credit }} TK</th>
            </tr>
            <tr class="bg-info">
                <th class="text-center">Balance : {{ $total_debit - $total_credit }} TK</th>
            </tr>
        </table>
    </div>
</div>