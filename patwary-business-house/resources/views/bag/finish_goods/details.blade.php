@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Finish Goods Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Details</span></li>
        </ul>
    </div>
</div>
<div class="invoice_area" id="print_area">
    <?php print_header("Production Voucher",true,true); ?>
    <table class="table table-bordered tbl_thin" style="margin:0;">
        <tr>
            <td style="width:25%"><strong>Supplier :</strong> {{ !empty($data->person) ? $data->person : '' }}</td>
            <td style="width:25%"><strong>Invoice No :</strong> {{ $data->invoice_no }}</td>
            <td class="text-center" style="width:25%"><strong>Order No:</strong> {{ $data->challan_no}} </td>
            <td class="text-center" style="width:25%"><strong>Date:</strong> <?= ( Auth::user()->locale == 'bn' ) ? en2bnDate(date_dmy($data->date))  : date_dmy($data->date); ?> </td>
        </tr>
    </table>
    <div class="product_info">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check" style="margin-bottom:15px;">
                <tbody>
                    <tr>
                        <th colspan="9">Product Information :</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th class="text-right">Quantity</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $total_quantity = [];
                    ?>
                    @foreach ($data->items as $item)
                    <?php
                    $total_quantity[]= $item->quantity;
                    ?>
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $item->categoryName($item->finish_category_id) }}</td>
                        <td>{{ $item->productName($item->finish_product_id) }}</td>
                        <td class="text-right">{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber($item->quantity)  : $item->quantity }}</td>
                        <?php $sl++; ?>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th style="font-weight:600;" class="text-center" colspan="3">Total</th>
                        <th style="font-weight:600;" class="text-right" >{{ ( Auth::user()->locale == 'bn' ) ? en2bnNumber(array_sum($total_quantity))  : array_sum($total_quantity) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="text-center">
    <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
    <?php if ($data->process_status == 1) : ?>
        <button type="button" class="btn btn-info" id="getPaidBtn" data-info="<?= $data->id; ?>"><i class="fa fa-dollar"></i>&nbsp;Pay Now</button>
    <?php endif; ?>
</div>
<div class="modal fade" id="containerForPaymentInfo" tabindex="-1" role="dialog" aria-labelledby="containerForPaymentInfoLabel"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", "#getPaidBtn", function (e) {
            var _invc = $(this).attr("data-info");
            var _url = "{{ URL::to('purchase/payment_form') }}/" + _invc;

            $("#containerForPaymentInfo").load(_url, function () {
                $("#containerForPaymentInfo").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
            e.preventDefault();
        });
    });
</script>
@endsection