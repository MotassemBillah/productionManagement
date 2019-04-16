@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Production Stocks</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Update Order</span></li>
        </ul>                            
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Production Stocks Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'production-stocks/'.$data->id, 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}                    
            <div class="order-list"> 
                <div id="ajax_content">
                    <div class="table-responsive">
                        <div style="margin:8px 0px;" class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3">PS No:</label>
                                    <div class="col-md-6">
                                        <div id="check_order"></div>
                                        <input type="text" id="alt_inv" class="form-control" value=" {{ $data->production_stocks_no }} " readonly>
                                        <small class="text-danger">{{ $errors->first('production_stocks_no') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 text-right">Date:</label>
                                    <div class="col-md-6">
                                        <input id="create_date" type="text" placeholder="" value="{{ date_dmy($data->date) }}" class="form-control pickdate" name="date" required readonly>
                                        <small class="text-danger">{{ $errors->first('date') }}</small>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 text-right form-group">Drawer:</label>
                                    <div class="col-md-6">
                                        <span>{{ $drawer_info }}</span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <table class="table table-bordered table-striped" id="check">
                            <tbody>
                                <tr class="bg_gray" id="r_checkAll">
                                    <th>Product</th>
                                    <th>Bag Weight (Kg)</th>
                                    <th>Quantity</th>
                                    <th>Weight</th>
                                </tr>
                                <?php
                                $quantity = 0;
                                $weight = 0;
                                ?>
                                @foreach ($data->items as $item)                                     
                                <tr>
                                    <td>{{ !empty($item->after_production_id) ? $item->productName($item->after_production_id) : '' }} <input type="hidden" value="{{ $item->after_production_id }}" name="after_production_id[{{ $item->id }}]" ></td>
                                    <td>{{ !empty($item->after_production_id) ? $item->productWeight($item->after_production_id) : '' }} <input type="hidden" id="bag_weight_{{ $item->id }}"></td>
                                    <td><input class="form-control qty" type="number" name="quantity[{{ $item->id }}]" value="{{ $item->quantity }}" id="quantity_{{ $item->id }}" data-weight ="{{ $item->productWeight($item->after_production_id) }}" data-info="{{ $item->id }}"> </td>
                                    <td><input class="form-control" type="number" name="net_weight[{{ $item->id }}]" value="{{ $item->weight }}" id="net_weight_{{ $item->id }}" readonly> </td>
                                    <input type="hidden" name="hid[]" value="{{ $item->id }}">
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

    $(document).on("input", ".qty", function (e) {
        var id = $(this).attr('data-info');
        var qun = this.value;
        var total_weight = 0;
        var bag_weight = $(this).attr('data-weight');
        if (isNaN(bag_weight) || bag_weight == '') {
            bag_weight = 1;
        }
        total_weight = qun * bag_weight;
        document.getElementById("net_weight_" + id).value = total_weight;
        e.preventDefault();
    });

</script>

@endsection
