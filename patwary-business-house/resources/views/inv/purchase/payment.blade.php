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
            <li>Payment</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<?php
$invAmount = doubleval($model->invoice_amount);
$otherCost = doubleval($model->transport_cost + $model->labor_cost);
$invPaid = doubleval($model->paid_amount);
$curDue = doubleval($model->due_amount);
//$_dt = $payment->isNewRecord ? date('d-m-Y') : date('d-m-Y', strtotime($payment->pay_date));
$sel_fsubh = !empty($payment) ? $payment->cr_subhead_id : "";
$sel_fpart = !empty($payment) ? $payment->cr_particular_id : "";
$sel_tsubh = !empty($model) ? $model->from_subhead_id : "";
$sel_tpart = !empty($model) ? $model->from_particular_id : "";
?>
<div class="row clearfix">
    <div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Purchase Payment Form</h3>
            </div>
            <div class="panel-body">
                <form action="" method="POST" name="frmPayment">
                    {{ csrf_field() }}
                    <input type="hidden" name="purchase_id" value="{{$model->id}}">
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-6">
                            <div class="mb_10 clearfix">
                                <label for="pay_date">Date <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control pickdate" id="pay_date" name="pay_date" value="{{date_dmy($model->invoice_date)}}" placeholder="(dd-mm-yyyy)" readonly required>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="mb_10 clearfix">
                                <label for="from_subhead">From Subhead <span class="required">*</span></label>
                                <input type="text" class="inp_filter" id="" placeholder="filter subhead" onkeyup="filter_list(this.value, 'from_subhead')">
                                <select class="form-control" id="from_subhead" name="from_subhead" required>
                                    <option value="">Select</option>
                                    @foreach($subhead_list as $fshlist)
                                    <option value="{{ $fshlist->id }}" <?php if ($fshlist->id == $sel_fsubh) echo ' selected'; ?>>{{ $fshlist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb_10 clearfix">
                                <label for="from_particular">From Particular</label>
                                <input type="text" class="inp_filter" id="" placeholder="filter particular" onkeyup="filter_list(this.value, 'from_particular')">
                                <select class="form-control" id="from_particular" name="from_particular">
                                    <option value="">Select</option>
                                    @foreach($particular_list as $fplist)
                                    <option value="{{ $fplist->id }}" <?php if ($fplist->id == $sel_fpart) echo ' selected'; ?>>{{ $fplist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb_10 clearfix">
                                <label for="amount" style="width: 100%;">Amount 
                                    <span class="required">*</span> 
                                    <span class="pull-right" style="font-size:11px;font-weight:normal;margin-top:3px;">Max = {{$model->invoice_amount}} tk</span>
                                </label>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?= !empty($payment) ? $payment->amount : $model->invoice_amount; ?>" min="0" max="{{$model->invoice_amount}}" step="any" required>                                
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="mb_10 clearfix">
                                <label for="to_subhead">To Subhead <span class="required">*</span></label>
                                <input type="text" class="inp_filter" id="" placeholder="filter subhead" onkeyup="filter_list(this.value, 'to_subhead')">
                                <select class="form-control" id="to_subhead" name="to_subhead" required>
                                    <option value="">Select</option>
                                    @foreach($subhead_list as $tshlist)
                                    <option value="{{ $tshlist->id }}" <?php if ($tshlist->id == $sel_tsubh) echo ' selected'; ?>>{{ $tshlist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb_10 clearfix">
                                <label for="to_particular">To Particular</label>
                                <input type="text" class="inp_filter" id="" placeholder="filter particular" onkeyup="filter_list(this.value, 'to_particular')">
                                <select class="form-control" id="to_particular" name="to_particular">
                                    <option value="">Select</option>
                                    @foreach($particular_list as $tplist)
                                    <option value="{{ $tplist->id }}" <?php if ($tplist->id == $sel_tpart) echo ' selected'; ?>>{{ $tplist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb_10 clearfix">
                                <label for="note">Note</label>
                                <textarea class="form-control" id="note" name="note" style="min-height: 103px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <input type="submit" class="btn btn-primary xsw_100" id="submit_form" name="submit_form" value="Submit">                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $(document).on("change", "#from_subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#from_particular");
                    $("#from_particular").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#to_subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#to_particular");
                    $("#to_particular").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });
    });
</script>
@endsection