@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-2 col-xs-2 no_pad">
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
            <li>Purchase Items</li>
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
                <div class="input-group">
                    <div class="input-group-btn clearfix">
                        <?php echo number_dropdown(50, 500, 50, null, 'xsw_30'); ?> 
                        <div class="col-md-2 col-sm-3 xsw_70 no_pad">                            
                            <input type="text" class="form-control" id="srch" name="srch" placeholder="search party" size="30">
                        </div>                       
                        <div style="width:17%;" class="col-md-2 xsw_50 col-sm-3 no_pad">
                            <div class="input-group">
                                <input type="text" class="form-control pickdate" id="from_date" name="from_date" placeholder="(dd-mm-yyyy)" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div> 
                        <div style="width:5%" class="col-md-1 hidden-xs col-sm-1 no_pad">
                            <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                        </div> 
                        <div style="width:17%;" class="col-md-2 xsw_50 col-sm-3 no_pad">
                            <div class="input-group">
                                <input type="text" class="form-control pickdate" id="end_date" name="end_date" placeholder="(dd-mm-yyyy)" size="30" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 xsw_100 no_pad">                            
                            <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                            <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </td>
            <td class="text-right wmd_30 clearfix" style="width:25%">
                <a class="btn btn-success btn-xs xsw_25" href="{{ url ('inv/purchase/create') }}"><i class="fa fa-plus"></i> New</a>
                <button class="btn btn-primary btn-xs xsw_25" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
            </td>
        </tr>
    </table>
</div>

<div id="print_area">
    <?php print_header("Purchase Item List", true, false); ?>

    <div id="ajax_content"> 
        @if(!empty($dataset) && count($dataset) > 0)
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tr class="bg-info" id="r_checkAll">
                    <th class="text-center" style="width:4%;">SL#</th>
                    <th style="width:100px">Date</th>
                    <th>Company</th>
                    <th>Business</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th class="text-center" style="width: 80px;">Quantity</th>
                    <th class="text-center" style="width: 80px;">Rate</th>
                    <th class="text-right" style="width: 100px;">Amount</th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                foreach ($dataset as $data):
                    $counter++;
                    $_qty = round($data->quantity, 2);
                    $_rate = round($data->rate, 2);
                    $_amount = round($data->amount, 2);
                    ?>
                    <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                        <td class="text-center">{{ change_lang($counter) }}</td>
                        <td>{{ change_lang(date_dmy($data->invoice_date)) }}</td>
                        <td><?= !empty($data->institute) ? $data->institute->name : ""; ?></td>
                        <td><?= !empty($data->business_type) ? $data->business_type->business_type : ""; ?></td>
                        <td><?= $data->category->name; ?></td>
                        <td><?= $data->product->name; ?></td>
                        <td class="text-center"><?= change_lang($_qty); ?></td>
                        <td class="text-center"><?= change_lang($_rate); ?></td>
                        <td class="text-right"><?= change_lang($_amount); ?></td>
                    </tr>
                    <?php
                    $_sumQty[] = $_qty;
                    $_sumAmount[] = $_amount;
                endforeach;
                ?>
                <tr class="bg-info">
                    <th class="text-right" colspan="6">Total</th>
                    <th class="text-center" style="width: 80px;"><?= change_lang(array_sum($_sumQty)); ?></th>
                    <th class="text-center" style=""></th>
                    <th class="text-right" style="width: 100px;"><?= change_lang(array_sum($_sumAmount)); ?></th>
                </tr>
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

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/purchase/search_items') }}";
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
    });
</script>
@endsection