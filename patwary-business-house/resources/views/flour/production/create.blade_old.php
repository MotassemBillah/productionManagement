@extends('admin.layouts.column2')
<?php
use App\Models\Flour\Production;
?>
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Create New Production Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">></span></li>
            <li>Stock</li>
        </ul>                            
    </div>
</div>
{!! Form::open(['method' => 'POST', 'url' => '', 'class' => 'search-form', 'id'=>'frm_production','name'=>'frm_production']) !!} 
{{ csrf_field() }}
<div class="order-list"> 
    <div style="display:none;" id="ajaxmsg"></div>
    <div id="ajax_content">
        <div class="table-responsive">
            <div style="margin:8px 0px;" class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-3">Order No:</label>
                        <div class="col-md-6">
                            <div id="check_order"></div>
                            <input type="text" id="alt_inv" class="form-control" onfocusout="CheckOrder(this.value);" name="order_no" value="<?php echo Production::get_production_invoice(); ?>" readonly>
                            <small class="text-danger">{{ $errors->first('order_no') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-3 text-right control-label">Date:</label>
                        <div class="col-md-6">
                            <input id="create_date" type="text" placeholder="" value="<?php echo date('d-m-Y'); ?>" class="form-control pickdate" name="date" required readonly>
                            <small class="text-danger">{{ $errors->first('date') }}</small>
                        </div>
                    </div>
                </div> 
            </div>
            <table class="table table-bordered" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all" value="all" name="check"></label>
                            </div>
                        </th>
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">WPQ(AVG)</th>         
                        <th class="text-center">Weight</th>
                        <th style="width:15%">Drawer</th>
                        <th class="text-center" style="width:10%">Quantity</th>
                        <th class="text-center" style="width:10%">Weight</th>
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach ($products as $data)
                    <?php
                    $stock_weight = $stock->sumStockWeight($data->id);
                    $stock_quantity = $stock->sumStockQuantity($data->id);
                    if ($stock_quantity != 0) {
                        $avg_weight = $stock_weight / $stock_quantity;
                    }
                    ?>
                    @if( $stock_quantity > 0 || $stock_weight > 0 )
                    <tr>
                        <td class="text-center" style="width:5%;">
                            <div class="checkbox">
                                <label><input type="checkbox" class="single_check" id="product_{{ $data->id }}" name="product[]"  value="{{ $data->id }}"></label>
                            </div>
                        </td>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $data->category->name }}<input type="hidden" value="{{ $data->category_id }}" name="category_id[{{ $data->id }}]" ></td>
                        <td>{{ $data->name }} <input type="hidden" value="{{ $data->id }}" name="product_id[{{ $data->id }}]" ></td>
                        <td class="text-center">{{ $stock_quantity }} <input type="hidden"  id="stq_{{ $data->id }}" name="qty[{{ $data->id }}]" value="{{ $stock_quantity }}"> </td>
                        <td class="text-center">{{ round($avg_weight, 2) }} <input type="hidden"  id="stwpq_{{ $data->id }}" name="wpq[{{ $data->id }}]" value="{{ $avg_weight }}"> </td>
                        <td class="text-center">{{ $stock_weight }} <input type="hidden"  id="stw_{{ $data->id }}" name="weight[{{ $data->id }}]" value="{{ $stock_weight }}"> </td>
                        <td colspan="4" id="tb_{{ $data->id }}" style="padding: 0">
                            <table class="table table-bordered tbl_thin" style="margin:0;">
                                @foreach($drawers as $drawer)
                                <tr id="row_{{ $data->id }}{{ $drawer->id }}" class="row_drawer">
                                    <td style="width:15%"><input type="checkbox" class="drawer dwr_{{ $drawer->id }}" name="drawer[{{ $data->id }}][]" value="{{ $drawer->id }}" data-info="{{ $data->id }}"> {{ $drawer->name }}</td>
                                    <td style="padding: 0; width:10%">
                                        <div style="display:none; padding:7px;margin-bottom:5px;" id="alt_{{ $data->id  }}{{ $drawer->id }}" class="alert alert-danger">
                                            <strong>Check Quantity</strong>  
                                        </div>
                                        <input id="pc_{{ $data->id }}{{ $drawer->id }}" type="number" step="any" name="quantity[{{ $data->id }}][{{ $drawer->id }}]" onkeyup="check_quantity(<?= $data->id ?>,<?= $drawer->id ?>)" class="form-control qty_{{ $data->id }} dwr_{{ $drawer->id }}">
                                    </td>
                                    <td style="padding: 0; width:10%">
                                        <input id="pcw_{{ $data->id }}{{ $drawer->id }}" type="number" step="any" name="weight[{{ $data->id }}][{{ $drawer->id }}]" class="form-control  weight_{{ $data->id }} dwr_{{ $drawer->id }}">
                                    </td>          
                                </tr>
                                @endforeach
                            </table>
                        </td>                       
<?php $sl++; ?>
                    </tr> 
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <div class="text-center">
                <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>  Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}  
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("submit", "#frm_production", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('flour/production') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo('<?= url('flour/production') ?>')
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");
            e.preventDefault();
            return false;
        });
        $(document).on("change", ".drawer", function (e) {
            var proId = $(this).attr('data-info');
            var dwrId = $(this).val();
            var rowId = proId + dwrId;
            if ($(this).is(":checked")) {
                $(".dwr_" + dwrId).not(this).not("#row_" + rowId + " input[type='number']").attr('disabled', 'disabled');
                $("#product_" + proId).prop("checked", true);
            } else {
                if ($("#tb_" + proId + " input[type='checkbox']:checked").length < 1) {
                    $("#product_" + proId).prop("checked", false);
                }
                $(".dwr_" + dwrId + ", #row_" + rowId + " input[type='number']").removeAttr('disabled');
            }
        });
        $("#reset_form").click(function () {
            $("#frm_production").find("input[type=text] ,textarea, select").val("");
        });
    });
    function check_quantity(id, did) {
        var quantity = parseInt(document.getElementById("stq_" + id).value, 10);
        var swpq = parseFloat(document.getElementById("stwpq_" + id).value);
        var process_quantity = parseInt(document.getElementById("pc_" + id + did).value, 10);
        //console.log(swpq);
        var weight = 0;
        weight = process_quantity * swpq;
        //console.log(weight);
        document.getElementById("pcw_" + id + did).value = weight.toFixed(2);
        var sumqty = get_sum("qty_" + id);
        if (sumqty > quantity) {
            document.getElementById("alt_" + id + did).style.display = "block";
        } else {
            document.getElementById("alt_" + id + did).style.display = "none";
        }
    }

    function check_weight(id, did) {
        var weight = parseInt(document.getElementById("stw_" + id).value, 10);
        var process_weight = parseInt(document.getElementById("pcw_" + id + did).value, 10);
        var process_quantity = parseInt(document.getElementById("pc_" + id + did).value, 10);
        var sumweight = get_sum("weight_" + id);
        var wpq = null;
        if (sumweight > weight) {
            document.getElementById("altw_" + id + did).style.display = "block";
        } else {
            document.getElementById("altw_" + id + did).style.display = "none";
        }
        wpq = process_weight / process_quantity;
        document.getElementById("wpq_" + id + did).value = wpq.toFixed(2);
    }
</script>
@endsection