@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Purchase Challan Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Details</span></li>
        </ul>
    </div>
</div>
<div class="invoice_area" id="print_area">
    <?php print_header("Purchase Challan", true, true); ?>
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:20%"><strong>Date:</strong> <?= ( Auth::user()->locale == 'bn' ) ? en2bnDate(date_dmy($data->date)) : date_dmy($data->date); ?> </td>
            <td style="width:20%"><strong>Challan No:</strong> {{ $data->challan_no}} </td>
            <td style="width:20%"><strong>Slip No :</strong> {{ $data->slip_no }}</td>
            <td style="width:20%"><strong>Supplier :</strong> {{ !empty($data->supplier_particular) ?  $data->particularName($data->supplier_particular) : '' }}</td>
            <td style="width:20%"><strong>Transport Agency :</strong> {{ $data->transport_agency }}</td>
        </tr>
    </table>
    <div class="product_info">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check" style="margin-bottom:15px;">
                <tbody>
                    <tr>
                        <th colspan="9">Purchase Challan Information :</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <th>Product</th>
                        <th class="text-right">Bag Quantity</th>
                        <th class="text-right">Net Weight</th>
                        <th class="text-right">Net Mon</th>
                        <th class="text-right">Per Mon Price</th>
                        <th class="text-right">Total Price</th>
                        <th class="text-right">Truck Rent</th>
                    </tr>
                    <tr>
                        <td>{{ $data->categoryName($data->category_id) }}</td>
                        <td>{{ $data->productName($data->product_id) }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->bag_quantity)  : $data->bag_quantity }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->net_weight)  : $data->net_weight }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->net_mon)  : $data->net_mon }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->per_mon_price)  : $data->per_mon_price }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->total_price)  : $data->total_price }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($data->truck_rent)  : $data->truck_rent }}</td>
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
<div class="text-center">
    <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
</div>
@endsection