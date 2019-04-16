@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Transaction List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Transactions</span></li>
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
                            <select id="itemCount" class="form-control" name="item_count" style="width:6%;">
                                <?php
                                for ($i = 10; $i <= 100; $i += 10):
                                    echo "<option value='{$i}'>{$i}</option>";
                                endfor;
                                ?>                        
                            </select>
                            <div style="width:16%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by">
                                    <option value="">Voucher Type</option>                 
                                    <option value="Payment Voucher">Payment Voucher</option>                 
                                    <option value="Receive Voucher">Receive Voucher</option>                 
                                    <option value="Purchase Voucher">Purchase Voucher</option>                 
                                    <option value="Sales Voucher">Sales Voucher</option>                 
                                </select>
                            </div> 
                            <div style="width:13%;"  class="col-md-2 col-sm-3 no_pad">
                                <select id="search_head" class="form-control" name="search_head">
                                    <option value="">All Head</option>   
                                    @foreach ( $subhead->all() as $h )
                                    <option value="{{ $h->id  }}">{{ $h->name }}</option> 
                                    @endforeach()
                                </select>
                            </div>
                            <div style="width:14%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:6%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div style="width:13%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <input type="text" style="width:130px;" name="search" id="q" class="form-control" placeholder="search particular" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:25%">
                    <a class="btn btn-success btn-xs" href="{{ url('/transactions/create/d') }}"><i class="fa fa-plus"></i>&nbsp;Receive</a>
                    <a class="btn btn-warning btn-xs" href="{{ url('/transactions/create/c') }}"><i class="fa fa-minus"></i>&nbsp;Payment</a>
                    <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
{!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmList','name'=>'frmList']) !!} 
<div id="print_area">
    <?php print_header("Transactions Information"); ?>
    <div id="ajax_content">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Date</th>
                        <th>Voucher Type</th>
                        <th>From Account</th>
                        <th>To Account</th>
                        <th>Description</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center hip">Actions</th>
                        <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                    </tr>
                    <?php
                    $counter = 0;
                    if (isset($_GET['page']) && $_GET['page'] > 1) {
                        $counter = ($_GET['page'] - 1) * $dataset->perPage();
                    }
                    $total_amount = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    $counter++;
                    $total_amount += $data->amount;
                    $_frmpar_name = $data->particular_name($data->cr_particular_id);
                    $_topar_name = $data->particular_name($data->dr_particular_id);
                    $_frmsub_name = $data->subhead_name($data->cr_subhead_id);
                    $_tosub_name = $data->subhead_name($data->dr_subhead_id);
                    ?>   
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td>{{ date_dmy( $data->pay_date ) }}</td>
                        <td>{{ $data->voucher_type }}</td>
                        <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
                        <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
                        <td>{{ $data->description }}</td>
                        <td class="text-right">{{ $data->amount }}</td>
                        <td class="text-center hip">
                            @if( $data->is_edible == 1 )
                            <a class="btn btn-info btn-xs" href="transactions/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                            @endif
                            <a class="btn btn-success btn-xs" href="transactions/{{ $data->id }}"><i class="fa fa-dashboard"></i> View</a>
                        </td>
                        <td class="text-center hip">
                            @if( $data->is_edible == 1 )
                            <input type="checkbox" name="data[]" value="{{ $data->id }}">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th colspan="6" class="text-right">Total</th>
                        <th class="text-right">{{ $total_amount }}</th>
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

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('transactions/search') }}";
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
            var _url = "{{ URL::to('transactions/delete') }}";
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