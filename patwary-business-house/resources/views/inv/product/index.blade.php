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
            <li>Product</li>
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
                {{ csrf_field() }}
                <div class="input-group">
                    <div class="input-group-btn clearfix">
                        <?php echo number_dropdown(50, 500, 50, null, 'xsw_30'); ?>                        
                        <div class="col-md-2 col-sm-3 xsw_70 no_pad">                            
                            <input type="text" name="srch" id="srch" class="form-control" placeholder="search" size="30">
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">                            
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
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad">                            
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Product Type</option>
                                @foreach ($types as $tkey => $tval)
                                <option value="{{ $tkey }}">{{ $tval }}</option>
                                @endforeach
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
            <td class="text-right wmd_30" style="">
                <a class="btn btn-success btn-xs xsw_33" href="{{ url ('inv/product/create') }}"><i class="fa fa-plus"></i> New</a>
                <?php if (has_user_access('inv_product_delete')) : ?>
                    <button type="button" class="btn btn-danger btn-xs xsw_33" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                <?php endif; ?>
                <button class="btn btn-primary btn-xs xsw_33" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
            </td>
        </tr>
    </table>
</div>

{!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
<div id="print_area">
    <?php print_header("Product List", true, false); ?>

    <div id="ajax_content"> 
        @if(!empty($dataset) && count($dataset) > 0)
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tr class="bg-info" id="r_checkAll">
                    <th class="text-center" style="width:4%;">SL#</th>
                    <th>Business Type</th>
                    <th>Category Name</th>
                    <th>Product Type</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Weight</th>
                    <th>Color</th>
                    <th>Grade</th>
                    <th>Printed</th>
                    <th>Laminated</th>
                    <th>Liner</th>
                    <th>Buy Price</th>
                    <th class="text-center">Actions</th>
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
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ !empty($data->business_type) ? $data->business_type->business_type : "" }}</td>
                    <td>{{ !empty($data->category) ? $data->category->name : "" }}</td>
                    <td>{{ $data->type }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ $data->size }}</td>
                    <td>{{ $data->weight }}</td>
                    <td>{{ $data->color }}</td>
                    <td>{{ $data->grade }}</td>
                    <td>{{ $data->printed }}</td>
                    <td>{{ $data->laminated }}</td>
                    <td>{{ $data->liner }}</td>
                    <td>{{ $data->buy_price }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="product/{{$data->id}}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td class="text-center hip">
                        <?php if (has_user_access('inv_product_delete')) : ?>
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

        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/product/search') }}";
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

        $(document).on("click", "#Del_btn", function () {
            var _url = "{{ URL::to('inv/product/delete') }}";
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