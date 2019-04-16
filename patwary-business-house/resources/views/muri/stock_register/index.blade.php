@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Stock Register Report</h2>
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
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:10px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('stock-register/search') }}";
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