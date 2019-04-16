@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Purchase Challan</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">></span></li>
            <li><span>Purchase Challan</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'PUT', 'url' => 'rice/purchase-challan/'.$data->id, 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-5">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="{{ date_dmy($data->date) }}" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Supplier</label>
            <select class="col-md-7" id="supplierSubhead" name="supplier_subhead" required>
                <option value="">Select Supplier</option>
                @foreach($subheads as $subhead)
                <option value="{{$subhead->id}}"  @if($data->supplier_subhead == $subhead->id) {{ 'selected' }} @endif>{{$subhead->name}}</option>
                @endforeach
            </select> 
        </div>
        <div class="mb_5 clearfix">
            <label for="supplierParticular" class="col-md-5 text-right"></label>
            <select class="col-md-7" id="supplierParticular" name="supplier_particular" required>
                @foreach($particulars as $particular)
                <option value="{{$particular->id}}" @if($data->supplier_particular == $particular->id) {{ 'selected' }} @endif>{{$particular->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="category" class="col-md-5 text-right">Category :</label>
            <select class="col-md-7" id="category" name="category" required>
                <option value="">Select Head</option>
                @foreach( $categories as $category )
                <option value="{{ $category->id }}" @if($data->category_id == $category->id) {{ 'selected' }} @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="product" class="col-md-5 text-right">Product :</label>
            <select class="col-md-7" id="productList" name="product" required>
                @foreach( $products as $product )
                <option value="{{ $product->id }}" @if($data->product_id == $product->id) {{ 'selected' }} @endif>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Track No:</label>
            <input type="text" class="col-md-7" id="truck_no" value="{{ $data->truck_no }}" name="truck_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" value="{{ $data->challan_no }}" name="challan_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Slip No:</label>
            <input type="text" class="col-md-7" id="slip_no" value="{{ $data->slip_no }}" name="slip_no">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Transport Agency:</label>
            <input type="text" class="col-md-7" id="transport_agency" value="{{ $data->transport_agency }}" name="transport_agency">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Truck Rent:</label>
            <input type="number" class="col-md-7" id="truck_rent" value="{{ $data->truck_rent }}" name="truck_rent">
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Comments:</label>
            <textarea name="comments" class="col-md-7">{{ $data->comments }}</textarea>
        </div>
    </div>
    <div class="col-md-5">
        <div class="mb_5 clearfix">
            <label for="challan_weight" class="col-md-5 text-right">Challan Weight:</label>
            <input type="number" class="col-md-7 qty" id="challan_weight" name="challan_weight" value="{{ $data->challan_weight }}" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="scale_weight" class="col-md-5 text-right">Scale Weight:</label>
            <input type="number" class="col-md-7 qty" id="scale_weight" name="scale_weight" value="{{ $data->scale_weight }}" step="any" required>
        </div>
        <div class="mb_5 clearfix">
            <label for="main_weight" class="col-md-5 text-right">Main Weight:</label>
            <input type="number" class="col-md-7 qty" id="main_weight" name="main_weight" value="{{ $data->main_weight }}" step="any" readonly>
            <small class="text-danger">{{ $errors->first('main_weight') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label for="bag_quantity" class="col-md-5 text-right">Bag Quantity:</label>
            <input type="number" class="col-md-7 qty" id="bag_quantity" name="bag_quantity" value="{{ $data->bag_quantity }}" step="any" required>
        </div>
        <div class="mb_5 clearfix">
            <label for="empty_bag_total_weight" class="col-md-5 text-right">Empty Bag Weight:</label>
            <input type="hidden" class="col-md-7" id="empty_bag_weight" value="{{ $empty_bag_weight }}">
            <input type="number" class="col-md-7" id="empty_bag_total_weight" name="empty_bag_weight" value="{{ $data->empty_bag_weight }}" step="any" readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="dhorla" class="col-md-5 text-right">Dhorla:</label>
            <input type="number" class="col-md-7 qty" id="dhorla" name="dhorla" value="{{ $data->dhorla }}" step="any">
        </div>
        <div class="mb_5 clearfix">
            <label for="net_weight" class="col-md-5 text-right">Net Weight:</label>
            <input type="number" class="col-md-7" id="net_weight" name="net_weight" value="{{ $data->net_weight }}" step="any" readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="net_mon" class="col-md-5 text-right">Net Mon:</label>
            <input type="number" class="col-md-7" id="net_mon" name="net_mon" value="{{ $data->net_mon }}" step="any" readonly>
            <small class="text-danger">{{ $errors->first('net_mon') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label for="per_mon_price" class="col-md-5 text-right">Per Mon Price:</label>
            <input type="number" class="col-md-7 qty" id="per_mon_price" name="per_mon_price" value="{{ $data->per_mon_price }}" step="any">
            <small class="text-danger">{{ $errors->first('per_mon_price') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label for="total_price" class="col-md-5 text-right">Total Price:</label>
            <input type="number" class="col-md-7" id="total_price" name="total_price" value="{{ $data->total_price }}" step="any" readonly>
        </div>
    </div>
</div>

<div class="col-md-12" style="margin-top: 20px; ">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnPurchase">Update</button>
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
            var scale_weight = parseFloat(document.getElementById("scale_weight").value);
            var challan_weight = parseFloat(document.getElementById("challan_weight").value);
            var bag_quantity = parseFloat(document.getElementById("bag_quantity").value);
            var empty_bag_weight = parseFloat(document.getElementById("empty_bag_weight").value);
            var dhorla = parseFloat(document.getElementById("dhorla").value);
            var main_weight = parseFloat(document.getElementById("main_weight").value);
            var per_mon_price = parseFloat(document.getElementById("per_mon_price").value);
            var main_weight = 0;
            var total_empty_bag_weight = 0;
            var total_empty_bag_dhorla = 0;
            var net_weight = 0;
            var net_mon = 0;
            var total_price = 0;
            if (isNaN(scale_weight) || scale_weight == '') {
                scale_weight = 1;
            }
            if (isNaN(challan_weight) || challan_weight == '') {
                challan_weight = 1;
            }
            if (challan_weight < scale_weight) {
                main_weight = challan_weight;
            } else {
                main_weight = scale_weight;
            }
            if (isNaN(empty_bag_weight) || empty_bag_weight == '') {
                empty_bag_weight = 1;
            }
            if (isNaN(dhorla) || dhorla == '') {
                dhorla = 0;
            }
            if (isNaN(per_mon_price) || per_mon_price == '') {
                per_mon_price = 1;
            }
            if (isNaN(main_weight) || main_weight == '') {
                main_weight = 1;
            }
            if (isNaN(bag_quantity) || bag_quantity == '') {
                bag_quantity = 1;
            }
            total_empty_bag_weight = bag_quantity * empty_bag_weight;
            total_empty_bag_dhorla = total_empty_bag_weight + dhorla;
            net_weight = main_weight - total_empty_bag_dhorla;
            net_mon = net_weight / 40;
            total_price = parseFloat(net_mon * per_mon_price);
            document.getElementById("main_weight").value = main_weight;
            document.getElementById("empty_bag_total_weight").value = total_empty_bag_weight;
            document.getElementById("net_weight").value = net_weight;
            document.getElementById("net_mon").value = net_mon;
            document.getElementById("total_price").value = total_price;
            e.preventDefault();
        });
    });

</script>
@endsection