{{ print_header("Daily Report (".( date_dmy($date) ). ")") }}
<div class="table-responsive">
    <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
        <tbody>
            <tr>
                <td><strong>Opening Balance :</strong> {{ $opening_balance }}&nbsp;TK</td>
            </tr>
        </tbody>
    </table>
    <div class="clearfix" style="margin-bottom: 20px;">
        <div class="col-md-6 mp_50" style="padding:0px 5px 0px 0px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Purchase</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Supplier</th>
                        <th class="text-right" style="width:30%;">Product</th>
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
                        <td>{{ !empty($purchase->subhead_id) ? $purchase->particularName($purchase->subhead_id) : $purchase->subHeadName($purchase->subhead_id) }} </td>
                        <td class="text-right">{{ !empty($purchase->product_id) ? $purchase->product_name($purchase->product_id) : '' }}</td>
                        <td class="text-right">{{ $purchase->quantity }}</td>
                        <td class="text-right">{{ $purchase->net_price }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="3">Total</th>
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
                        <th class="text-center" colspan="5">Sales</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Customer</th>
                        <th class="text-right" style="width:30%;">Product</th>
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
                        <td>{{ !empty($sale->subhead_id) ? $sale->particularName($sale->subhead_id) : $sale->subheadName($sale->head_id) }} </td>
                        <td class="text-right">{{ !empty($sale->after_production_id) ? $sale->after_product_name($sale->after_production_id) : '' }}</td>
                        <td class="text-right">{{ $sale->quantity }}</td>
                        <td class="text-right">{{ $sale->net_price }}</td>
                    </tr>    
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="3">Total</th>
                        <th class="text-right">{{ $total_sqty }}</th>
                        <th class="text-right">{{ $total_sprice }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfix" style="margin-bottom: 20px;">
        <div class="col-md-6 mp_50" style="padding:0px 5px 0px 0px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Empty Bag Receives</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Customer</th>
                        <th class="text-right" style="width:10%;">Quantity</th>
                        <th class="text-right" style="width:18%;">Per Bag Price</th>
                        <th class="text-right" style="width:15%;">Total Price</th>
                    </tr>  
                    <?php
                    $counter = 0;
                    $total_ebqty = 0;
                    $total_ebprice = 0;
                    $total_ebpprice = 0;
                    ?>
                    @foreach ($empty_bag_rec as $rec)
                    <?php
                    $counter++;
                    $total_ebqty += $rec->quantity;
                    $total_ebprice += $rec->total_price;
                    $total_ebpprice += $rec->per_bag_price;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($rec->cr_particular_id) ? $rec->particular_name($rec->cr_particular_id) : $rec->subhead_name($rec->cr_subhead_id) }} </td>
                        <td class="text-right">{{ $rec->quantity }}</td>
                        <td class="text-right">{{ $rec->per_bag_price }}</td>
                        <td class="text-right">{{ $rec->total_price }}</td>
                    </tr>   
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="2">Total</th>
                        <th class="text-right">{{ $total_ebqty }}</th>
                        <th class="text-right">{{ $total_ebpprice }}</th>
                        <th class="text-right">{{ $total_ebprice }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6 pull-right mp_50" style="padding:0px 0px 0px 5px;">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center" colspan="5">Empty Bag Payments</th>
                    </tr>
                    <tr class="bg_gray">
                        <th class="text-center" style="width:4%;">SL</th>
                        <th>Customer</th>
                        <th class="text-right" style="width:30%;">Quantity</th>
                        <th class="text-right" style="width:18%;">Per Bag Price</th>
                        <th class="text-right" style="width:15%;">Total Price</th>
                    </tr>                  
                    <?php
                    $counter = 0;
                    $total_ebpqty = 0;
                    $total_ebpbprice = 0;
                    $total_ebtprice = 0;
                    ?>
                    @foreach ($empty_bag_pay as $pay)
                    <?php
                    $counter++;
                    $total_ebpqty += $pay->quantity;
                    $total_ebpbprice += $pay->per_bag_price;
                    $total_ebtprice += $pay->total_price;
                    ?>
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{ !empty($pay->dr_particular_id) ? $pay->particular_name($pay->dr_particular_id) : $pay->subhead_name($pay->dr_subhead_id) }} </td>
                        <td class="text-right">{{ $pay->quantity }}</td>
                        <td class="text-right">{{ $pay->per_bag_price }}</td>
                        <td class="text-right">{{ $pay->total_price }}</td>
                    </tr>    
                    @endforeach
                    <tr class="bg-info">
                        <th class="text-right" colspan="2">Total</th>
                        <th class="text-right">{{ $total_ebpqty }}</th>
                        <th class="text-right">{{ $total_ebpbprice }}</th>
                        <th class="text-right">{{ $total_ebtprice }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
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
