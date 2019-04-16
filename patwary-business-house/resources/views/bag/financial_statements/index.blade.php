@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Financial Statement</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Financial</span></li>
        </ul>                            
    </div>
</div>
<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!}                   
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:10px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:25%">
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show List-->
<div id="print_area">
    <div id="ajax_content">
        {{ print_header("Financial Statement Report (".( date_dmy($from_date) ). ")") }}
        <div class="table-responsive">
            <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                <tbody>
                    <tr>
                        <td><strong>Opening Balance :</strong> {{ $opening_balance }}&nbsp;TK</td>
                    </tr>
                </tbody>
            </table>
            <div class="clearfix">               
                <div class="col-md-6 mp_50" style="padding:0px 5px 0px 0px;">
                    <div class="table-responsive">
                        <table class="table table-bordered tbl_thin" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="3">Receives</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Account</th>
                                <th class="text-right" style="width:10%;">Amount</th>
                            </tr>                  
                            <?php
                            $counter = 0;
                            $total_debit = 0;
                            ?>
                            @foreach ($receives as $receive)
                            <?php
                            $counter++;
                            $sum_debit = $modelTrans->sumSubReceiveVoucherBetweenDate($from_date, $end_date, $receive->dr_subhead_id);
                            $total_debit += $sum_debit;
                            ?>
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ !empty($receive->dr_particular_id) ? $receive->particular_name($receive->dr_particular_id) : $receive->subhead_name($receive->dr_subhead_id) }} </td>
                                <td class="text-right">{{ $sum_debit }}</td>
                            </tr>    
                            @endforeach
                            <tr class="bg-info">
                                <th class="text-right" colspan="2">Total</th>
                                <th class="text-right">{{ $total_debit }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 pull-right mp_50" style="padding:0px 0px 0px 5px;">
                    <div class="table-responsive">
                        <table class="table table-bordered tbl_thin" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="3">Payments</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Account</th>
                                <th class="text-right" style="width:10%;">Amount</th>
                            </tr>  
                            <?php
                            $counter = 0;
                            $total_credit = 0;
                            ?>
                            @foreach ($payments as $payment)
                            <?php
                            $counter++;
                            $sum_debit = $modelTrans->sumSubPaymentVoucherBetweenDate($from_date, $end_date, $payment->cr_subhead_id);
                            $total_credit += $sum_debit;
                            ?>
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ !empty($payment->cr_particular_id) ? $payment->particular_name($payment->cr_particular_id) : $payment->subhead_name($payment->cr_subhead_id) }} </td>
                                <td class="text-right">{{ $sum_debit }}</td>
                            </tr>   
                            @endforeach
                            <tr class="bg-info">
                                <th class="text-right" colspan="2">Total</th>
                                <th class="text-right">{{ $total_credit }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix" style="margin-top: 20px;">
            <table class="table table-bordered tbl_thin" style="margin: 0;">
                <tr class="">
                    <th class="text-center">Total Receives : {{ $total_debit }} TK</th>
                </tr>
                <tr class="">
                    <th class="text-center">Total Payments : {{ $total_credit }} TK</th>
                </tr>
                <tr class="bg-info">
                    <th class="text-center">Closing Balance : {{ $closing_balance }} TK</th>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('financial-statement/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function () {
                    $('#ajaxMessage').showAjaxMessage({html: 'There is some error.Try after some time.', type: 'error'});
                }
            });

        });
    });
</script>

@endsection