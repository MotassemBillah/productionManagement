@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('/')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Supplier Transaction List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span> Transaction</span></li>
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
                            <div style="width:15%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by">
                                    <option value="">Select Supplier</option>                  
                                    @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->agent_name }} ({{$supplier->agent_code}})</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div style="width:13%;"  class="col-md-2 col-sm-3 no_pad">
                                <select id="sortType" class="form-control" name="sort_type">
                                    <option value="ASC">Ascending</option>
                                    <option value="DESC">Descending</option>
                                </select>
                            </div>
                            <div style="width:13%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div style="width:13%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <input type="text" style="width:160px;" name="search" id="q" class="form-control" placeholder="invoice no" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:16%">
                    <a href="{{ url ('/supplier-transaction/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show Agent List-->
{!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
<div id="print_area">
    {{ print_header("Supplier Transaction List") }}
    <div id="ajax_content">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Supplier</th>
                        <th>Pay Date</th>
                        <th>Invoice Number</th>
                        <th>Invoice Amount</th>
                        <th>Discount</th>
                        <th>Invoice Paid</th>
                        <th>Invoice Due</th>
                        <th>Previous Due</th>
                        <th>Advance Paid</th>
                        <th>Due Paid</th>
                        <th class="hip">Actions</th>
                        <th class="text-center hip">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all"value="all"></label>
                            </div>
                        </th>
                    </tr>
                    <?php
                    $sl = 1;
                    $total_invoice_amount = 0;
                    $total_dis_amt = 0;
                    $total_inv_paid = 0;
                    $total_inv_due = 0;
                    $total_inv_pdue = 0;
                    $total_inv_add = 0;
                    $total_due_paid = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    $total_invoice_amount += $data->invoice_amount;
                    $total_dis_amt += $data->discount_amount;
                    $total_inv_paid += $data->invoice_paid;
                    $total_inv_due += $data->invoice_due;
                    $total_inv_pdue += $data->previous_due;
                    $total_inv_add += $data->invoice_advance;
                    $total_due_paid += $data->due_paid;
                    ?>
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $suppliers->find($data->supplier_id)->agent_name }}</td>
                        <td>{{ date_dmy($data->pay_date) }}</td>
                        <td>{{ $data->invoice_no }}</td>
                        <td class="text-right">{{ $data->net_amount }}</td>
                        <td class="text-right">{{ $data->discount_amount }}</td>
                        <td class="text-right">{{ $data->invoice_paid }}</td>
                        <td class="text-right">{{ $data->invoice_due }}</td>
                        <td class="text-right">{{ $data->previous_due }}</td>
                        <td class="text-right">{{ $data->invoice_advance }}</td>
                        <td class="text-right">{{ $data->due_paid }}</td>
                        <td class="text-center hip">
                            <?php if ($data->is_edible == 1) : ?>
                                <a class="btn btn-info btn-xs" href="supplier-transaction/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                            <?php endif; ?>
                        </td>

                        <td class="text-center hip">
                            <?php if ($data->is_edible == 1) : ?>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                                </div>
                                <?php
                            endif;
                            $sl++;
                            ?>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right">{{ $total_invoice_amount }}</th>
                        <th class="text-right">{{ $total_dis_amt }}</th>
                        <th class="text-right">{{ $total_inv_paid }}</th>
                        <th class="text-right">{{ $total_inv_due }}</th>
                        <th class="text-right">{{ $total_inv_pdue }}</th>
                        <th class="text-right">{{ $total_inv_add }}</th>
                        <th class="text-right">{{ $total_due_paid }}</th>
                        <th class="hip" colspan="2"></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="text-center">
    {{ $dataset->render() }}
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('supplier-transaction/search') }}";
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
            var _url = "{{ URL::to('supplier-transaction/delete') }}";
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