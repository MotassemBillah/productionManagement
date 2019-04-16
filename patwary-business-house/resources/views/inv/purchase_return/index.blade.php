@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li>Purchase Return</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div class="well">
    <table width="100%">
        <tr>
            <td class="wmd_70 clearfix">
                {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!} 
                {{ csrf_field() }}
                <div class="input-group">
                    <div class="input-group-btn clearfix">
                        <?php echo number_dropdown(50, 500, 50, null, 'xsw_30'); ?>
                        <div style="width:12%;" class="col-md-2 col-sm-3 xsw_70 no_pad">
                            <select class="form-control" id="process_status" name="process_status">
                                <option value="">All</option>
                                <option value="{{ORDER_PROCESSED}}">Complete</option>
                                <option value="{{ORDER_PENDING}}">Pending</option>
                            </select>
                        </div> 
                        <div style="width:17%;" class="col-md-2 xsw_50 col-sm-3 no_pad">
                            <div class="input-group">
                                <input type="text" class="form-control pickdate" id="from_date" name="from_date" placeholder="(dd-mm-yyyy)" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div> 
                        <div style="padding: 7px 0;width:3%" class="col-md-1 col-sm-1 hidden-xs text-center">
                            <span style="font-size:14px;font-weight:600;">TO</span>
                        </div>
                        <div style="width:17%;" class="col-md-2 xsw_50 col-sm-3 no_pad">
                            <div class="input-group">
                                <input type="text" class="form-control pickdate" id="end_date" name="end_date" placeholder="(dd-mm-yyyy)" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div> 
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad" style="width:14%;">
                            <input type="text" class="form-control" id="srch" name="srch" placeholder="party" size="30">
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad" style="width:10%;">
                            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="invoice" size="30">
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad" style="width:15%">
                            <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                            <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </td>
            <td class="text-right wmd_30 clearfix" style="width:25%">
                <a class="btn btn-success btn-xs xsw_25" href="{{ url ('inv/purchase-return/create') }}"><i class="fa fa-plus"></i> New</a>
                <button class="btn btn-primary btn-xs xsw_25" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                <?php if (has_user_access('reset_order')) : ?>
                    <button type="button" class="btn btn-warning btn-xs xsw_25" id="btn_reset" disabled><i class="fa fa-wrench"></i> Reset</button>
                <?php endif; ?>
                <?php if (has_user_access('inv_purchase_delete')) : ?>
                    <button type="button" class="btn btn-danger btn-xs xsw_25" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

{!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
<div id="print_area">
    <?php print_header("Purchase Return List", true, false); ?>

    <div id="ajax_content"> 
        @if(!empty($dataset) && count($dataset) > 0)
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tr class="bg-info" id="r_checkAll">
                    <th class="text-center" style="width:4%;">SL#</th>
                    <th style="width:100px">Date</th>
                    <th>Invoice No</th>
                    <th style="width:22%">From</th>
                    <th style="width:22%">To</th>
                    <th class="text-center" style="width:5%;">Items</th>
                    <th class="text-right" style="width:8%;">Amount</th>
                    <th class="text-center hip" style="width:15%;">Actions</th>
                    <th class="text-center hip" style="width:3%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php $counter++; ?>
                <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                    <td class="text-center">{{ change_lang($counter) }}</td>
                    <td>{{ change_lang(date_dmy($data->invoice_date)) }}</td>
                    <td>{{ change_lang($data->invoice_no) }}</td>
                    <td>{{ $data->subhead_name($data->from_subhead_id) }} {{ !empty($data->from_particular_id) ? "-> " . $data->particular_name($data->from_particular_id) : "" }}</td>
                    <td>{{ $data->subhead_name($data->to_subhead_id) }} {{ !empty($data->to_particular_id) ? "-> " . $data->particular_name($data->to_particular_id) : "" }}</td>
                    <td class="text-center">{{ change_lang(count($data->items)) }}</td>
                    <td class="text-right">{{ change_lang($data->total_amount) }}</td>
                    <td class="text-center hip">
                        @if ($data->process_status == ORDER_PENDING)
                        <a class="btn btn-info btn-xs" href="purchase-return/{{$data->_key}}/edit">Edit</a>
                        <a class="btn btn-warning btn-xs btn_process" href="javascript:void(0)" data-info="{{$data->_key}}">Process</a>
                        @endif
                        <a class="btn btn-primary btn-xs" href="purchase-return/detail/{{$data->_key}}">View</a>
                    </td>
                    <td class="text-center hip">
                        <?php if (has_user_access('inv_purchase_delete')) : ?>
                            <input type="checkbox" name="data[]" value="{{ $data->id }}">
                        <?php endif; ?>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="mb_10 text-center hip">
            {{ $dataset->render() }}
        </div>
        @else
        <div class="alert alert-info">No records found.</div>
        @endif
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/purchase-return/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", ".btn_process", function () {
            var _url = "{{ URL::to('inv/purchase-return/process') }}";
            var _formdata = {};
            _formdata._token = '{{ csrf_token() }}';
            _formdata._id = $(this).attr('data-info');

            $.post(_url, _formdata, function (resp) {
                if (resp.success === true) {
                    $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'success'});
                    $("#search").trigger("click");
                } else {
                    $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'error'});
                }
            }, "json");
        });

        $(document).on("click", "#btn_reset", function () {
            var _url = "{{ URL::to('inv/purchase-return/reset') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {
                $.post(_url, _form.serialize(), function (resp) {
                    if (resp.success === true) {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'success'});
                        $("#search").trigger("click");
                    } else {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'error'});
                    }
                }, "json");
            }
        });

        $(document).on("click", "#Del_btn", function () {
            var _url = "{{ URL::to('inv/purchase-return/delete') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {
                $.post(_url, _form.serialize(), function (resp) {
                    if (resp.success === true) {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'success'});
                        $("#search").trigger("click");
                    } else {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'error'});
                    }
                }, "json");
            }
        });
    });
</script>
@endsection