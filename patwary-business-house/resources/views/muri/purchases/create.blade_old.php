<?php

use App\Weight;
?>
@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Purchase Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Purchase</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => '', 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Invoice No:</label>
            <input type="text" class="col-md-7" id="invoice_no" name="invoice_no" value="<?php echo Weight::get_purchase_invoice(); ?>" readonly required>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" name="challan_no">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label for="head" class="col-md-5 text-right">Head :</label>
            <select class="col-md-7" id="head" name="head" required>
                <option value="">Select Head</option>
                @foreach( $heads as $head )
                <option value="{{ $head->id }}">{{ $head->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="subhead" class="col-md-5 text-right">Sub Head :</label>
            <select class="col-md-6" id="subhead" name="subhead" onchange="weight_measure()" disabled>
                <option value="">Select Head First</option>
            </select>
            <a class="col-md-1 pull-right btn btn-success btn-xs" href="{{ url('particular/create/p') }}">New</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Quantity:</label>
            <input type="number" class="col-md-7" id="quantity" name="total_quantity" min="0" step="any" required>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Net Weight:</label>
            <input type="number" class="col-md-7" id="net_weight" name="total_net_weight" min="0" onkeyup="weight_measure()" required>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">WPQ:</label>
            <input type="number" class="col-md-7" id="wpq" name="wpq" min="0" step="any" readonly required>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Net Mon:</label>
            <input type="number" class="col-md-7" id="mon" name="mon" min="0" step="any" readonly required>
        </div>
    </div>
</div>

<hr style="margin: 5px 0">
<div class="text-center"><strong>Product Information</strong></div>
<hr style="margin: 5px 0 10px">

<div class="table-responsive">
    <table class="table table-bordered" id="check">
        <thead>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;"><input type="checkbox" id="check_all" value="all" name="check" style="margin: 0;"></th>
                <th>Category</th>
                <th>Product</th>
                <th>Quantity (Bag)</th>
                <th>Net Weight (Kg)</th>
                <th>Net Mon (Mon)</th>
                <th class="text-right">Per Mon Price</th>
                <th class="text-right">Net Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0; ?>
            @foreach ( $products->all() as $product )
            <?php $sl++; ?>
            <tr>
                <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="product[]" value="{{ $product->id }}"></td>
                <td>{{ $category->find($product->category_id)->name }}<input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]"></td>
                <td>{{ $products->find($product->id)->name }} <input type="hidden" value="{{ $product->id }}" name="product_id[{{ $product->id }}]" ></td>
                <td>
                    <div style="display:none; padding: 3px; margin-bottom: 5px;" id="alt_{{ $product->id }}" class="alert alert-danger">
                        <strong>Quantity Exceed</strong>  
                    </div>
                    <input type="number" id="qty_{{ $product->id }}" name="quantity[{{ $product->id }}]" min="0" onkeyup="measure_wpq(this)" class="form-control tqty_check" data-info="{{ $product->id }}">
                </td>
                <td>
                    <input type="number" step="any" id="wpq_{{ $product->id }}" name="net_weight[{{ $product->id }}]" class="form-control" readonly>
                </td>
                <td>
                    <input type="number" step="any" id="mon_{{ $product->id }}" name="net_mon[{{ $product->id }}]" class="form-control" readonly>
                </td>
                <td>
                    <div style="display:none; padding: 3px;margin-bottom: 5px;" id="palt_{{ $product->id  }}" class="alert alert-danger">
                        <strong>Check Price</strong>  
                    </div>
                    <input type="number" step="any" id="per_price_{{ $product->id }}" name="per_bag_price[{{ $product->id }}]" min="0" onkeyup="measure_bag_price(this)" class="form-control" data-info="{{ $product->id }}">
                </td>
                <td>
                    <input type="number" step="any" id="net_price_{{ $product->id }}" name="net_price[{{ $product->id }}]" class="form-control" readonly>
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
            <button type="submit" class="btn btn-primary" id="btnPurchase">Save</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("change", "#head", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subhead");
                    $('#subhead').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("submit", "#frm_purchase", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('purchases') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo('{{ url('purchases') }}')
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");
            e.preventDefault();
            return false;
        });
    });




    function weight_measure() {
        var quantity = document.getElementById("quantity").value;
        var net_weight = document.getElementById("net_weight").value;
        var sId = document.getElementById("subhead");
        var sVal = sId.options[sId.selectedIndex].value;
        var mon = parseFloat(sId.options[sId.selectedIndex].getAttribute('data-mon'));
        if (sVal == '') {           
            alert("Select Customer First!");
        }
        if (isNaN(mon) || mon == null || mon < 0) {           
            mon = 40;
        }
        wpq = net_weight / quantity;
        mon = kgToMon(net_weight, mon);
        document.getElementById('wpq').value = wpq.toFixed(2);
        document.getElementById('mon').value = mon;
    }

    function measure_wpq(elm) {
        var id = $(elm).attr('data-info');
        var total_quantity = document.getElementById("quantity").value;
        var wpq = parseFloat(document.getElementById("wpq").value);
        var qun = document.getElementById("qty_" + id).value;
        var sumqty = get_sum("tqty_check");
        if (isNaN(total_quantity)) {
            total_quantity = 0;
        }
        
        var sId = document.getElementById("subhead");
        var mon = parseFloat(sId.options[sId.selectedIndex].getAttribute('data-mon'));
        if (isNaN(mon) || mon == null || mon < 0) {
            //alert("Select Customer First");
            mon = 40;
        }

        if (sumqty > total_quantity) {
            document.getElementById("alt_" + id).style.display = "block";
        } else {
            document.getElementById("alt_" + id).style.display = "none";
            var mainwpq = (qun * wpq);
            var mainmon = kgToMon(mainwpq, mon);
            document.getElementById("wpq_" + id).value = mainwpq.toFixed(2);
            document.getElementById("mon_" + id).value = mainmon;
        }
    }

    function measure_bag_price(elm) {
        var id = $(elm).attr('data-info');
        var mon = document.getElementById("mon_" + id).value;
        var per_price = document.getElementById("per_price_" + id).value;
        var mulprice = mon * per_price;
        if (isNaN(per_price)) {
            document.getElementById("palt_" + id).style.display = "block";
        } else {
            document.getElementById("palt_" + id).style.display = "none";
            var mulprice = mon * per_price;
            document.getElementById("net_price_" + id).value = mulprice.toFixed(2);
        }
    }
</script>
@endsection