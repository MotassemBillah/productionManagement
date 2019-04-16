@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Daily Report</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Daily</span></li>
        </ul>                            
    </div>
</div>
<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!}                   
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <div style="width:17%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="date" placeholder="(dd-mm-yyyy)" value="<?= date('d-m-Y'); ?>" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:25%">
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show List-->
<div id="print_area">
    <div id="ajax_content">
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('dailyreport/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function () {
                    $('#ajaxMessage').showAjaxMessage({html: 'There is some error.Try after some time.', type: 'error'});
                }
            });

        });
    });
</script>

@endsection