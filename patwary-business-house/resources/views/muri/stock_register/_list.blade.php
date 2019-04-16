{{ print_header(" Stock Register Report ") }}
<div class="table-responsive">
    <div class="clearfix" style="margin-bottom: 20px;">
        <div class="col-md-6 mp_50" style="padding:0px 5px 0px 0px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="6">Purchase</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th class="text-center" style="width:20%;">Date</th>
                        <th class="text-center" style="width:30%;">Supplier</th>
                        <th class="text-right" style="width:25%;">Product</th>
                        <th class="text-right" style="width:10%;">Quantity</th>
                        <th class="text-right" style="width:10%;">Price</th>
                    </tr>  
                    <?php
                    $counter = 0;
                    $total_pqty = 0;
                    $total_pprice = 0;
                    ?>
                    @foreach ($purchases as $purchase)
                    <?php
                    $counter++;
                    $total_pqty += $purchase->quantity;
                    $total_pprice += $purchase->net_price;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td class="text-center">{{ date_dmy($purchase->date) }}</td>
                        <td>{{ !empty($purchase->subhead_id) ? $purchase->particularName($purchase->subhead_id) : $purchase->subHeadName($purchase->subhead_id) }} </td>
                        <td class="text-right">{{ !empty($purchase->product_id) ? $purchase->product_name($purchase->product_id) : '' }}</td>
                        <td class="text-right">{{ $purchase->quantity }}</td>
                        <td class="text-right">{{ $purchase->net_price }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right">{{ $total_pqty }}</th>
                        <th class="text-right">{{ $total_pprice }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right mp_50" style="padding:0px 0px 0px 5px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="6">Sales</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th class="text-center" style="width:20%;">Date</th>
                        <th class="text-center" style="width:30%;">Customer</th>
                        <th class="text-right" style="width:25%;">Product</th>
                        <th class="text-right" style="width:10%;">Quantity</th>
                        <th class="text-right" style="width:10%;">Price</th>
                    </tr>                  
                    <?php
                    $counter = 0;
                    $total_sqty = 0;
                    $total_sprice = 0;
                    ?>
                    @foreach ($sales as $sale)
                    <?php
                    $counter++;
                    $total_sqty += $sale->quantity;
                    $total_sprice += $sale->net_price;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td class="text-center">{{ date_dmy($sale->date) }}</td>
                        <td>{{ !empty($sale->subhead_id) ? $sale->particularName($sale->subhead_id) : $sale->subheadName($sale->head_id) }} </td>
                        <td class="text-right">{{ !empty($sale->after_production_id) ? $sale->after_product_name($sale->after_production_id) : '' }}</td>
                        <td class="text-right">{{ $sale->quantity }}</td>
                        <td class="text-right">{{ $sale->net_price }}</td>
                    </tr>    
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right">{{ $total_sqty }}</th>
                        <th class="text-right">{{ $total_sprice }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>