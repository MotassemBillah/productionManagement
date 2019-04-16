@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales Challan Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Details</span></li>
        </ul>
    </div>
</div>
<div class="invoice_area" id="print_area">
    <div class="office_copy" style="border-bottom:1px solid #ccc;margin-bottom:100px;padding-bottom:20px;">
    <?php print_header("Sales Challan (Office Copy)", true, true); ?>
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:17%"><strong>Date:</strong> <?= ( Auth::user()->locale == 'bn' ) ? en2bnDate(date_dmy($data->date)) : date_dmy($data->date); ?> </td>
            <td style="width:17%"><strong>Customer :</strong> {{ !empty($data->supplier_particular) ?  $data->particularName($data->supplier_particular) : '' }}</td>
            <td style="width:17%"><strong>Order No :</strong> {{ $data->order_no }}</td>
            <td style="width:17%"><strong>Challan No:</strong> {{ $data->challan_no}} </td>
            <td style="width:17%"><strong>Track No:</strong> {{ $data->truck_no}} </td>
            <td style="width:17%"><strong>Transport Info:</strong> {{ $data->transport_info}} </td>
        </tr>
    </table>
    <div class="product_info">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check" style="margin-bottom:15px;">
                <tbody>
                    <tr>
                        <th colspan="9">Sales Challan Information :</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <th>Product</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Per Qty Price</th>
                        <th class="text-right">Total Price</th>
                    </tr>
                    @foreach ($data->items as $dat)
                    <?php
                    $total_quantity[] = $dat->quantity;
                    $total_qty_price[] = $dat->per_qty_price;
                    $total_price[] = $dat->total_price;
                    ?>   
                    <tr>
                        <td>{{ $dat->categoryName($dat->category_id) }}</td>
                        <td>{{ $dat->productName($dat->product_id) }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->quantity)  : $dat->quantity }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->per_qty_price)  : $dat->per_qty_price }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->total_price)  : $dat->total_price }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_quantity))  : array_sum($total_quantity) }}</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_qty_price))  : array_sum($total_qty_price) }}</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_price))  : array_sum($total_price) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row clearfix" style="padding-top:30px;">
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Customer</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
            </div>
        </div>
    </div>
    </div>
    <div class="customer_copy show_in_print">
    <?php print_header("Sales Challan (Customer Copy)"); ?>
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:17%"><strong>Date:</strong> <?= ( Auth::user()->locale == 'bn' ) ? en2bnDate(date_dmy($data->date)) : date_dmy($data->date); ?> </td>
            <td style="width:17%"><strong>Customer :</strong> {{ !empty($data->supplier_particular) ?  $data->particularName($data->supplier_particular) : '' }}</td>
            <td style="width:17%"><strong>Order No :</strong> {{ $data->order_no }}</td>
            <td style="width:17%"><strong>Challan No:</strong> {{ $data->challan_no}} </td>
            <td style="width:17%"><strong>Track No:</strong> {{ $data->truck_no}} </td>
            <td style="width:17%"><strong>Transport Info:</strong> {{ $data->transport_info}} </td>
        </tr>
    </table>
    <div class="product_info">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check" style="margin-bottom:15px;">
                <tbody>
                    <tr>
                        <th colspan="9">Sales Challan Information :</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <th>Product</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Per Qty Price</th>
                        <th class="text-right">Total Price</th>
                    </tr>
                    @foreach ($data->items as $dat)
                    <?php
                    $total_quantity[] = $dat->quantity;
                    $total_qty_price[] = $dat->per_qty_price;
                    $total_price[] = $dat->total_price;
                    ?>   
                    <tr>
                        <td>{{ $dat->categoryName($dat->category_id) }}</td>
                        <td>{{ $dat->productName($dat->product_id) }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->quantity)  : $dat->quantity }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->per_qty_price)  : $dat->per_qty_price }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($dat->total_price)  : $dat->total_price }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_quantity))  : array_sum($total_quantity) }}</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_qty_price))  : array_sum($total_qty_price) }}</th>
                        <th class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_price))  : array_sum($total_price) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row clearfix" style="padding-top:30px;">
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Customer</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
            </div>
        </div>
    </div>
    </div>
</div>
<div class="text-center">
    <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
</div>
@endsection