@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-2 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('clear_view_cache')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-4 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv/sale-return') }}">Sale Return</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
{!! Form::open(['method' => 'POST', 'url' => 'inv/sale-return', 'id' => 'frmCart', 'name' => 'frmCart']) !!} 
@if(!empty($dataset) && count($dataset) > 0)
<div class="row clearfix">
    <div class="col-md-2 col-sm-3">
        <div class="mb_10 clearfix">
            <label for="invoice_date">Date <span class="required">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control pickdate" id="invoice_date" name="invoice_date" value="<?= date('d-m-Y'); ?>" placeholder="(dd-mm-yyyy)" readonly required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
        <div class="mb_10 clearfix">
            <label for="invoice_number">Invoice Number <span class="required">*</span></label>
            <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{$invoice_no}}" placeholder="invoice number" required>
        </div>
        <div class="mb_10 clearfix">
            <label for="challan_number">Challan Number</label>
            <input type="text" class="form-control" id="challan_number" name="challan_number" value="" placeholder="challan number">
        </div>
        <div class="mb_10 clearfix">
            <label for="transport_cost">Transport Cost</label>
            <input type="number" class="form-control oamount" id="transport_cost" name="transport_cost" value="" min="0" step="any" placeholder="transport cost">
        </div>
        <div class=" clearfix">
            <label for="labor_cost">Labor Cost</label>
            <input type="number" class="form-control oamount" id="labor_cost" name="labor_cost" value="" min="0" step="any" placeholder="labor cost">
        </div>
        <div class=" clearfix">
            <label for="other_cost">Other Cost</label>
            <input type="number" class="form-control oamount" id="other_cost" name="other_cost" value="" min="0" step="any" placeholder="other cost">
        </div>
    </div>

    <div class="col-md-10 col-sm-9">
        <div class="clearfix">
            <div class="col-md-2 no_pad">
                <div class="mb_10">
                    <label for="from_subhead">From Subhead <span class="required">*</span></label>
                    <input type="text" class="inp_filter" id="" placeholder="filter subhead" onkeyup="filter_list(this.value, 'from_subhead')">
                    <select class="form-control" id="from_subhead" name="from_subhead" required>
                        <option value="">Select</option>
                        @foreach($from_subhead_list as $fshlist)
                        <option value="{{ $fshlist->id }}">{{ $fshlist->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 no_pad">
                <div class="mb_10">
                    <label for="from_particular">From Particular <span class="required">*</span></label>
                    <input type="text" class="inp_filter" id="" placeholder="filter particular" onkeyup="filter_list(this.value, 'from_particular')">
                    <select class="form-control" id="from_particular" name="from_particular" required>
                        <option value="">Select</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 no_pad">
                <div class="mb_10">
                    <label for="note">Note</label>
                    <textarea class="form-control" id="note" name="note" style="min-height: 56px;"></textarea>
                </div>
            </div>

            <div class="col-md-2 no_pad">
                <div class="mb_10">
                    <label for="to_subhead">To Subhead <span class="required">*</span></label>
                    <input type="text" class="inp_filter" id="" placeholder="filter subhead" onkeyup="filter_list(this.value, 'to_subhead')">
                    <select class="form-control" id="to_subhead" name="to_subhead" required>
                        <option value="">Select</option>
                        @foreach($to_subhead_list as $tshlist)
                        <option value="{{ $tshlist->id }}">{{ $tshlist->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 no_pad">
                <div class="mb_10">
                    <label for="to_particular">To Particular</label>
                    <input type="text" class="inp_filter" id="" placeholder="filter particular" onkeyup="filter_list(this.value, 'to_particular')">
                    <select class="form-control" id="to_particular" name="to_particular">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tr class="bg-info" id="r_checkAll">
                    <th class="text-center" style="width:3%;">SL#</th>
                    <th style="">Company</th>
                    <th style="">Business</th>
                    <th style="">Product</th>
                    <th class="text-center">Unit</th>
                    <th>Size</th>
                    <th class="text-center">Weight</th>
                    <th class="text-center" style="width:70px;">Qty <span class="required">*</span></th>
                    <th class="text-center" style="width:70px;">Rate <span class="required">*</span></th>
                    <th class="text-right" style="width:90px;">Amount</th>
                    <th class="text-center" style="width:3%;">#</th>
                </tr>
                <?php
                $counter = 0;
                foreach ($dataset as $data):
                    $counter++;
                    $_subtotal = ($data->quantity * $data->rate);
                    ?>
                    <tr id="row_{{ $data->id }}">
                        <td class="text-center">
                            {{ $counter }}
                            <input type="hidden" name="key[]" value="{{ $data->id }}">
                            <input type="hidden" name="inst_id[{{$data->id}}]" value="{{ $data->institute_id }}">
                            <input type="hidden" name="btype_id[{{$data->id}}]" value="{{ $data->business_type_id }}">
                            <input type="hidden" name="category_id[{{$data->id}}]" value="{{ $data->category_id }}">
                            <input type="hidden" name="product_id[{{$data->id}}]" value="{{ $data->product_id }}">
                        </td>
                        <td>{{ !empty($data->institute) ? $data->institute->name : "" }}</td>
                        <td>{{ !empty($data->business_type) ? $data->business_type->business_type : "" }}</td>
                        <td>{{ !empty($data->product) ? $data->product->name : "" }}</td>
                        <td class="text-center">{{ !empty($data->product) ? $data->product->unit : "" }}</td>
                        <td>{{ !empty($data->product) ? $data->product->size : "" }}</td>
                        <td class="text-center">{{ !empty($data->product) ? $data->product->weight : "" }}</td>
                        <td class="text-center">
                            <input type="number" class="wfull bdr_black text-center qty_rate qty" id="qty_{{$data->id}}" name="quantity[{{$data->id}}]" value="{{$data->quantity}}" min="0" step="any" data-info="{{$data->id}}"> 
                        </td>
                        <td class="text-center">
                            <input type="number" class="wfull bdr_black text-center qty_rate" id="rate_{{$data->id}}" name="rate[{{$data->id}}]" value="{{$data->rate}}" min="0" step="any" data-info="{{$data->id}}">                             
                        </td>
                        <td class="text-right">
                            <input type="number" class="wfull bdr_black text-right subtotal" id="subtotal_{{$data->id}}" name="subtotal[{{$data->id}}]" value="{{$data->amount}}" min="0" step="any" readonly>                             
                        </td>
                        <td class="text-center">
                            <a class="remove_item" href="javascript:void(0)" data-info="{{$data->id}}" title="Remove This Item From Cart"><i class="fa fa-trash-o color_danger"></i></a>
                        </td>
                    </tr>
                    <?php
                    $_total[] = $_subtotal;
                endforeach;
                ?>
                <tr class="bg-info">
                    <th class="text-right" colspan="7">Sub Total</th>
                    <th class=""><input type="number" id="tqty" class="wfull bdr_black text-center" name="tqty"  min="0" step="any" value="" readonly></th>
                    <th></th>
                    <th class=""><input type="number" id="total" class="wfull bdr_black text-right sumt" name="total"  min="0" step="any" value="<?= array_sum($_total); ?>" readonly></th>
                    <th></th>
                </tr>
                <tr class="bg-info">
                    <th class="text-right" colspan="9">Transport, Labor, Other Amount = </th>
                    <th class=""><input type="number" id="other_amount" class="wfull bdr_black text-right sumt" name="other_amount"  min="0" step="any" value="" readonly></th>
                    <th></th>
                </tr>
                <tr class="bg-info">
                    <th class="text-right" colspan="9">Total Amount = </th>
                    <th class=""><input type="number" id="sum_amount" class="wfull bdr_black text-right" name="sum_amount"  min="0" step="any" value="" readonly></th>
                    <th></th>
                </tr>
            </table>
        </div>

        <div class="form-group">
            <div class="text-center clearfix">
                <a class="btn btn-info xsw_33" href="{{url('inv/sale-return/create')}}">Add More Product</a>
                <a class="btn btn-warning xsw_33" href="{{url('inv/sale-return/clear_cart')}}">Clear Cart</a>
                <input type="submit" class="btn btn-primary xsw_33" id="process_order" name="process_order" value="Process Order">
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        update_tqty();
        update_other_amount();
        update_sum_amount();

        $(document).on("input", ".qty_rate", function () {
            $("#ajaxMessage").slideUp('fast');
            $(this).removeClass('bdr_err');
            var _id = $(this).attr('data-info');
            var _qty = $("#qty_" + _id).val();
            var _rate = $("#rate_" + _id).val();
            var _amount = 0;
            if (isNaN(_qty)) {
                _qty = 0;
            }
            if (isNaN(_rate)) {
                _rate = 0;
            }

            _amount += (_qty * _rate);
            //console.log(parseFloat(_amount).toFixed(2));
            $("#subtotal_" + _id).val(parseFloat(_amount).toFixed(2));
            var _st = sumVal('subtotal');
            $("#total").val(parseFloat(_st).toFixed(2));
            update_tqty();
            update_other_amount();
            update_sum_amount();
        });

        $(document).on("input", ".oamount", function () {
            update_other_amount();
            update_sum_amount();
        });

        $(document).on("change", "#from_subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#from_particular");
                    $("#from_particular").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#to_subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('particulars/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#to_particular");
                    $("#to_particular").html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", ".remove_item", function () {
            var _id = $(this).attr('data-info');
            var _url = "{{ URL::to('inv/sale-return/delete_cart_item') }}";

            var _formdata = {};
            _formdata._token = '{{ csrf_token() }}';
            _formdata.itemid = _id;

            var _rc = confirm("Are you sure about this action? This cannot be undone!");
            if (_rc == true) {
                $.post(_url, _formdata, function (resp) {
                    if (resp.success === true) {
                        $("#ajaxMessage").showAjaxMessage({html: resp.message, type: "success"});
                        $("#row_" + _id).remove();
                    } else {
                        $("#ajaxMessage").showAjaxMessage({html: resp.message, type: "error"});
                    }
                }, "json");
            }
        });
    });

    function update_tqty() {
        var _qty = sumVal('qty');
        $("#tqty").val(_qty);
    }

    function update_other_amount() {
        var _val = sumVal('oamount');
        $("#other_amount").val(_val);
    }

    function update_sum_amount() {
        var _val = sumVal('sumt');
        $("#sum_amount").val(_val);
    }
</script>
@endsection