@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Stocks List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li>
            <li>Stock</li>
        </ul>                            
    </div>
</div>

<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!} 
                    {{ csrf_field() }}
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <?php echo number_dropdown(50, 500, 50) ?>
                            <div class="col-md-2 col-sm-3 no_pad">
                                <select id="orderType" class="form-control" name="category">
                                    <option value="">All Category</option>
                                    @foreach( $categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>   
                            <div class="col-md-2 col-sm-3 no_pad">
                                <select id="orderType" class="form-control" name="product">
                                    <option value="">All Product</option>
                                    @foreach( $products as $pro)
                                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>   
                            <input type="text" name="search" id="q" class="form-control" placeholder="search product" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}  
                </td>
                <td class="text-right wmd_30" style="">
                    <a href="{{ url ('rice/purchase-challan/create') }}"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New</button></a>
                    <a href="{{ url ('rice/raw-opening-stocks') }}"><button class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Opening Stocks</button></a>
                </td>
                <td class="text-right wmd_30" style="">
                    <button class="btn btn-primary btn-sm" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button> 
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list">
    <div style="display:none;" id="ajaxmsg"></div>
    <div id="ajax_content">
        <div class="table-responsive" id="print_area">
            {{ print_header("Stocks Information") }}
            <table class="table table-bordered table-striped tbl_thin">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Category Name</th>
                        <th>Product Name</th>
                        <th class="text-right">Net Weight (Kg)</th>
                        <th class="text-right">Quantity (Bag)</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $total_weight = 0;
                    $total_quantity = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    $stock_weight = $stock->sumStockWeight($data->id);
                    $stock_quantity = $stock->sumStockQuantity($data->id);
                    $total_weight += $stock_weight;
                    $total_quantity += $stock_quantity;
                    ?>
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $data->category->name }}</td>
                        <td>{{ $data->name }}</td>
                        <td class="text-right">{{ $stock_weight }}</td>
                        <td class="text-right">{{ $stock_quantity }}</td>
                        <?php $sl++; ?>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th colspan="3" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                        <th class="text-right">{{ $total_weight }}</th>
                        <th class="text-right">{{ $total_quantity }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $("#search").click(function () {
            var _url = "{{ URL::to('rice/stocks/search') }}";
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

        })

        $("#clear_from").click(function () {
            $("#frmSearch").find("input[type=text], textarea").val("");
        });

    });
</script>

@endsection