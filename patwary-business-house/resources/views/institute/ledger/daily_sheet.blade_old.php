@extends('admin.layouts.column1')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Daily Statement</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Ledger</span></li>
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
                            <div style="width:17%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="date" class="form-control pickdate" value="{{ date_dmy(date('Y-m-d')) }}" size="30" readonly>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <select class="form-control" name="head_id">
                                    <option value="">Select Head</option>                  
                                    @foreach($head->all() as $hs)
                                    <option value="{{$hs->id}}">{{$hs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:25%">
                    <a class="btn btn-success btn-xs" href="{{ url('/transactions/create/d') }}"><i class="fa fa-plus"></i>&nbsp;Receive</a>
                    <a class="btn btn-warning btn-xs" href="{{ url('/transactions/create/c') }}"><i class="fa fa-minus"></i>&nbsp;Payment</a>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show List-->
<div id="print_area">
    {{ print_header("Daily Account Statement") }}
    <div id="ajax_content">
        <div class="table-responsive">
            <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                <tr>
                    <td><strong>Opening Balance :</strong> <?= $opening_balance; ?>&nbsp;TK</td>
                </tr>
            </table>
            <div class="clearfix">
                <div class="col-md-6 mp_50" style="padding:0;">
                    <div class="table-responsive">
                        <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="3">Debit</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Account Name</th>
                                <th class="text-right" style="width:15%;">Debit</th>
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
                                <td>{{ $counter }}</td>
                                <td>{{ !empty($debit->dr_subhead_id) ? $debit->subhead_name($debit->dr_subhead_id) : $debit->head_name($debit->dr_head_id) }} {{ !empty($debit->dr_particular_id) ? ' -> '.$debit->particular_name($debit->dr_particular_id) : '' }}</td>
                                <td class="text-right">{{ $debit->debit }}</td>
                            </tr>   
                            @endforeach
                            <tr class="bg-info">
                                <th class="text-right" colspan="2">Total</th>
                                <th class="text-right">{{ $total_debit }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 pull-right mp_50" style="padding:0;">
                    <div class="table-responsive">
                        <table class="table table-bordered tbl_invoice_view" style="margin: 0;">
                            <tr class="bg-info">
                                <th class="text-center" colspan="3">Credit</th>
                            </tr>
                            <tr class="bg_gray">
                                <th class="text-center" style="width:4%;">SL</th>
                                <th>Name</th>
                                <th class="text-right" style="width:15%;">Credit</th>
                            </tr>                  
                            <?php
                            $counter = 0;
                            $total_credit = 0;
                            ?>
                            @foreach ($all_credit as $credit)
                            <?php
                            $counter++;
                            $total_credit += $credit->credit;
                            ?>
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ !empty($credit->cr_subhead_id) ? $credit->subhead_name($credit->cr_subhead_id) : $credit->head_name($credit->cr_head_id) }} {{ !empty($credit->cr_particular_id) ? ' -> '.$credit->particular_name($credit->cr_particular_id) : '' }}</td>
                                <td class="text-right">{{ $credit->credit }}</td>
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
            <table class="table table-bordered tbl_invoice_view">
                <tr>
                    <td class="text-center"><strong>Total Debit : </strong>{{ !empty($total_debit) ? $total_debit+$opening_balance : '' }} TK</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Total Credit : </strong>{{ !empty($total_credit) ? $total_credit : '' }} TK</td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Closing Balance : </strong>{{ $closing_balance }}  TK</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('ledger/dailysheet/search') }}";
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