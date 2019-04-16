@extends('layouts.app')
@section('page_style')
@endsection
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Stocks Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Details</span></li>
        </ul>
    </div>
</div>
<div class="invoice_area" id="print_area">
    <?php print_header("Production Stocks Details"); ?>
    <?php
    $draws = json_decode($data->drawer_id);
    $dr_info = '';
    if (is_array($draws)) {
        foreach ($draws as $_key => $dr) {
            $drName = $drawer->find($dr)->name;
            if ($_key == (count($draws) - 1)) {
                $dr_info .= $drName;
            } else {
                $dr_info .= $drName . ", ";
            }
        }
    }
    ?> 
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:25%"><strong>Date:</strong> {{ date_dmy($data->date) }} </td>
            <td style="width:25%"><strong>PS No:</strong> {{ $data->production_stocks_no }}</td>
            <td style="width:25%"><strong>Drawer Name:</strong> <?= $dr_info; ?></span></td>
        </tr>
    </table>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Product Stocks Item</div>
                <div class="panel-body">
                    <div class="product_item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped tbl_thin" id="check">
                                        <tbody>
                                            <tr>
                                                <th class="text-center" style="width:5%;">SL#</th>
                                                <th>Product</th>
                                                <th>Net Weight</th>
                                                <th>Quantity</th>
                                            </tr>
                                            <?php
                                            $sl = 1;
                                            $total_net_weight = '';
                                            $total_quantity = '';
                                            ?>
                                            @foreach ($data->items as $product)
                                            <?php
                                            $total_net_weight += $product->weight;
                                            $total_quantity += $product->quantity;
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width:5%;">{{ $sl }}</td>
                                                <td>{{ !empty($product->after_production_id) ? $product->productName($product->after_production_id) : '' }}</td>
                                                <td class="text-right">{{ $product->weight }}</td>
                                                <td class="text-right">{{ $product->quantity }}</td>
                                                <?php $sl++; ?>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight:600;" class="text-right" colspan="2">Total</td>
                                                <td style="font-weight:600;" class="text-right" >{{ $total_net_weight }}</td>
                                                <td style="font-weight:600;" class="text-right" >{{ $total_quantity }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group text-center">
    <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
</div>
@endsection