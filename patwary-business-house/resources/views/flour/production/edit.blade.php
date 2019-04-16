@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Production Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">></span></li>
            <li>Production</li>
        </ul>                            
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Production Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'flour/production/'.$data->id, 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}                    
            <div class="order-list"> 
                <div id="ajax_content">
                    <div class="table-responsive">
                        <div style="margin:8px 0px;" class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3">Order No:</label>
                                    <div class="col-md-6">
                                        <div id="check_order"></div>
                                        <input type="text" id="alt_inv" class="form-control" name="order_no" value=" {{ $data->order_no }} " readonly>
                                        <small class="text-danger">{{ $errors->first('order_no') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 text-right control-label">Date:</label>
                                    <div class="col-md-6">
                                        <input id="create_date" type="text" placeholder="" value="{{ date_dmy($data->date) }}" class="form-control pickdate" name="date" required readonly>
                                        <small class="text-danger">{{ $errors->first('date') }}</small>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <table class="table table-bordered table-striped" id="check">
                            <tbody>
                                <tr class="bg_gray" id="r_checkAll">
                                    <th class="text-center" style="width:5%;">SL#</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>WPQ(AVG)</th>
                                    <th>Weight</th>
                                    <th class="text-center">Drawer</th>
                                    <th>Process Quantity</th>
                                    <th>Process Weight</th>
                                </tr>
                                <?php
                                $sl = 1;
                                $stock_quantity = 0;
                                $stock_weight = 0;
                                $avg_weight = 0;
                                ?>
                                @foreach ($data->items as $stock)  
                                <?php
                                $stock_weight = $stocks->sumStockWeight($stock->product_id);
                                $stock_quantity = $stocks->sumStockQuantity($stock->product_id);
                                if ($stock_quantity != 0) {
                                    $avg_weight = $stock_weight / $stock_quantity;
                                }
                                ?>                                     
                                <tr>
                                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                                    <td>{{ $stock->categoryName($stock->category_id) }}<input type="hidden" value="{{ $stock->category_id }}" name="category_id[{{ $stock->id }}]" ></td>
                                    <td>{{ $stock->productName($stock->product_id) }} <input type="hidden" value="{{ $stock->product_id }}" name="product_id[{{ $stock->id }}]" ></td>
                                    <td>{{ $stock_quantity }} <input type="hidden"  id="stq_{{ $stock->id }}" name="qty[{{ $stock->id }}]" value="{{ $stock_quantity }}"> </td>
                                    <td class="text-center">{{ round($avg_weight, 2) }} <input type="hidden"  id="stwpq_{{ $stock->id }}" name="wpq[{{ $stock->id }}]" value="{{ $avg_weight }}"> </td>
                                    <td>{{ $stock_weight }} <input type="hidden"  id="stw_{{ $stock->id }}" name="weight[{{ $stock->id }}]" value="{{ $stock_weight }}"> </td>
                                    <td style="width:14%;">
                                        <select name="drawer[{{ $stock->id }}]" class="form-control">
                                            <option value="" >Select Drawer</option>
                                            @foreach($drawers as $drawer)
                                            <option value="{{ $drawer->id }}" @if($stock->drawer_id == $drawer->id) {{ 'selected' }} @endif>{{ $drawer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div style="display:none; padding: 7px;
                                             margin-bottom: 5px;" id="alt_{{ $stock->id  }}" class="alert alert-danger">
                                            <strong>Check Quantity</strong>  
                                        </div>
                                        <input id="pc_{{ $stock->id }}" type="number" value="{{ $stock->net_quantity }}" name="process_quantity[{{ $stock->id }}]" onkeyup="check_quantity(<?= $stock->id ?>)" class="form-control">
                                    </td>
                                    <td>
                                        <input id="pcw_{{ $stock->id }}" type="number" value="{{ $stock->net_weight }}" name="process_weight[{{ $stock->id }}]" class="form-control" readonly>
                                    </td>
                            <input type="hidden" name="hid[]" value="{{ $stock->id }}">
                            <?php $sl++; ?>
                            </tr>                      
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="button" class="btn btn-info">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            {!! Form::close() !!}  
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#reset_form").click(function () {
            $("#frm_production").find("input[type=text] ,textarea").val("");
        });
    });
    function check_quantity(id) {
        var quantity = parseInt(document.getElementById("stq_" + id).value, 10);
        var swpq = parseFloat(document.getElementById("stwpq_" + id).value);
        var process_quantity = parseInt(document.getElementById("pc_" + id).value, 10);
        var weight = 0;
        weight = process_quantity * swpq;
        //console.log(weight);
        document.getElementById("pcw_" + id).value = weight.toFixed(2);
        if (process_quantity > quantity) {
            document.getElementById("alt_" + id).style.display = "block";
        } else {
            document.getElementById("alt_" + id).style.display = "none";
        }
    }
    function check_weight(id) {
        var weight = parseInt(document.getElementById("stw_" + id).value, 10);
        var process_weight = parseInt(document.getElementById("pcw_" + id).value, 10);
        var process_quantity = parseInt(document.getElementById("pc_" + id).value, 10);
        var wpq = null;
        if (process_weight > weight) {
            document.getElementById("altw_" + id).style.display = "block";
        } else {
            document.getElementById("altw_" + id).style.display = "none";
        }
        wpq = process_weight / process_quantity;
        document.getElementById("wpq_" + id).value = wpq.toFixed(2);
    }
</script>

@endsection
