@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Purchase Challan Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">></span></li>
            <li><span><i class="fa fa-file"></i> Purchase Challan</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => 'flour/purchase-challan', 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-5">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Supplier</label>
            <select class="col-md-7" id="supplierSubhead" name="supplier_subhead">
                <option value="">Select Supplier</option>
                @foreach($subheads as $subhead)
                <option value="{{$subhead->id}}">{{$subhead->name}}</option>
                @endforeach
            </select>           
        </div>
        <div class="mb_5 clearfix">
            <label for="supplierParticular" class="col-md-5 text-right"></label>
            <select class="col-md-7" id="supplierParticular" name="supplier_particular" disabled>
                <option value="">Select Supplier First</option>
            </select>
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
            <label class="col-md-5 text-right">Slip No:</label>
            <input type="text" class="col-md-7" id="slip_no" name="slip_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Transport Agency:</label>
            <input type="text" class="col-md-7" id="transport_agency" name="transport_agency">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Truck Rent:</label>
            <input type="number" class="col-md-7" id="truck_rent" name="truck_rent">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Comments:</label>
            <textarea name="comments" class="col-md-7"></textarea>
        </div>
    </div>
    <div class="col-md-5">
        <div class="mb_5 clearfix">
            <label for="category" class="col-md-5 text-right">Category :</label>
            <select class="col-md-7" id="category" name="category" required>
                <option value="">Select Category</option>
                @foreach( $categories as $category )
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="product" class="col-md-5 text-right">Product :</label>
            <select class="col-md-7" id="productList" name="product" disabled>
                <option value="">Select Category First</option>
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="challan_weight" class="col-md-5 text-right">Challan Weight:</label>
            <input type="number" class="col-md-7" id="challan_weight" name="challan_weight" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="scale_weight" class="col-md-5 text-right">Scale Weight:</label>
            <input type="number" class="col-md-7 qty" id="scale_weight" name="scale_weight" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="bag_quantity" class="col-md-5 text-right">Bag Quantity:</label>
            <input type="number" class="col-md-7 qty" id="bag_quantity" name="bag_quantity" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="empty_bag_weight" class="col-md-5 text-right">Empty Bag Weight:</label>
            <input type="number" class="col-md-7 qty" id="empty_bag_weight" name="empty_bag_weight" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="net_weight" class="col-md-5 text-right">Net Weight:</label>
            <input type="number" class="col-md-7" id="net_weight" name="net_weight" step="any" readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="per_kg_price" class="col-md-5 text-right">Per Kg Price:</label>
            <input type="number" class="col-md-7 qty" id="per_kg_price" name="per_kg_price" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="total_price" class="col-md-5 text-right">Total Price:</label>
            <input type="number" class="col-md-7" id="total_price" name="total_price" step="any" readonly>
        </div>
    </div>
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

        $(document).on("change", "#category", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('inv/list_product') }}",
                type: "post",
                data: {'category': id, 'type': 'Raw', '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#productList");
                    $('#productList').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

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
            var bag_quantity = document.getElementById("bag_quantity").value;
            var empty_bag_weight = document.getElementById("empty_bag_weight").value;
            var scale_weight = document.getElementById("scale_weight").value;
            var per_kg_price = document.getElementById("per_kg_price").value;
            var net_weight = 0;
            var total_price = 0;
            if (isNaN(empty_bag_weight) || empty_bag_weight == '') {
                empty_bag_weight = '';
            }
            if (isNaN(per_kg_price) || per_kg_price == '') {
                per_kg_price = 1;
            }
            if (isNaN(scale_weight) || scale_weight == '') {
                scale_weight = 1;
            }
            if (isNaN(bag_quantity) || bag_quantity == '') {
                bag_quantity = 1;
            }
            //total_empty_bag_weight = bag_quantity * empty_bag_weight;
            net_weight = scale_weight - empty_bag_weight;
            total_price = net_weight * per_kg_price;
            document.getElementById("empty_bag_weight").value = empty_bag_weight;
            document.getElementById("net_weight").value = net_weight;
            document.getElementById("total_price").value = total_price;
            e.preventDefault();
        });

    });

</script>
@endsection