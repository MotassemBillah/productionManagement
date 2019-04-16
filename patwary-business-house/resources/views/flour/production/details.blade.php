@extends('admin.layouts.column2')
@section('page_style')
@endsection
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li>
            <li>Details</li>
        </ul>
    </div>
</div>
<div class="invoice_area" id="print_area">
    <?php print_header("Production Order Details"); ?>
    <?php
    if ($data->process_status == 0) {
        $status = 'Pending';
        $_color = 'color:#ef9f5c';
    } else {
        $status = 'Completed';
        $_color = 'color:#0cc10c';
    }
    ?>
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:25%"><strong>Order:</strong> {{ $data->order_no }}</td>
            <td class="text-center" style="width:25%"><strong>Date:</strong> {{ date_dmy($data->date) }} </td>
            <td class="text-right" style="width:25%"><strong>Status:</strong> <span style="<?= $_color; ?>">{{ $status}}</span></td>
        </tr>
    </table>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Product Information</div>
                <div class="panel-body">
                    <div class="product_item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="check">
                                        <tbody>
                                            <tr>
                                                <th class="text-center" style="width:5%;">SL#</th>
                                                <th>Category</th>
                                                <th>Product Name</th>
                                                <th>Drawer Name</th>
                                                <th class="text-right">Net Weight</th>
                                                <th class="text-right">Quantity</th>
                                            </tr>
                                            <?php
                                            $sl = 1;
                                            $total_net_weight = 0;
                                            $total_quantity = 0;
                                            ?>
                                            @foreach ($data->items as $product)
                                            <?php
                                            $total_net_weight += $product->net_weight;
                                            $total_quantity += $product->net_quantity;
                                            ?>
                                            <tr>
                                                <td class="text-center" style="width:5%;">{{ $sl }}</td>
                                                <td>{{ $product->categoryName($product->category_id) }}</td>
                                                <td>{{ $product->productName($product->product_id) }}</td>
                                                <td>{{ $product->drawerName($product->drawer_id) }}</td>
                                                <td class="text-right">{{ $product->net_weight }}</td>
                                                <td class="text-right">{{ $product->net_quantity }}</td>
                                                <?php $sl++; ?>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td style="font-weight:600;" class="text-right" colspan="4">Total</td>
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