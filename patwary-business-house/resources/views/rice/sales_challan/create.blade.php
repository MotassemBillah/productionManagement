@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales Challan Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sales</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => 'rice/sales-challan', 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-6">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Dokan Slip No:</label>
            <input type="text" class="col-md-7" id="slip_no" name="slip_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Track No:</label>
            <input type="text" class="col-md-7" id="truck_no" name="truck_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" name="challan_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">D/O No:</label>
            <input type="text" class="col-md-7" id="voucher_no" name="voucher_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Comments:</label>
            <textarea name="comments" class="col-md-7"></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Customer</label>
            <select class="col-md-7" id="supplierSubhead" name="supplier_subhead" required>
                <option value="">Select Customer</option>
                @foreach($subheads as $subhead)
                <option value="{{$subhead->id}}">{{$subhead->name}}</option>
                @endforeach
            </select>           
        </div>
        <div class="mb_5 clearfix">
            <label for="supplierParticular" class="col-md-5 text-right"></label>
            <select class="col-md-7" id="supplierParticular" name="supplier_particular" disabled>
                <option value="">Select Customer First</option>
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
                <th class="text-center">Bag Quantity</th>
                <th class="text-center">Scale Weight</th>
                <th class="text-center">Track Weight</th>
                <th class="text-center">Net Weight</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0; ?>
            @foreach ( $products->all() as $product )
            <?php
            $sl++;
            ?>
            <tr>
                <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="product[]" value="{{ $product->id }}"></td>                 
                <td>{{ $category->find($product->category_id)->name }} <input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]"></td>
                <td>{{ $products->find($product->id)->name }} <input type="hidden" value="{{ $product->id }}" name="product_id[{{ $product->id }}]" ></td>
                <td class="text-center">
                    <input type="number" step="any" name="bag_quantity[{{ $product->id }}]" class="form-control text-center">
                </td>
                <td class="text-center">
                    <input type="number" id="scale_weight_{{ $product->id }}" data-id="{{ $product->id }}" step="any" name="scale_weight[{{ $product->id }}]" class="form-control text-center weight">
                </td>
                <td class="text-center">
                    <input type="number" id="track_weight_{{ $product->id }}" data-id="{{ $product->id }}" step="any" name="track_weight[{{ $product->id }}]" class="form-control text-center weight">
                </td>
                <td class="text-center">
                    <input type="number" id="net_weight_{{ $product->id }}" data-id="{{ $product->id }}" step="any" name="net_weight[{{ $product->id }}]" class="form-control text-center" readonly>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12" style="margin-top: 20px; ">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnPurchase">Save</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#supplierSubhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#supplierParticular");
                    $('#supplierParticular').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });
        $(document).on("input", ".weight", function (e) {
            var id = $(this).attr("data-id");
            var scale_weight = parseFloat(document.getElementById("scale_weight_" + id).value);
            var track_weight = parseFloat(document.getElementById("track_weight_" + id).value);
            var net_weight = 0;
            if (isNaN(scale_weight) || scale_weight == '') {
                scale_weight = 0;
            }
            if (isNaN(track_weight) || track_weight == '') {
                track_weight = 0;
            }
            net_weight = scale_weight - track_weight;
            document.getElementById("net_weight_" + id).value = net_weight;
            e.preventDefault();
        });
    });

</script>
@endsection