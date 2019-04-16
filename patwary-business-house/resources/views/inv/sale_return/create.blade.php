@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-2 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-4 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv/sale-return') }}">Sale Return</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div class="well">
    <table width="100%">
        <tr>
            <td class="wmd_70">
                {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!} 
                <div class="input-group">
                    <div class="input-group-btn clearfix">                        
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">                            
                            <select class="form-control" id="institute_id" name="institute_id" required>
                                <option value="">Company</option>
                                @foreach ($institute_list as $institute)
                                <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad">                            
                            <select class="form-control" id="business_type_id" name="business_type_id" required>
                                <option value="">Business Type</option>
                                @foreach ($business_types as $btype)
                                <option value="{{ $btype->id }}">{{ $btype->business_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad">                            
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Category</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">                            
                            <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                            <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </td>
            <td class="wmd_30 text-right" style="width: 12%;">
                <a class="btn btn-success btn-xs xsw_33" href="{{ url('/inv/sale-return/cart') }}">{{ trans('words.view_cart') }}</a>
            </td>
        </tr>
    </table>
</div>
<div class="clearfix">
    <form action="" class="form-horizontal" method="POST">
        {{ csrf_field() }}
        <div id="ajax_content"></div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#business_type_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('inv/list_buisness_category') }}",
                type: "post",
                data: {'business_type': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $("#category_id").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/sale-return/search_product') }}";
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

        $(document).on("input", ".qty_rate", function () {
            $("#ajaxMessage").slideUp('fast');
            $(this).removeClass('bdr_err');
            var _id = $(this).attr('data-info');
            var _qty = $("#qty_" + _id).val();
            var _rate = $("#rate_" + _id).val();
            var _amount = 0;
            if (isNaN(_qty)) {
                _qty = 0;
            }
            if (isNaN(_rate)) {
                _rate = 0;
            }

            _amount += (_qty * _rate);
            //console.log(parseFloat(_amount).toFixed(2));
            $("#subtotal_" + _id).val(parseFloat(_amount).toFixed(2));
        });

        $(document).on("click", ".add_to_cart", function () {
            var _pid = $(this).attr('data-pid');

            if ($("#qty_" + _pid).val() == '' || $("#qty_" + _pid).val() <= 0) {
                $('#ajaxMessage').showAjaxMessage({html: "Quantity required", type: 'error'});
                $("#qty_" + _pid).addClass('bdr_err').focus();
                return false;
            }

            if ($("#rate_" + _pid).val() == '' || $("#rate_" + _pid).val() <= 0) {
                $('#ajaxMessage').showAjaxMessage({html: "Rate required", type: 'error'});
                $("#rate_" + _pid).addClass('bdr_err').focus();
                return false;
            }

            var _url = "{{ URL::to('inv/sale-return/add_cart_item') }}";
            var _formdata = {};
            _formdata._token = '{{ csrf_token() }}';
            _formdata.inst_id = $("#institute_id").val();
            _formdata.btid = $("#business_type_id").val();
            _formdata.catid = $("#category_id").val();
            _formdata.pid = _pid;
            _formdata.qty = $("#qty_" + _pid).val();
            _formdata.rate = $("#rate_" + _pid).val();
            _formdata.amount = $("#subtotal_" + _pid).val();

            $.post(_url, _formdata, function (resp) {
                if (resp.success === true) {
                    $("#ajaxMessage").showAjaxMessage({html: resp.message, type: "success"});
                    $(".qty_rate").val('');
                    $(".subtotal").val('');
                } else {
                    $("#row_" + _pid).addClass('bg-danger');
                    $("#ajaxMessage").showAjaxMessage({html: resp.message, type: "error"});
                }
            }, "json");
        });
    });
</script>
@endsection