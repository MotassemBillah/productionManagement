<?php
if ($data->type == 'D') {
    $tp = 'd';
} else {
    $tp = 'c';
}
$_frmpar_name = $data->particular_name($data->cr_particular_id);
$_topar_name = $data->particular_name($data->dr_particular_id);
$_frmsub_name = $data->subhead_name($data->cr_subhead_id);
$_tosub_name = $data->subhead_name($data->dr_subhead_id);
?>

@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title"> {{ $data->voucher_type }} </h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li><a href="{{ url('/transactions') }}">Transaction</a> <span class="fa fa-angle-right"></span></li>
            <li>Details</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div id="print_area">
    <div class="clearfix mp_gap" style="border-bottom:1px dashed #555555;margin-bottom:50px;padding-bottom:50px;">
        <?php print_header($data->voucher_type, true, true); ?>

        <table class="table table-striped table-bordered">
            <tr>
                <th style="width:20%">Voucher No</th>
                <td>{{ $data->id }}</td>
            </tr>
            <tr>
                <th style="width:20%">Date</th>
                <td>{{ date_dmy($data->date) }}</td>
            </tr>
            <tr>
                <th style="width:20%">From Account</th>
                <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
            </tr>
            <tr>
                <th style="width:20%">To Account</th>
                <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
            </tr>
            <tr>
                <th style="width:20%">By Whom</th>
                <td>{{ $data->by_whom }}</td>
            </tr>
            <tr>
                <th style="width:20%">Description</th>
                <td>{{ $data->description }}</td>
            </tr>
            <tr>
                <th style="width:20%">Amount</th>
                <td>{{ $data->amount }} TK</td>
            </tr>
            <tr>
                <th style="width:20%">In Word</th>
                <td style="text-transform: capitalize;">{{ int_to_words($data->amount) }} Taka Only</td>
            </tr>
        </table>

        <div class="row clearfix" style="padding-top:30px;">
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Customer</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Accountant</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Manager</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Managing Director</div>
            </div>
        </div>
    </div>

    <div class="clearfix mp_gap ">
        <?php print_header($data->voucher_type, false, true); ?>

        <table class="table table-striped table-bordered">
            <tr>
                <th style="width:20%">Voucher No</th>
                <td>{{ $data->id }}</td>
            </tr>
            <tr>
                <th style="width:20%">Date</th>
                <td>{{ date_dmy($data->date) }}</td>
            </tr>
            <tr>
                <th style="width:20%">From Account</th>
                <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
            </tr>
            <tr>
                <th style="width:20%">To Account</th>
                <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
            </tr>
            <tr>
                <th style="width:20%">By Whom</th>
                <td>{{ $data->by_whom }}</td>
            </tr>
            <tr>
                <th style="width:20%">Description</th>
                <td>{{ $data->description }}</td>
            </tr>
            <tr>
                <th style="width:20%">Amount</th>
                <td>{{ $data->amount }} TK</td>
            </tr>
            <tr>
                <th style="width:20%">In Word</th>
                <td style="text-transform: capitalize;">{{ int_to_words($data->amount) }} Taka Only</td>
            </tr>
        </table>

        <div class="row clearfix" style="padding-top:30px;">
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Customer</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Accounts</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Manager</div>
            </div>
            <div class="col-md-3 form-group mp_25">
                <div style="border-top:1px solid #555555;text-align:center;">Managing Director</div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix">
    <div class="form-group text-center">
        <button class="btn btn-primary btn-sm" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
    </div>
</div>
@endsection