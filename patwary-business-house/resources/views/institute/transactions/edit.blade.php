@extends('admin.layouts.column1')

<?php
$frm_head = $data->cr_subhead_id;
$frm_particular = $data->cr_particular_id;
$to_head = $data->dr_subhead_id;
$to_particular = $data->dr_particular_id;
if ($data->type == 'D') {
    $tp = 'd';
} elseif ($data->type == 'C') {
    $tp = 'c';
} else {
    $tp = 'journal';
}
if ($tp == 'd') {
    $pcls = "success";
    $pbg = "bg-success";
    $title = "Receive";
} elseif ($tp == 'c') {
    $pcls = "danger";
    $pbg = "bg-danger";
    $title = "Payment";
} else {
    $pcls = "warning";
    $pbg = "bg-warning";
    $title = "Journal";
}
?>
@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Transaction Information ({{ $title }} Voucher)</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li><a href="{{ url('/transactions') }}">Transaction</a> <span class="fa fa-angle-right"></span></li>
            <li>Form</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-8 col-sm-10 col-md-offset-2 col-sm-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update {{ $title }} Voucher Information</h3>
            </div>
            <div class="panel-body {{$pbg}}">
                {!! Form::open(['method' => 'PUT', 'url' => 'transactions/'.$data->id, 'id' => 'frm_Transaction'  , 'class' => '']) !!}
                <input type="hidden" name="type" value="{{ $tp }}">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <div class="mb_10 clearfix">
                            <label for="datepicker" class="">Date</label>
                            <div class="input-group">
                                <input type="text" id="datepicker" class="form-control pickdate" name="date" value="{{ !empty($data->date) ? date_dmy($data->date) : date('d-m-Y') }}" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <small class="text-danger">{{ $errors->first('date') }}</small>
                            </div>
                        </div>
                        <div class="mb_10 clearfix">
                            <label for="description" class="">Description</label>
                            <textarea id="description" class="form-control" name="description">{{ $data->description }}</textarea>
                            <small class="text-danger">{{ $errors->first('description') }}</small>
                        </div>
                        <div class="mb_10 clearfix">
                            <label for="by_whom" class="">By Whom</label>
                            <input type="text" id="by_whom" class="form-control" name="by_whom" value="{{ $data->by_whom }}">
                            <small class="text-danger">{{ $errors->first('by_whom') }}</small>
                        </div>
                        <div class="mb_10 clearfix">
                            <label for="amount" class="">Amount</label>
                            <div class="input-group">
                                <input type="number" id="amount" class="form-control" name="amount" min="0" value="{{ $data->amount }}" required>
                                <span class="input-group-addon">Tk</span>
                            </div>
                            <small class="text-danger">{{ $errors->first('amount') }}</small>
                        </div>
                    </div>

                    <div class="col-md-4">                        
                        <div class="mb_10 clearfix">
                            <label class="">From Head</label>
                            <div class="mb_10 clearfix">
                                <select id="headDebit" class="form-control" name="frm_subhead" required>
                                    <option value="">Select Head</option>
                                    @foreach($heads as $head)
                                    <option value="{{ $head->id }}" @if($frm_head == $head->id) {{ 'selected' }} @endif>{{$head->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{ $errors->first('frm_subhead') }}</small>
                            </div>
                            <div class="clearfix">
                                <select id="subheadDebit" class="form-control" name="frm_particular">
                                    @foreach($particular->where('subhead_id',$frm_head)->get() as $pt)
                                    <option value="">Select Sub Head</option>
                                    <option value="{{$pt->id}}" @if($frm_particular == $pt->id) {{ 'selected' }} @endif>{{$pt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb_10 clearfix">
                            <label class="">To Head</label>
                            <div class="mb_10 clearfix">
                                <select id="headCredit" class="form-control" name="to_subhead" required>
                                    <option value="">Select Head</option>
                                    @foreach($heads as $head)
                                    <option value="{{$head->id}}" @if($to_head == $head->id) {{ 'selected' }} @endif>{{$head->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{ $errors->first('to_subhead') }}</small>
                            </div>
                            <div class="clearfix">
                                <select id="subheadCredit" class="form-control" name="to_particular">
                                    @foreach($particular->where('subhead_id',$to_head)->get() as $pt)
                                    <option value="">Select Sub Head</option>
                                    <option value="{{$pt->id}}" @if($to_particular == $pt->id) {{ 'selected' }} @endif>{{$pt->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb_10 clearfix">
                            <label for="payment_method" class="">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="{{ PAYMENT_CASH }}" <?php if ($data->payment_method == PAYMENT_CASH) echo ' selected'; ?>>{{ PAYMENT_CASH }}</option>
                                <option value="{{ PAYMENT_BANK }}" <?php if ($data->payment_method == PAYMENT_BANK) echo ' selected'; ?>>{{ PAYMENT_BANK }}</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('payment_method') }}</small>
                        </div>
                        <div class="mb_10 clearfix">
                            <label for="datepicker_cid" class="">Check Issue Date</label>
                            <div class="input-group">
                                <input type="text" id="datepicker_cid" class="form-control pickdate" name="check_issue_date" placeholder="(dd-mm-yyyy)" value="{{ !empty($data->check_issue_date) ? date_dmy($data->check_issue_date) : '' }}" readonly disabled>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <small class="text-danger">{{ $errors->first('check_issue_date') }}</small>
                            </div>
                        </div>
                        <div class="mb_10 clearfix">
                            <label for="bank_info" class="">Bank Info</label>
                            <textarea id="bank_info" class="form-control" name="bank_info" disabled>{{ $data->bank_info }}</textarea>
                            <small class="text-danger">{{ $errors->first('bank_info') }}</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary xsw_100" name="btnSave" value="Update" style="width: 33%">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($("#payment_method").val() == "Bank Payment") {
            enable("#datepicker_cid");
            enable("#bank_info");
        } else {
            $("#datepicker_cid").val("");
            $("#bank_info").val("");
            disable("#datepicker_cid");
            disable("#bank_info");
        }

        $(document).on("change", "#headCredit", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subheadCredit");
                    $('#subheadCredit').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#headDebit", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subheadDebit");
                    $('#subheadDebit').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#payment_method", function () {
            if ($(this).val() == "Bank Payment") {
                enable("#datepicker_cid");
                enable("#bank_info");
            } else {
                $("#datepicker_cid").val("");
                $("#bank_info").val("");
                disable("#datepicker_cid");
                disable("#bank_info");
            }
        });
    });

    $("#reset_from").click(function () {
        var _form = $("#frm_Transaction");
        _form[0].reset();
    });
</script>
@endsection