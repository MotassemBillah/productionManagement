@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Finish Stocks Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Stock</span></li>
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
                                <select id="category" class="form-control" name="category">
                                    <option value="">All Category</option>
                                    @foreach( $categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>   
                            <div class="col-md-2 col-sm-3 no_pad">
                                <select id="finishProduct" class="form-control" name="product" disabled>
                                    <option value="">All Product</option>                  
                                </select>
                            </div>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}  
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
    <div id="print_area">
        {{ print_header("Finish Stocks Information") }}
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped tbl_thin">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Unit</th>
                            <th class="text-right">Previous</th>
                            <th class="text-right">Production</th>
                            <th class="text-right">Sales</th>
                            <th class="text-right">Remain</th>
                        </tr>
                        <?php
                        $sl = 1;
                        $total_previous = 0;
                        $total_purchase = 0;
                        $total_production = 0;
                        $total_remain = 0;
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $total_previous += $stock->sumOpeningQuantity($data->id);
                        $total_purchase += $stock->sumInQuantity($data->id);
                        $total_production += $stock->sumOutQuantity($data->id);
                        $total_remain += $stock->sumStockQuantity($data->id);
                        ?>                       
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $sl }}</td>
                            <td>{{ $data->category->name }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->unit }}</td>
                            <td class="text-right">{{ $stock->sumOpeningQuantity($data->id) }}</td>
                            <td class="text-right">{{ $stock->sumInQuantity($data->id) }}</td>
                            <td class="text-right">{{ $stock->sumOutQuantity($data->id) }}</td>
                            <td class="text-right">{{ $stock->sumStockQuantity($data->id) }}</td>
                            <?php $sl++; ?>
                        </tr>
                        @endforeach
                        <tr class="bg_gray">
                            <th colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                            <th class="text-right">{{ $total_previous }}</th>
                            <th class="text-right">{{ $total_purchase }}</th>
                            <th class="text-right">{{ $total_production }}</th>
                            <th class="text-right">{{ $total_remain }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {


        $(document).on("change", "#category", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('inv/list_product') }}",
                type: "post",
                data: {'category': id, 'type': 'Finish', '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#finishProduct");
                    $('#finishProduct').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $("#search").click(function () {
            var _url = "{{ URL::to('packaging/finishstocks/details/search') }}";
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