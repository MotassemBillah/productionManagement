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

{!! Form::open(['method' => 'POST', 'url' => 'packaging/sales-challan', 'id'=>'frm_sales', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-6">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" name="challan_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Order No:</label>
            <input type="text" class="col-md-7" id="order_no" name="order_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Track No:</label>
            <input type="text" class="col-md-7" id="truck_no" name="truck_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Transport Info:</label>
            <input type="text" class="col-md-7" id="transport_info" name="transport_info">
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
            <small class="text-danger">{{ $errors->first('supplier_subhead') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label for="supplierParticular" class="col-md-5 text-right"></label>
            <select class="col-md-7" id="supplierParticular" name="supplier_particular" disabled>
                <option value="">Select Customer First</option>
            </select>
            <small class="text-danger">{{ $errors->first('supplier_particular') }}</small>
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
                <th class="text-center">Quantity</th>
                <th class="text-center">Per Unit Price</th>
                <th class="text-center">Total Price</th>
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
                <td>{{ $product->category->name }} <input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]"></td>
                <td>{{ $product->name }} <input type="hidden" value="{{ $product->id }}" name="product_id[{{ $product->id }}]" ></td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->weight }}</td>
                <td>
                    <input type="number" step="any" id="qty_{{ $product->id }}" name="bag_quantity[{{ $product->id }}]" class="form-control qty" data-info="{{ $product->id }}">
                </td>
                <td>
                    <input type="number" step="any" id="per_price_{{ $product->id }}" name="per_qty_price[{{ $product->id }}]" min="0" class="form-control qty" data-info="{{ $product->id }}">
                </td>
                <td>
                    <input type="number" step="any" id="net_price_{{ $product->id }}" name="total_price[{{ $product->id }}]" class="form-control" readonly>
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
            <button type="submit" class="btn btn-primary" id="btnSales">Save</button>
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
        
           $(document).on("input", ".qty", function (e) {
            var id = $(this).attr('data-info');
            var qun = document.getElementById("qty_" + id).value;
            var total_price = 0;
            var per_qty_price = document.getElementById("per_price_" + id).value;
            //console.log(bag_price);
            if (isNaN(qun) || qun == '') {
                qun = 1;
            }
            if (isNaN(per_qty_price) || per_qty_price == '') {
                per_qty_price = 0;
            }
            total_price = qun * per_qty_price;
            document.getElementById("net_price_" + id).value = total_price.toFixed(2);
            e.preventDefault();
        });
    });

</script>
@endsection