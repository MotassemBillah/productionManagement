<?php

use App\Models\Packaging\PurchaseChallan;
?>
@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Production</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => '', 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="invoice_no" class="col-md-5 text-right">SR No:</label>
            <input type="text" class="col-md-7" id="invoice_no" name="invoice_no" value="<?php echo PurchaseChallan::get_production_invoice(); ?>" readonly required>
        </div>
        <div class="mb_5 clearfix">
            <label for="production_type" class="col-md-5 text-right">Production Type:</label>
            <select class="col-md-7" name="production_type" required>
                <option value="">Select Production Type</option>
                @foreach (production_types() as $val)
                <option value="{{ $val }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<hr style="margin: 5px 0">
<div class="text-center"><strong>Product Information</strong></div>
<hr style="margin: 5px 0 10px">

<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <thead>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;"><input type="checkbox" id="check_all" value="all" name="check" style="margin: 0;"></th>
                <th>Category</th>
                <th>Product</th>
                <th>Unit</th>
                <th>Size</th>
                <th>Weight</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0; ?>
            @foreach ( $products as $product )
<?php $sl++; ?>
            <tr>
                <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="product[]" value="{{ $product->id }}"></td>
                <td>{{ $product->category->name }}<input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]"></td>
                <td>{{ $product->name }} <input type="hidden" value="{{ $product->id }}" name="product_id[{{ $product->id }}]" ></td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->weight }}</td>
                <td>
                    <input type="number" id="qty_{{ $product->id }}" name="quantity[{{ $product->id }}]" min="0" class="form-control qty" data-info="{{ $product->id }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnProduction">Save</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("submit", "#frm_purchase", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('packaging/production') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo('{{ url('packaging/production') }}')
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");
            e.preventDefault();
            return false;
        });

//        $(document).on("input", ".qty", function (e) {
//            var id = $(this).attr('data-info');
//            var qun = document.getElementById("qty_" + id).value;
//            var total_price = 0;
//            var per_qty_price = document.getElementById("per_price_" + id).value;
//            //console.log(bag_price);
//            if (isNaN(qun) || qun == '') {
//                qun = 1;
//            }
//            if (isNaN(per_qty_price) || per_qty_price == '') {
//                per_qty_price = 0;
//            }
//            total_price = qun * per_qty_price;
//            document.getElementById("net_price_" + id).value = total_price.toFixed(2);
//            e.preventDefault();
//        });
    });

</script>
@endsection