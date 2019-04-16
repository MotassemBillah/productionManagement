@extends('layouts.app')
<?php

use App\Stock;
use App\Category;
use App\ProductionOrder;
use App\Product;
use App\Weight;
?>
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Completed Production Order List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Production Stock</span></li>
        </ul>                            
    </div>
</div>
{!! Form::open(['method' => 'POST', 'url' => '',   'class' => 'search-form', 'id'=>'frmProduction','name'=>'frmProduction']) !!} 
{{ csrf_field() }}
<div class="order-list"> 
    <div class="table-responsive">
        <div style="margin:8px 0px;" class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-md-3">Order No:</label>
                    <div class="col-md-6">
                        <select name="production_id" id="production_id" class="form-control" required="required">
                            <option value="">Select Production Order</option>
                            @foreach ($production_order as $porder) 
                            <option value="{{ $porder->production_id }}">{{ $porder->order()->first()->order_no }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> 
        </div>
        <div id="check">
            <div id="ajax_content">

            </div>
        </div>
    </div>
</div>
<div id="product_content">

</div>







<script type="text/javascript">
    $(document).ready(function () {
        $("#production_id").change(function () {
            var pid = $(this).val();
            var _url = "{{ URL::to('production-order') }}/" + pid + "/item";
            $.ajax({
                url: _url,
                type: "get",
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#CheckAll", function () {
            if ($(this).is(":checked")) {
                $("#check input[type='checkbox']").prop("checked", true);
            } else {
                $("#check input[type='checkbox']").prop("checked", false);
            }
        });


        $(document).on("change", "#check", function () {
            if ($("#check input[type='checkbox']:checked").not("#CheckAll").length > 0) {
                $("#CheckAll").prop("checked", true);
            } else {
                $("#CheckAll").prop("checked", false);
            }
        });

        $(document).on("change", "#Production_ID", function () {
            if ($(this).is(":checked")) {
                var id = $(this).val();
                var _url = "{{ URL::to('production-order') }}/" + id + "/complete";
                $.ajax({
                    url: _url,
                    type: "get",
                    success: function (data) {
                        $('#product_content').html(data);
                    },
                    error: function (xhr, status) {
                        alert('There is some error.Try after some time.');
                    }
                });
            } else {
                return false;
            }
        });

        $(document).on("submit", "#frmProduction", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('production-stocks') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo(res.url);
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