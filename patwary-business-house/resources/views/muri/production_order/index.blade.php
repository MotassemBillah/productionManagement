@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Order List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span> Production</span></li>
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
                            <select id="itemCount" class="form-control" name="item_count" style="width:58px;">
                                <?php
                                for ($i = 10; $i <= 100; $i += 10):
                                    echo "<option value='{$i}'>{$i}</option>";
                                endfor;
                                ?>                        
                            </select>
                            <div style="width:11%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by">
                                    <option value="all" selected>All</option>                  
                                    <option value="pending" >Pending</option>
                                    <option value="completed" >Completed</option>
                                </select>
                            </div>  
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <input type="text" style="width:182px;" name="search" id="q" class="form-control" placeholder="search order no" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:20%">
                    <a href="{{ url ('production-order/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <?php if (has_user_access('production_order_delete')) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <?php endif; ?>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list"> 
    {!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
    <div id="print_area">
        <?php print_header("Prouduction Order Information"); ?>
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Date</th>
                            <th>Order No</th>
                            <th class="text-center">Items</th>
                            <th class="text-right">Net Weight</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-center">Status</th>
                            <th class="text-center hip">Actions</th>
                            <th class="text-center hip">
                                <?php if (has_user_access('production_order_delete')) : ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="check_all"value="all"></label>
                                    </div>
                                <?php endif; ?>
                            </th>
                        </tr>
                        <?php
                        $sl = 1;
                        $total_weight = 0;
                        $total_quantity = 0;
                        $status = '';
                        $btn = '';
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $date = date_dmy($data->date);
                        $order_no = !empty($data->order_no) ? $data->order_no : '';
                        $no_of_item = $data->items()->count();

                        $net_weight = $data->items()->sum('net_weight');
                        $net_quantity = $data->items()->sum('net_quantity');

                        $total_weight += $net_weight;
                        $total_quantity += $net_quantity;

                        if ($data->process_status == 0) {
                            $status = 'Pending';
                            $btn = 'warning';
                        } else {
                            $status = 'Completed';
                            $btn = 'success';
                        }
                        ?>   
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $sl }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ $order_no }}</td>
                            <td class="text-center">{{ $no_of_item }}</td>
                            <td class="text-right">{{ show_float_number($net_weight) }}</td>
                            <td class="text-right">{{ $net_quantity }}</td>
                            <td class="text-center" ><span class="label label-{{ $btn }} btn-xs">{{ $status }}</span></td>
                            <td class="text-center hip">
                                <?php if ($status == 'Pending'): ?>
                                    <a class="btn btn-success btn-xs" href="production-order/{{ $data->id }}"><i class="fa fa-eye"></i> View</a> 
                                    <a class="btn btn-info btn-xs" href="production-order/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>    
                                    <?php if (has_user_access('production_order_confirm')) : ?>
                                        <a class="btn btn-primary btn-xs" href="production-order/{{ $data->id }}/confirm" onClick="return confirm('Are you sure, Production Complete? This cannot be undone!');" ><i class="fa fa-gavel"></i> Process</a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <a class="btn btn-success btn-xs" href="production-order/{{ $data->id }}"><i class="fa fa-plus"></i> View</a>  
                                <?php endif; ?>
                            </td>
                            <td class="text-center hip">
                                <?php if (has_user_access('production_order_delete')) : ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                                    </div>
                                <?php endif; ?> 
                            </td>
                            <?php $sl++; ?>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</td>
                            <td class="text-right" style="font-weight:600;">{{ show_float_number($total_weight)  }}</td>
                            <td class="text-right" style="font-weight:600;">{{ $total_quantity }}</td>
                            <td style="font-weight:600;"></td>
                            <td class="hip" style="font-weight:600;"  colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('production-order/search') }}";
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
            var _url = "{{ URL::to('production-order/delete') }}";
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