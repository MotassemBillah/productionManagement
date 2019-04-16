@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Ledger List</h2>
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
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:6%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div style="width:17%;" class="col-md-2 col-sm-3 no_pad">
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
    {{ print_header("Ledger Information") }}
    <div id="ajax_content">
        <?php if (!empty($dataset) && count($dataset) > 0) : ?>
            <div class="table-responsive">           
                <table class="table table-bordered tbl_thin" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Head Name</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th class="text-right">Balance</th>
                        </tr>
                        <?php $counter = 0; ?>
                        @foreach ($dataset as $data)
                        <?php
                        $counter++;
                        $total_debit = 0;
                        $total_credit = 0;
                        $total_balance = 0;
                        ?>   
                        <tr>
                            <td class="text-center">{{ $counter }}</td>
                            <td title="View All Transaction">
                                <span style="font-weight: 600; color: #337ab7;" class="hip"><a href="{{ url('ledger/head/'.$data->id) }}">{{ $data->name }}</a></span>
                                <span class="show_in_print">{{ $data->name }}</span>
                            </td>
                            <td class="text-right">{{ $tmodel->headDebit($data->id) }}</td>
                            <td class="text-right">{{ $tmodel->headCredit($data->id) }}</td>
                            <td class="text-right">{{ $tmodel->sumHeadBalance($data->id) }}</td>                    
                        </tr>
                        <?php if (!empty($data->subhead)): ?> 
                            @foreach ($data->subhead as $item)
                            <?php
                            $total_debit += $_subdebit = $tmodel->sumSubDebit($item->id);
                            $total_credit += $_subcredit = $tmodel->sumSubCredit($item->id);
                            $total_balance += $_subbalance = $tmodel->sumSubBalance($item->id);
                            ?>
                            <tr>
                                <td></td>
                                <td style="padding-left: 30px;" title="View All Transaction">
                                    <span class="hip"><a href="{{ url('ledger/subhead/'.$item->id) }}">{{ $item->name }}</a></span>
                                    <span class="show_in_print">{{ $item->name }}</span>
                                </td>
                                <td class="text-right">{{ $_subdebit }}</td>
                                <td class="text-right">{{ $_subcredit }}</td>
                                <td class="text-right">{{ $_subbalance }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg_gray">
                                <th class="text-right" colspan="2">Sub Total:</th>
                                <th class="text-right">{{ $total_debit }}</th>
                                <th class="text-right">{{ $total_credit }}</th>
                                <th class="text-right">{{ $total_balance }}</th>
                            </tr>
                        <?php endif; ?> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No records found!</div>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('ledger/search') }}";
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

        $("#Del_btn").click(function () {
            var _url = "{{ URL::to('head/delete') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {

                $.post(_url, _form.serialize(), function (data) {
                    if (data.success === true) {
                        $('#ajaxMessage').showAjaxMessage({html: data.message, type: 'success'});
                        $("#search").trigger("click");
                    } else {
                        $('#ajaxMessage').showAjaxMessage({html: data.message, type: 'error'});
                    }
                }, "json");

            }

        });
    });
</script>
@endsection