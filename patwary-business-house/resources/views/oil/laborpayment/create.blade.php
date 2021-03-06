@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Labor Payment</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Purchase</span></li>
        </ul>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'url' => '', 'id'=>'frmLaborPayment', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}

<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="<?php echo date('d-m-Y'); ?>" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="subhead" class="col-md-5 text-right">Labor Type :</label>
            <select class="col-md-7" id="subhead" name="subhead_id" required>
                <option value="">Select Head</option>
                @foreach( $subheads as $subhead )
                <option value="{{ $subhead->id }}">{{ $subhead->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="shift" class="col-md-5 text-right">Shift :</label>
            <select class="col-md-7" id="shift" name="shift" required>
                <option value="">Select Shift</option>
                @foreach(laborDutyPeriod() as $key=> $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<hr style="margin: 5px 0">
<div class="text-center"><strong>Labor Payment Information</strong></div>
<hr style="margin: 5px 0 10px">

<div id="laborList">
    
</div>

<div class="col-md-12" style="margin-top: 20px;">
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

        $(document).on("change", "#subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('laborpayment/laborlist') }}",
                type: "post",
                data: {'id': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#laborList').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("submit", "#frmLaborPayment", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('laborpayment') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo('{{ url('laborpayment') }}')
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