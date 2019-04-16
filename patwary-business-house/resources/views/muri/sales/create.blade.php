<?php

use App\Weight; ?>
@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sale</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => '', 'id'=>'frm_sale', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Invoice No:</label>
            <input type="text" class="col-md-7" id="invoice_no" name="invoice_no" value="<?php echo Weight::get_sale_invoice(); ?>" readonly required>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" name="challan_no">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb_5 clearfix">
            <label for="head" class="col-md-5 text-right">Head :</label>
            <select class="col-md-7" id="head" name="head" required>
                <option value="">Select Head</option>
                @foreach( $heads->all() as $head )
                <option value="{{ $head->id }}">{{ $head->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="subhead" class="col-md-5 text-right">Sub Head :</label>
            <select class="col-md-6" id="subhead" name="subhead" disabled>
                <option value="">Select Head First</option>
            </select>
            <a class="col-md-1 pull-right btn btn-success btn-xs" href="{{ url('particular/create/s') }}">New</a>
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
                <th>Product</th>
                <th>Bag Weight(Kg)</th>
                <th>Stock Quantity</th>
                <th>Stock Weight</th>
                <th>Quantity</th>
                <th>Total Weight(Kg)</th>
                <th class="text-right">Per Bag Price</th>
                <th class="text-right">Total Price(Tk)</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0; ?>
            @foreach ( $products->all() as $product )
            <?php
            $sl++;
            $stock_weight = $stock->sumStockWeight($product->id);
            $stock_quantity = $stock->sumStockQuantity($product->id);
            ?>
            @if( $stock_quantity > 0  )
            <tr>
                <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="product[]" value="{{ $product->id }}"></td>
        <input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]">  
        <td>{{ $products->find($product->id)->name }} <input type="hidden" value="{{ $product->id }}" name="product_id[{{ $product->id }}]" ></td>
        <td>{{ $product->weight }}</td>
        <td>{{ $stock_quantity }}
            <input type="hidden" id="stockqty_{{ $product->id }}" value="{{ $stock_quantity }}" name="stock_quantity[{{ $product->id }}]">
        </td>
        <td>{{ $stock_weight }}
            <input type="hidden" id="stockweight_{{ $product->id }}" value="{{ $stock_weight }}" name="stock_weight[{{ $product->id }}]">
        </td>
        <td>
            <div style="display:none; padding: 3px; margin-bottom: 5px;" id="alt_{{ $product->id }}" class="alert alert-danger">
                <strong>Quantity Exceed</strong>  
            </div>
            <input type="number" id="qty_{{ $product->id }}" name="quantity[{{ $product->id }}]" class="form-control tqty_check qty" data-weight ="{{ $product->weight }}" data-info="{{ $product->id }}" data-stock="{{ $stock_quantity }}"  min="0" max="{{ $stock_quantity }}">
        </td>
        <td>
            <input type="number" step="any" id="wpq_{{ $product->id }}" name="net_weight[{{ $product->id }}]" class="form-control" readonly>
        </td>
        <td>
            <div style="display:none; padding: 3px;margin-bottom: 5px;" id="palt_{{ $product->id  }}" class="alert alert-danger">
                <strong>Check Price</strong>  
            </div>
            <input type="number" step="any" id="per_price_{{ $product->id }}" name="per_bag_price[{{ $product->id }}]"  value="{{ $product->sale_price }}" class="form-control pbp" data-info="{{ $product->id }}">
        </td>
        <td>
            <input type="number" step="any" id="net_price_{{ $product->id }}" name="net_price[{{ $product->id }}]" class="form-control" readonly>
        </td>
        </tr>
        @endif
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

        $(document).on("input", ".qty", function (e) {
            var id = $(this).attr('data-info');
            var weight = $(this).attr('data-weight');
            var stk = parseFloat($(this).attr('data-stock'));
            var total_weight = 0;
            var total_price = 0;
            var qun = this.value;
            if (qun > stk) {
                document.getElementById("alt_" + id).style.display = "block";
            }else{
                document.getElementById("alt_" + id).style.display = "none";
            }
            var bag_price = document.getElementById("per_price_" + id).value;
            if (isNaN(weight) || weight == '') {
                weight = 1;
            }
            if (isNaN(bag_price) || bag_price == '') {
                bag_price = 0;
            }
            total_weight = qun * weight;
            total_price = qun * bag_price;
            document.getElementById("wpq_" + id).value = total_weight;
            document.getElementById("net_price_" + id).value = total_price;
            e.preventDefault();
        });

        $(document).on("input", ".pbp", function (e) {
            var id = $(this).attr('data-info');
            var total_price = 0;
            var bag_price = this.value;
            var qun = document.getElementById("qty_" + id).value;
            if (isNaN(qun) || qun == '') {
                qun = 1;
            }
            console.log(bag_price);
            total_price = qun * bag_price;
            document.getElementById("net_price_" + id).value = total_price;
            e.preventDefault();
        });


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

        $(document).on("submit", "#frm_sale", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('sales') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo('{{ url('sales') }}')
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");
            e.preventDefault();
            return false;
        });

    });


</script>
@endsection