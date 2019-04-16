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
@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title"> {{ $data->voucher_type }} </h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Transaction</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div id="print_area">
        <div class="clearfix mp_gap" style="border-bottom:1px solid #ccc;margin-bottom:35px;padding-bottom:35px;">
            <?php print_header("$data->voucher_type (Office Copy)", true, true); ?>
            <div class="row clearfix mb_10">
                <div class="col-md-4 pull-left">
                    <strong>Voucher No :</strong>&nbsp; {{ $data->id }}
                </div>
                <div class="col-md-4 pull-right text-right">
                    <strong>Date :</strong>&nbsp; {{ date_dmy($data->pay_date) }}
                </div>
            </div>
            <table class="table table-striped table-bordered">
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
            </table>
            <table class="table table-striped table-bordered">
                <tr class="bg_gray">
                    <th>Description</th>
                    <th class="text-right">Amount</th>
                </tr>
                <tr>
                    <td>{{ $data->description }}</td>
                    <td class="text-right">{{ $data->amount }}</td>
                </tr>
                <tr class="bg_gray">
                    <td style="text-transform: capitalize;">
                        <strong>In Word :</strong> {{ int_to_words($data->amount) }}
                        <strong class="pull-right">Total</strong>
                    </td>
                    <td class="text-right">{{ $data->amount }}</td>
                </tr>
            </table>

            <div class="row clearfix" style="padding-top:30px;">
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Customer</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Accountant</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
                </div>
            </div>
        </div>
        <div class="clearfix mp_gap">
            <?php print_header("$data->voucher_type (Client Copy)", false, true); ?>

            <div class="row clearfix mb_10">
                <div class="col-md-4 pull-left">
                    <strong>Voucher No :</strong>&nbsp; {{ $data->id }}
                </div>
                <div class="col-md-4 pull-right text-right">
                    <strong>Date :</strong>&nbsp; {{ date_dmy($data->pay_date) }}
                </div>
            </div>

            <table class="table table-striped table-bordered">
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
            </table>

            <table class="table table-striped table-bordered">
                <tr class="bg_gray">
                    <th>Description</th>
                    <th class="text-right">Amount</th>
                </tr>
                <tr>
                    <td>{{ $data->note }}</td>
                    <td class="text-right">{{ $data->amount }}</td>
                </tr>
                <tr class="bg_gray">
                    <td style="text-transform: capitalize;">
                        <strong>In Word :</strong> {{ int_to_words($data->amount) }}
                        <strong class="pull-right">Total</strong>
                    </td>
                    <td class="text-right">{{ $data->amount }}</td>
                </tr>
            </table>

            <div class="row clearfix" style="padding-top:30px;">
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Customer</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Accounts</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
                </div>
                <div class="col-md-3 form-group mp_25">
                    <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
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