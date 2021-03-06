@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sales</span></li>
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
                            <input type="text" style="width:182px;" name="search" id="q" class="form-control" placeholder="search invoice" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:20%">
                    <a href="{{ url ('sales/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <?php if (has_user_access('sale_delete')) : ?>
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
        <?php print_header("Sales List"); ?>
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Net Weight</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th class="text-center">Process Status</th>
                            <th class="text-center">Payment Status</th>
                            <th class="text-center hip">Actions</th>
                            <?php if (has_user_access('sale_delete')) : ?>
                                <th class="text-center hip">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="check_all"value="all"></label>
                                    </div>
                                </th>
                            <?php endif; ?>
                        </tr>
                        <?php
                        $counter = 0;
                        if (isset($_GET['page']) && $_GET['page'] > 1) {
                            $counter = ($_GET['page'] - 1) * $dataset->perPage();
                        }
                        $total_weight = 0;
                        $total_quantity = 0;
                        $total_price = 0;
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $counter++;
                        $total_weight += $data->weight;
                        $total_quantity += $data->quantity;
                        $total_price += $data->invoice_amount;

                        if ($data->process_status == 0) {
                            $process_status = 'Pending';
                            $process_btn = 'warning';
                        } else {
                            $process_status = 'Completed';
                            $process_btn = 'success';
                        }

                        if ($data->payment_status == 0) {
                            $payment_status = 'Pending';
                            $payment_btn = 'warning';
                        } else {
                            $payment_status = 'Completed';
                            $payment_btn = 'success';
                        }
                        ?>   
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $counter }}</td>
                            <td>{{ date_dmy($data->date) }}</td>
                            <td>{{ !empty($data->invoice_no) ? $data->invoice_no : '' }}</td>
                            <td>{{ !empty($data->head_id) ? $subhead->find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . $particular->find($data->subhead_id)->name : '' }}</td>
                            <td class="text-center">{{ $data->items()->count()}}</td>
                            <td class="text-right">{{ $data->weight }}</td>
                            <td class="text-right">{{ $data->quantity }}</td>
                            <td class="text-right">{{ $data->invoice_amount }}</td>
                            <td class="text-center" ><span class="label label-{{ $process_btn }} btn-xs">{{ $process_status }}</span></td>
                            <td class="text-center" ><span class="label label-{{ $payment_btn }} btn-xs">{{ $payment_status }}</span></td>
                            <td class="text-center hip">
                                <?php if ($process_status == 'Pending'): ?>
                                    <a class="btn btn-success btn-xs" href="sales/{{ $data->id }}"><i class="fa fa-plus"></i> View</a> 
                                    <a class="btn btn-info btn-xs" href="sales/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                                    <?php if (has_user_access('sale_confirm')) : ?>
                                        <a class="btn btn-primary btn-xs" href="sales/{{ $data->id }}/confirm" onClick="return confirm('Are you sure, Sale Complete? This cannot be undone!');" ><i class="fa fa-gavel"></i> Process</a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <a class="btn btn-success btn-xs" href="sales/{{ $data->id }}"><i class="fa fa-plus"></i> View</a>  
                                    <a class="btn btn-primary btn-xs" href="sales/gatepass/{{ $data->id }}"><i class="fa fa-outdent"></i> Gate Pass</a>  
                                    <?php if (has_user_access('sale_confirm')) : ?>
                                        <a class="btn btn-danger btn-xs" href="sales/{{ $data->id }}/reset" onClick="return confirm('Are you sure, Sales Reset? This cannot be undone!');" ><i class="fa fa-refresh"></i> Reset</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center hip">
                                <?php if (has_user_access('sale_delete')) : ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg_gray">
                            <th colspan="5" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                            <th class="text-right">{{ $total_weight }}</th>
                            <th class="text-right">{{ $total_quantity }}</th>
                            <th class="text-right">{{ $total_price }}</th>
                            <th colspan="2"></th>
                            <th class="hip" colspan="2"></th>
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
            var _url = "{{ URL::to('sales/search') }}";
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

        $("#Del_btn").click(function () {
            var _url = "{{ URL::to('sales/delete') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {

                $.post(_url, _form.serialize(), function (data) {
                    if (data.success === true) {
                        $('#ajaxMessage').removeClass('alert-danger').addClass('alert-success').show().show();
                        $('#ajaxMessage').html(data.message);
                    } else {
                        $('#ajaxMessage').removeClass('alert-success').addClass('alert-danger').show();
                        $('#ajaxMessage').html(data.message);
                    }
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }, "json");

            }

        })

    });
</script>

@endsection