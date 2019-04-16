@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Head Transaction Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li><a href="{{ url('/head') }}">Head <span class="fa fa-angle-right"></span></a></li>
            <li>Transactions</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!}
                    <input type="hidden" name="head" value="{{ $head_id }}">
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <div style="width:16%;" class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <div class="input-group">
                                    <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div style="width:6%" class="col-md-1 col-sm-1 hidden-xs no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div>
                            <div style="width:16%;" class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <div class="input-group">
                                    <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div style="width:16%;" class="col-md-2 col-sm-3 xsw_100 no_pad">
                                <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                                <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="wmd_30 text-right" style="width:25%">
                    <button class="btn btn-primary btn-xs xsw_33" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="print_area">
    {{ print_header("Ledger Details") }}
    <div id="ajax_content">
        <?php
        $sum_debit = $all_debit->sum('debit');
        $sum_credit = $all_credit->sum('credit');
        ?>
        <div class="table-responsive">
            <h3 class="text-center well">{{ $head->find($head_id)->name }} | Ledger</h3>
            <div class="clearfix">
                <div class="col-md-6 col-sm-6 mp_50" style="padding:0;">
                    <div class="table-responsive" style="margin: 0;">
                        <table class="table table-bordered tbl_thin" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="4">Debit</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th class="text-right" style="width:15%;">Amount</th>
                            </tr>
                            <?php
                            $counter = 0;
                            $total_debit = 0;
                            ?>
                            @foreach ($all_debit as $debit)
                            <?php
                            $counter++;
                            $total_debit += $debit->debit;
                            ?>
                            <tr>
                                <td class="text-center">{{ $counter }}</td>
                                <td>{{ date_dmy($debit->date) }}</td>
                                <td>{{ !empty($debit->cr_subhead_id) ? $debit->subhead_name($debit->cr_subhead_id) : $debit->head_name($debit->cr_head_id) }} {{ !empty($debit->cr_particular_id) ? ' -> '.$debit->particular_name($debit->cr_particular_id) : '' }}</td>
                                <td class="text-right">{{ $debit->debit }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-info">
                                <th class="text-right" colspan="3">Total</th>
                                <th class="text-right">{{ $total_debit }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 mp_50" style="padding:0;">
                    <div class="table-responsive" style="margin: 0;">
                        <table class="table table-bordered tbl_thin" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="4">Credit</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th class="text-right" style="width:15%;">Amount</th>
                            </tr>
                            <?php
                            $counterc = 0;
                            $total_credit = 0;
                            ?>
                            @foreach ($all_credit as $credit)
                            <?php
                            $counterc++;
                            $total_credit += $credit->credit;
                            ?>
                            <tr>
                                <td class="text-center">{{ $counterc }}</td>
                                <td>{{ date_dmy($credit->date) }}</td>
                                <td>{{ !empty($credit->dr_subhead_id) ? $credit->subhead_name($credit->dr_subhead_id) : $credit->head_name($credit->dr_head_id) }} {{ !empty($credit->dr_particular_id) ? ' -> '.$credit->particular_name($credit->dr_particular_id) : '' }}</td>
                                <td class="text-right">{{ $credit->credit }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-info">
                                <th class="text-right" colspan="3">Total</th>
                                <th class="text-right">{{ $total_credit }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix" style="">
                <table class="table table-bordered tbl_thin" style="margin: 0;">
                    <tr class="bg-info">
                        <th class="text-center">Total Debit : {{ $total_debit }} TK</th>
                    </tr>
                    <tr class="bg-info">
                        <th class="text-center">Total Credit : {{ $total_credit }} TK</th>
                    </tr>
                    <tr class="bg-info">
                        <th class="text-center">Balance : {{ $total_debit - $total_credit }} TK</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('ledger/head/search') }}";
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