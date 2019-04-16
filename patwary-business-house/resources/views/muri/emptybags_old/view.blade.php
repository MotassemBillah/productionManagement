<?php
if ($data->type == 'Receive') {
    $tp = 'd';
} else {
    $tp = 'c';
}
$_sub_name = $data->subhead_name($data->subhead_id);
$_par_name = $data->particular_name($data->particular_id);
?>
@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title"> {{ $data->type }} </h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Empty Bag</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div id="print_area">
        <div class="clearfix mp_gap" style="border-bottom:1px solid #ccc;margin-bottom:35px;padding-bottom:35px;">
            <?php print_header("Empty Bag $data->type (Office Copy)", true, true); ?>
            <div class="row clearfix mb_10">
                <div class="col-md-4 pull-left">
                    <strong>Voucher No :</strong>&nbsp; {{ $data->id }}
                </div>
                <div class="col-md-4 pull-right text-right">
                    <strong>Date :</strong>&nbsp; {{ date_dmy($data->date) }}
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <tr>
                    <th style="width:20%">Account</th>
                    <td>{{ !empty($_sub_name) ? $_sub_name : $data->head_name($data->head_id) }} {{ !empty($_par_name) ? ' -> ' . $_par_name : '' }}</td>
                </tr>
                <tr>
                    <th style="width:20%">By Whom</th>
                    <td>{{ $data->by_whom }}</td>
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <tr class="bg_gray">
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                </tr>
                <tr>
                    <td>{{ $data->description }}</td>
                    <td class="text-right">{{ $data->quantity }}</td>
                </tr>
                <tr class="bg_gray">
                    <td style="text-transform: capitalize;">                       
                        <strong class="pull-right">Total</strong>
                    </td>
                    <td class="text-right">{{ $data->quantity }}</td>
                </tr>
            </table>

            <div class="row clearfix" style="padding-top:30px;">
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Party</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Store Keeper</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
                </div>
            </div>
        </div>

        <div class="clearfix mp_gap">
            <?php print_header("Empty Bag $data->type (Client Copy)", false, true); ?>
            <div class="row clearfix mb_10">
                <div class="col-md-4 pull-left">
                    <strong>Voucher No :</strong>&nbsp; {{ $data->id }}
                </div>
                <div class="col-md-4 pull-right text-right">
                    <strong>Date :</strong>&nbsp; {{ date_dmy($data->date) }}
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <tr>
                    <th style="width:20%">Account</th>
                    <td>{{ !empty($_sub_name) ? $_sub_name : $data->head_name($data->head_id) }} {{ !empty($_par_name) ? ' -> ' . $_par_name : '' }}</td>
                </tr>
                <tr>
                    <th style="width:20%">By Whom</th>
                    <td>{{ $data->by_whom }}</td>
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <tr class="bg_gray">
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                </tr>
                <tr>
                    <td>{{ $data->description }}</td>
                    <td class="text-right">{{ $data->quantity }}</td>
                </tr>
                <tr class="bg_gray">
                    <td style="text-transform: capitalize;">                       
                        <strong class="pull-right">Total</strong>
                    </td>
                    <td class="text-right">{{ $data->quantity }}</td>
                </tr>
            </table>

            <div class="row clearfix" style="padding-top:30px;">
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Party</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Store Keeper</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
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