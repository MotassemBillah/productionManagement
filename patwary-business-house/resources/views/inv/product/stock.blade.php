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
            <li>Stock</li>
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
                        <?php echo number_dropdown(50, 500, 50, null, 'xsw_30'); ?>
                        <div class="col-md-2 col-sm-3 xsw_70 no_pad clearfix">                            
                            <input type="text" name="srch" id="srch" class="form-control" placeholder="search" size="30">
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad clearfix">                            
                            <select class="form-control" id="business_type_id" name="business_type_id" required>
                                <option value="">Business Type</option>
                                @foreach ($business_types as $btype)
                                <option value="{{ $btype->id }}">{{ $btype->business_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad clearfix">                            
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Category</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_50 no_pad clearfix">                            
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Product Type</option>
                                @foreach ($types as $tkey => $tval)
                                <option value="{{ $tkey }}">{{ $tval }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad clearfix">
                            <button type="button" class="btn btn-info xsw_33" id="search">Search</button>
                            <button type="button" class="btn btn-warning xsw_33" id="clear_from">Clear</button>
                            <button type="button" class="btn btn-primary xsw_33" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
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
                    <th class="text-center">Weight</th>
                    <th class="text-center" style="width:80px;">O.Stock</th>
                    <th class="text-center" style="width:80px;">Purchase</th>
                    <th class="text-center" style="width:80px;">Sale</th>
                    <th class="text-center" style="width:80px;">T.Stock</th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $_ostock = $stockModel->opening_qty($data->id);
                $_pstock = $stockModel->purchase_qty($data->id);
                $_sstock = $stockModel->sale_qty($data->id);
                $_tstock = $stockModel->available_qty($data->id);
                ?>
                <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ !empty($data->business_type) ? $data->business_type->business_type : "" }}</td>
                    <td>{{ !empty($data->category) ? $data->category->name : "" }}</td>
                    <td>{{ $data->type }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ $data->size }}</td>
                    <td class="text-center">{{ $data->weight }}</td>
                    <td class="">{{$_ostock}} <span class="pull-right"><a class="ostock" href="javascript:void(0);" title="Click This Icon To Update Opening Stock" data-productid="<?= $data->id; ?>"><i class="fa fa-edit"></i></a></span></td>
                    <td class="text-center">{{$_pstock}}</td>
                    <td class="text-center">{{$_sstock}}</td>
                    <td class="text-center">{{$_tstock}}</td>
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
<div class="modal fade" id="containerForInfo" tabindex="-1" role="dialog" aria-labelledby="containerForPriceInfoLabel"></div>
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
            var _url = "{{ URL::to('inv/product/search_stock') }}";
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

        $(document).on("click", ".show_price", function (e) {
            showLoader("Processing...", true);
            var _key = $(this).attr("data-info");
            var _url = baseUrl + '/product/show_price?id=' + _key;

            $("#containerForInfo").load(_url, function () {
                $("#containerForInfo").modal({
                    backdrop: 'static',
                    keyboard: false
                });
                showLoader("", false);
            });
            e.preventDefault();
        });

        $(document).on("click", ".ostock", function (e) {
            var _pid = $(this).attr("data-productid");
            var _url = "{{ URL::to('inv/product/form_opening_stock') }}/" + _pid;

            $("#containerForInfo").load(_url, function () {
                $("#containerForInfo").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
            e.preventDefault();
        });

        $(document).on("submit", "#frmOpeningStock", function (e) {
            showLoader("Processing...", true);
            var _form = $(this);
            var _url = "{{ URL::to('inv/product/update_opening_stock') }}";

            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    $("button.close").trigger("click");
                    $("#search").trigger("click");
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");

            e.preventDefault();
            return false;
        });
    });
</script>
@endsection