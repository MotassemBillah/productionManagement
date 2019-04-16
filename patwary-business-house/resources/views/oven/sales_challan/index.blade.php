@extends('admin.layouts.column2')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales Challan</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span> Sales</span></li>
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
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <input type="text" style="width:115px;" name="challan_no" id="q" class="form-control" placeholder="search challan no" size="30"/>
                            <input type="text" style="width:115px;" name="order_no" id="q" class="form-control" placeholder="search order" size="30"/>
                            <input type="text" style="width:135px;" name="supplier" id="q" class="form-control" placeholder="search supplier" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:20%">
                    <a href="{{ url ('oven/sales-challan/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list"> 
    {!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
    <div id="print_area">
        <?php print_header("Sales Challan Information"); ?>
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Challan No</th>
                            <th>Order No</th>
                            <th class="text-center">Truck No</th>
                            <th class="text-right">Total Quantity</th>
                            <th class="text-center hip">Actions</th>
                            <th class="text-center hip">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="check_all"value="all"></label>
                                </div>
                            </th>
                        </tr>
                        <?php
                        $counter = 0;
                        $total_quantity = [];
                        if (isset($_GET['page']) && $_GET['page'] > 1) {
                            $counter = ($_GET['page'] - 1) * $dataset->perPage();
                        }
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $counter++;
                        $total_quantity[] = $data->total_quantity;
                        ?>   
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $counter }}</td>
                            <td>{{ date_dmy($data->date) }}</td>
                            <td>{{ !empty($data->supplier_particular) ? $data->particularName($data->supplier_particular) : '' }}</td>
                            <td>{{ $data->challan_no }}</td>
                            <td>{{ $data->order_no }}</td>
                            <td class="text-center">{{ $data->truck_no }}</td>
                            <td class="text-right">{{ $data->total_quantity }}</td>
                            <td class="text-center hip">
                                <a class="btn btn-success btn-xs" href="sales-challan/{{ $data->id }}"><i class="fa fa-plus"></i> View</a> 
                                <a class="btn btn-info btn-xs" href="sales-challan/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                            </td>
                            <td class="text-center hip">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg_gray">
                            <th colspan="6" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                            <th class="text-right">{{ array_sum($total_quantity) }}</th>
                            <td colspan="2" class="hip"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center hip">
                    {{ $dataset->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('oven/sales-challan/search') }}";
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
            var _url = "{{ URL::to('oven/sales-challan/delete') }}";
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