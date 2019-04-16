@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-2 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('clear_view_cache')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-4 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv/purchase') }}">Purchase</a> <i class="fa fa-angle-right"></i></li>
            <li>Detail</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div id="print_area">
    <?php print_header("Purchase Detail", true, true); ?>

    <div class="row clearfix">
        <div class="col-md-3 col-sm-4 col-xs-6 mb_10 mp_50">
            <strong>Invoice Date : </strong>{{ change_lang(date_dmy($model->invoice_date)) }}<br>
            <strong>Invoice No : </strong>{{ change_lang($model->invoice_no) }}<br>
            <strong>Challan No : </strong>{{ change_lang($model->challan_no) }}<br>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-6 mb_10 mp_50 pull-right text-right">
            <strong>From : </strong> {{ $model->subhead_name($model->from_subhead_id) }} {{ !empty($model->from_particular_id) ? "-> " . $model->particular_name($model->from_particular_id) : "" }}<br>
            <strong>To : </strong> {{ $model->subhead_name($model->to_subhead_id) }} {{ !empty($model->to_particular_id) ? "-> " . $model->particular_name($model->to_particular_id) : "" }}<br>
            <strong>Print Date : </strong>{{ change_lang(print_date()) }}
        </div>
    </div>

    @if(!empty($model->items))
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin">
            <tr class="bg-info">
                <th class="text-center" style="width:4%">SL</th>
                <th>Company</th>
                <th>Business</th>
                <th>Category</th>
                <th>Product</th>
                <th class="text-center" style="width: 80px;">Quantity</th>
                <th class="text-center" style="width: 80px;">Rate</th>
                <th class="text-right" style="width: 100px;">Amount</th>
            </tr>
            <?php
            $_counter = 0;
            foreach ($model->items as $item):
                $_counter++;
                ?>
                <tr>
                    <td class="text-center"><?= change_lang($_counter); ?></td>
                    <td><?= !empty($item->institute) ? $item->institute->name : ""; ?></td>
                    <td><?= !empty($item->business_type) ? $item->business_type->business_type : ""; ?></td>
                    <td><?= $item->category->name; ?></td>
                    <td><?= $item->product->name; ?></td>
                    <td class="text-center"><?= change_lang($item->quantity); ?></td>
                    <td class="text-center"><?= change_lang($item->rate); ?></td>
                    <td class="text-right"><?= change_lang($item->amount); ?></td>
                </tr>
                <?php
                $_sumQty[] = $item->quantity;
                $_sumAmount[] = $item->amount;
            endforeach;
            ?>
            <tr class="bg-info">
                <th class="text-right" colspan="5">Total</th>
                <th class="text-center" style="width: 80px;"><?= change_lang(array_sum($_sumQty)); ?></th>
                <th class="text-center" style="width: 80px;"></th>
                <th class="text-right" style="width: 100px;"><?= change_lang(array_sum($_sumAmount)); ?></th>
            </tr>
        </table>
    </div>
    @endif

    <div class="row clearfix">
        <div class="col-md-4 col-sm-6 col-xs-12 mp_50 pull-left">
            <div class="mb_10">
                <strong>Note : </strong> <?= $model->note; ?>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12 mp_50 pull-right">
            <div class="mb_10">
                <table class="table table-bordered tbl_thin">
                    <tr>
                        <th>Invoice Amount</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->invoice_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Other Amount</th>
                        <td class="text-right" style="width: 100px"><?= change_lang(($model->transport_cost + $model->labor_cost + $model->other_cost)); ?></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->total_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Discount Amount</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->discount_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Payable</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->net_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Paid</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->paid_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Current Due</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($model->due_amount); ?></td>
                    </tr>
                    <tr>
                        <th>Previous Due</th>
                        <td class="text-right" style="width: 100px">
                            <?= ($particular_net_balance < 0) ? change_lang(($particular_net_balance + $model->due_amount)) : change_lang(($particular_net_balance - $model->due_amount)); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Net Balance</th>
                        <td class="text-right" style="width: 100px"><?= change_lang($particular_net_balance); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="form-group clearfix">
    <div class="text-center">
        <button class="btn btn-primary xsw_50" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
        <?php if ($model->process_status == ORDER_PROCESSED): ?>
            <a class="btn btn-info xsw_50" href="{{ url ('inv/purchase/payment')}}/<?= $model->_key; ?>"><i class="fa fa-dollar"></i> Pay Now</a>
        <?php endif; ?>
    </div>
</div>
@endsection