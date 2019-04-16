@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Empty Bag Stock List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Empty Bag</span></li>
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
                                for ($i = 20; $i <= 150; $i += 10):
                                    echo "<option value='{$i}'>{$i}</option>";
                                endfor;
                                ?>                        
                            </select>
                            <div style="width:18%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by">
                                    <option value="">Voucher Type</option>                 
                                    <option value="Receive">Receive Voucher</option>                                 
                                    <option value="Payment">Unloading Voucher</option>                 
                                </select>
                            </div> 
                            <div style="width:18%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:6%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div style="width:18%;" class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:32%">
                    <a class="btn btn-success btn-xs" href="{{ url('/emptybag-stock/create/d') }}"><i class="fa fa-plus"></i>&nbsp;Receive</a>
                    <a class="btn btn-warning btn-xs" href="{{ url('/emptybag-stock/create/c') }}"><i class="fa fa-minus"></i>&nbsp;Unloading</a>
                    <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
{!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmList','name'=>'frmList']) !!} 
<div id="print_area">
    <?php print_header("Empty Bag Stock Information"); ?>
    <div id="ajax_content">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Date</th>
                        <th>Challan No</th>
                        <th>Voucher Type</th>
                        <th>Supplier</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Type</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-center hip">Actions</th>
                        <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                    </tr>
                    <?php
                    $counter = 0;
                    $type = '';
                    if (isset($_GET['page']) && $_GET['page'] > 1) {
                        $counter = ($_GET['page'] - 1) * $dataset->perPage();
                    }
                    $total_quantity = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    if ($data->type == 'Payment') {
                        $type = 'Unloading';
                    } else {
                        $_frmpar_name = $data->particular_name($data->cr_particular_id);
                        $_frmsub_name = $data->subhead_name($data->cr_subhead_id);
                        $type = 'Receive';
                    }
                    $counter++;

                    $total_quantity += $data->quantity;
                    ?>   
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td>{{ date_dmy( $data->date ) }}</td>
                        <td>{{ $data->challan_no }}</td>
                        <td>{{ $type }}</td>
                        @if($type == 'Receive')
                        <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{ $data->size }}</td>
                        <td>{{ $data->color }}</td>
                        <td>{{ $data->bag_type }}</td>
                        <td class="text-right">{{ $data->quantity }}</td>
                        <td class="text-center hip">
                            @if( $data->is_edible == 1 )
                            <a class="btn btn-info btn-xs" href="emptybag-stock/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                            @endif
                        </td>
                        <td class="text-center hip">
                            @if( $data->is_edible == 1 )
                            <input type="checkbox" name="data[]" value="{{ $data->id }}">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th colspan="8" class="text-right">Total</th>
                        <th class="text-right">{{ $total_quantity }}</th>
                        <th class="hip" colspan="2"></th>
                    </tr>
                </tbody>
            </table>
            <div class="clearfix" style="padding-top:30px;">
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Accountant</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
                </div>
                <div class="col-md-4 form-group mp_30">
                    <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
                </div>
            </div>
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
            var _url = "{{ URL::to('emptybag-stock/search') }}";
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
            var _url = "{{ URL::to('emptybag-stock/delete') }}";
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