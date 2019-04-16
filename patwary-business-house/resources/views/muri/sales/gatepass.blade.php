<?php

use App\Models\SubHead;
use App\Models\Particular;
use App\Category;
use App\AfterProduction;
?>
@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Gate Pass</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Gate Pass</span></li>
        </ul>
    </div>
</div>

<div class="invoice_area" id="print_area">
    <div class="clearfix">
        <?php print_header("Gate Pass (Office Copy)", true, true); ?>
        <table class="table table-bordered tbl_thin" style="margin:0;">
            <tr>
                <td style="width:40%"><strong>Customer :</strong> {{ !empty($data->head_id) ? SubHead::find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . Particular::find($data->subhead_id)->name : '' }}</td>
                <td style="width:20%"><strong>Invoice :</strong> {{ $data->invoice_no }}</td>
                <td style="width:20%"><strong>Challan:</strong> {{ $data->challan_no}} </td>
                <td style="width:20%"><strong>Date:</strong> {{ date_dmy($data->date) }} </td>
            </tr>
        </table>
        <div class="product_info">
            <div class="table-responsive">
                <table class="table table-bordered table-striped tbl_thin" id="check" style="margin-bottom:15px;">
                    <tbody>
                        <tr>
                            <th colspan="9">Product Information :</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th class="text-right">Net Weight</th>
                            <th class="text-right">Quantity</th>
                        </tr>
                        <?php
                        $sl = 1;
                        $total_net_weight = '';
                        $total_quantity = '';
                        ?>
                        @foreach ($data->items as $item)
                        <?php
                        $total_net_weight += $item->weight;
                        $total_quantity += $item->quantity;
                        ?>
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $sl }}</td>
                            <td>{{ Category::find($item->category_id)->name }}</td>
                            <td>{{ AfterProduction::find($item->after_production_id)->name }}</td>
                            <td class="text-right">{{ $item->weight }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <?php $sl++; ?>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-weight:600;" class="text-center" colspan="3">Total</td>
                            <td style="font-weight:600;" class="text-right" >{{ $total_net_weight }}</td>
                            <td style="font-weight:600;" class="text-right" >{{ $total_quantity }}</td>
                        </tr>         
                    </tbody>
                </table>
            </div>

            <div class="row clearfix">
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Accountant</span>
                    </div>
                </div>
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Manager</span>
                    </div>
                </div>
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Store Keeper</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix" style="padding-top: 30px;border-top: 1px solid #ddd;margin-top: 30px;">
        <?php print_header("Gate Pass (Client Copy)", false, true); ?>
        <table class="table table-bordered tbl_thin" style="margin:0;">
            <tr>
                <td style="width:40%"><strong>Customer :</strong> {{ !empty($data->head_id) ? SubHead::find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . Particular::find($data->subhead_id)->name : '' }}</td>
                <td style="width:20%"><strong>Invoice :</strong> {{ $data->invoice_no }}</td>
                <td style="width:20%"><strong>Challan:</strong> {{ $data->challan_no}} </td>
                <td style="width:20%"><strong>Date:</strong> {{ date_dmy($data->date) }} </td>
            </tr>
        </table>
        <div class="product_info">
            <div class="table-responsive">
                <table class="table table-bordered table-striped tbl_thin" id="check" style="margin-bottom:15px;">
                    <tbody>
                        <tr>
                            <th colspan="9">Product Information :</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th class="text-right">Net Weight</th>
                            <th class="text-right">Quantity</th>
                        </tr>
                        <?php
                        $sl = 1;
                        $total_net_weight = '';
                        $total_quantity = '';
                        ?>
                        @foreach ($data->items as $item)
                        <?php
                        $total_net_weight += $item->weight;
                        $total_quantity += $item->quantity;
                        ?>
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $sl }}</td>
                            <td>{{ Category::find($item->category_id)->name }}</td>
                            <td>{{ AfterProduction::find($item->after_production_id)->name }}</td>
                            <td class="text-right">{{ $item->weight }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <?php $sl++; ?>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-weight:600;" class="text-center" colspan="3">Total</td>
                            <td style="font-weight:600;" class="text-right" >{{ $total_net_weight }}</td>
                            <td style="font-weight:600;" class="text-right" >{{ $total_quantity }}</td>
                        </tr>         
                    </tbody>
                </table>
            </div>

            <div class="row clearfix">
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Accountant</span>
                    </div>
                </div>
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Manager</span>
                    </div>
                </div>
                <div class="col-md-4 mp_30">
                    <div class="form-group text-center" style="margin-top:50px; border-top: 1px solid #cdcdcd;">
                        <span>Store Keeper</span>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="text-center">
    <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
</div>
@endsection