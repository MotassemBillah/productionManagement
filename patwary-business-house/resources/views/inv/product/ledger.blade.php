@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-2 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs no_pad text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-4 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv/product') }}">Product</a> <i class="fa fa-angle-right"></i></li>
            <li>Ledger</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div class="well">
    <table width="100%">
        <tr>
            <td class="">
                {!! Form::open(['method' => 'POST', 'class' => 'search-form', 'id'=>'frmSearch', 'name'=>'frmSearch']) !!} 
                <div class="input-group">
                    <div class="input-group-btn clearfix">
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <select class="form-control xsw_50" id="business_type_id" name="business_type_id" required>
                                <option value="">Business Type</option>
                                @foreach ($business_types as $btype)
                                <option value="{{ $btype->id }}">{{ $btype->business_type }}</option>
                                @endforeach
                            </select>
                            <select class="form-control xsw_50" id="category_id" name="category_id" required>
                                <option value="">Category</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <input type="text" class="form-control xsw_40" id="" placeholder="filter product" onkeyup="filter_list(this.value, 'product_id')">
                            <select class="form-control xsw_60" id="product_id" name="product_id" required>
                                <option value="">Product</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <input type="text" class="form-control xsw_40" id="" placeholder="filter subhead" onkeyup="filter_list(this.value, 'subhead_id')">
                            <select class="form-control xsw_60" id="subhead_id" name="subhead_id" required>
                                <option value="">Select Subhead</option>
                                @foreach($subhead_list as $shlist)
                                <option value="{{ $shlist->id }}">{{ $shlist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <input type="text" class="form-control xsw_40" id="" placeholder="filter particular" onkeyup="filter_list(this.value, 'particular_id')">
                            <select class="form-control xsw_60" id="particular_id" name="particular_id" required>
                                <option value="">Select Particular</option>
                            </select>
                        </div>
                        <div style="width:13%;" class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <div class="input-group xsw_50">
                                <input type="text" class="form-control pickdate" id="from_date" name="from_date" value="{{ date_dmy($startDate) }}" placeholder="from date" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <div class="input-group xsw_50">
                                <input type="text" class="form-control pickdate" id="end_date" name="end_date" value="{{ date_dmy($endDate) }}" placeholder="to date" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                            <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                            <button type="button" class="btn btn-primary xsw_50" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>                
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    </table>
</div>

<div id="print_area">
    <div id="ajax_content"></div>
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
                    $('#category_id').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#category_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('inv/list_product') }}",
                type: "post",
                data: {'category': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#product_id').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#subhead_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#particular_id");
                    $("#particular_id").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/product/search_ledger') }}";
            var _form = $("#frmSearch");

            if ($("#product_id").val() == "") {
                $("#ajaxMessage").showAjaxMessage({html: "Please select a product", type: 'error'});
                $("#product_id").focus();
                return false;
            } else if ($("#particular_id").val() == "") {
                $("#ajaxMessage").showAjaxMessage({html: "Please select a particulart", type: 'error'});
                $("#particular_id").focus();
                return false;
            } else {
                $("#ajaxMessage").hide();
                $.ajax({
                    url: _url,
                    type: "POST",
                    data: _form.serialize(),
                    success: function (data) {
                        $('#ajax_content').html(data);
                    },
                    error: function (xhr, status) {
                        alert('There is some error.Try after some time.');
                    }
                });
            }
        });
    });
</script>
@endsection