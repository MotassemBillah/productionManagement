<div class="table-responsive">
    <h3 class="text-center well">{{ $particular->name }} Ledger</h3>
    <div class="clearfix">                
        <div class="col-md-6 mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Debit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Description</th>
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
                        <td>{{ $debit->description }}</td>
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
        <div class="col-md-6 pull-right mp_50" style="padding:0;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Credit</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Description</th>
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
                        <?php
                        if ($credit->purchase_id) :
                            $items = [];
                            $weightInfo = new App\WeightItem;
                            $items = App\WeightItem::where('weight_id', $credit->purchase_id)->get();
                            ?>
                            <td style="padding:0;">
                                <table class="table table-bordered">
                                    @foreach ( $items as $item )
                                    <tr>
                                        <td>{{ $product->find($item->product_id)->name }} {{ $item->quantity }} = {{ floor(kgToMon($item->weight)) }} mon {{ kgToSher($item->weight)  }} sher * {{ $item->per_bag_price }} </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        <?php else: ?>
                            <td>{{ $credit->description }}</td>
                        <?php endif; ?>  
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
</div>
<div class="clearfix" style="margin-top: 20px;">
    <table class="table table-bordered tbl_thin" style="margin: 0;">
        <tr class="">
            <th class="text-center">Total Debit : {{ $total_debit }} TK</th>
        </tr>
        <tr class="">
            <th class="text-center">Total Credit : {{ $total_credit }} TK</th>
        </tr>
        <tr class="bg-info">
            <th class="text-center">Balance : {{ $total_debit - $total_credit }} TK</th>
        </tr>
    </table>
</div>