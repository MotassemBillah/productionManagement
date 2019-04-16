<?php if (!empty($dataset) && count($dataset) > 0) : ?>
<div class="table-responsive" id="print_area">
        {{ print_header("Ledger Information") }}
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Head Name</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                </tr>
                <?php $counter = 0; ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $total_debit = 0;
                $total_credit = 0;
                $total_balance = 0;
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>
                        <span class="hip"><a href="{{ url('ledger/head/'.$data->id) }}">{{ $data->name }}</a></span>
                        <span class="show_in_print">{{ $data->name }}</span>
                    </td>
                    <td class="text-right">{{ $tmodel->headDebit($data->id, $from_date, $end_date) }}</td>
                    <td class="text-right">{{ $tmodel->headCredit($data->id, $from_date, $end_date) }}</td>
                    <td class="text-right">{{ $tmodel->sumHeadBalance($data->id, $from_date, $end_date) }}</td>                    
                </tr>
                <?php if (!empty($data->subhead)): ?> 
                    @foreach ($data->subhead as $item)
                    <?php
                    $total_debit += $_subdebit = $tmodel->subheadDebit($item->id, $from_date, $end_date);
                    $total_credit += $_subcredit = $tmodel->subheadCredit($item->id, $from_date, $end_date);
                    $total_balance += $_subbalance = $tmodel->sumsubHeadBalance($item->id, $from_date, $end_date);
                    ?>
                    <tr>
                        <td></td>
                        <td style="padding-left: 30px;" title="View All Transaction">
                            <span class="hip"><a href="{{ url('ledger/subhead/'.$item->id) }}">{{ $item->name }}</a></span>
                            <span class="show_in_print">{{ $item->name }}</span>
                        </td>
                        <td class="text-right">{{ $_subdebit }}</td>
                        <td class="text-right">{{ $_subcredit }}</td>
                        <td class="text-right">{{ $_subbalance }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th class="text-right" colspan="2">Sub Total:</th>
                        <th class="text-right">{{ $total_debit }}</th>
                        <th class="text-right">{{ $total_credit }}</th>
                        <th class="text-right">{{ $total_balance }}</th>
                    </tr>
                <?php endif; ?> 
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>