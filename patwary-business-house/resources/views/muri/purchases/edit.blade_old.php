@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Purchase Order</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Purchase</span></li>
        </ul>
    </div>
</div>
{!! Form::open(['method' => 'PUT', 'url' => 'purchases/'.$data->id, 'id'=>'frm_purchase', 'class' => 'form-horizontal']) !!}
{{ csrf_field() }}
<div class="row">
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="{{ date_dmy($data->date) }}" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Invoice No:</label>
            <input type="text" class="col-md-7" id="invoice_no" name="invoice_no" value="{{ $data->invoice_no }}" readonly>
            <small class="text-danger">{{ $errors->first('invoice_no') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Challan No:</label>
            <input type="text" class="col-md-7" id="challan_no" name="challan_no" value="{{ $data->challan_no }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Quantity:</label>
            <input type="number" class="col-md-7" id="quantity" name="total_quantity" min="0" step="any" value="{{ $data->quantity }}" required>
            <small class="text-danger">{{ $errors->first('total_quantity') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Net Weight:</label>
            <input type="number" class="col-md-7" id="net_weight" name="total_net_weight" onkeyup="weight_measure()" value="{{ $data->weight }}" required>
            <small class="text-danger">{{ $errors->first('total_net_weight') }}</small>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">WPQ:</label>
            <input type="number" class="col-md-7" id="wpq" name="wpq" min="0" step="any" value="{{ $data->weight_per_qty }}" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Net Mon:</label>
            <input type="number" class="col-md-7" id="mon" name="mon" min="0" step="any" readonly required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb_5 clearfix">
            <label for="head" class="col-md-5 text-right">Head :</label>
            <select class="col-md-7" id="head" name="head" required>
                <option value="">Select Head</option>
                @foreach( $heads as $head )
                <option value="{{ $head->id }}" @if($head->id == $data->head_id) {{ ' selected' }} @endif>{{ $head->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="subhead" class="col-md-5 text-right">Sub Head :</label>
            <select class="col-md-7" id="subhead" name="subhead">
                @foreach($subheads->where('subhead_id',$data->head_id)->get() as $subhead)
                <option value="{{$subhead->id}}" @if($subhead->id == $data->subhead_id) {{ ' selected' }} @endif>{{$subhead->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<hr style="margin: 5px 0">
<div class="text-center"><strong>Product Information</strong></div>
<hr style="margin: 5px 0 10px">
<div class="table-responsive">
    <table class="table table-bordered" id="check">
        <thead>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Category</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Net Weight</th>
                <th>Net Mon</th>
                <th class="text-right">Per Mon Price</th>
                <th class="text-right">Net Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0; ?>
            @foreach ( $data->items as $product )
            <?php $sl++; ?>
            <tr>
        <input type="hidden" name="hid[]" value="{{ $product->id }}">
        <td class="text-center" style="width:5%;">{{ $sl }}</td>
        <td>{{ $category->find($product->category_id)->name }}<input type="hidden" value="{{ $product->category_id }}" name="category_id[{{ $product->id }}]"></td>
        <td>{{ $products->find($product->product_id)->name }} <input type="hidden" value="{{ $product->product_id }}" name="product_id[{{ $product->id }}]" ></td>
        <td>
            <div style="display:none; padding: 3px; margin-bottom: 5px;" id="alt_{{ $product->id }}" class="alert alert-danger">
                <strong>Quantity Exceed</strong>  
            </div>
            <input type="number" id="qty_{{ $product->id }}" value="{{ $product->quantity }}" name="quantity[{{ $product->id }}]" onkeyup="measure_wpq(this)" class="form-control tqty_check" data-info="{{ $product->id }}">
        </td>
        <td>
            <input type="number" step="any" id="wpq_{{ $product->id }}" value="{{ $product->weight }}" name="net_weight[{{ $product->id }}]" class="form-control">
        </td>
        <td>
            <input type="number" step="any" id="mon_{{ $product->id }}" name="net_mon[{{ $product->id }}]" class="form-control" readonly>
        </td>
        <td>
            <div style="display:none; padding: 3px;margin-bottom: 5px;" id="palt_{{ $product->id  }}" class="alert alert-danger">
                <strong>Check Price</strong>  
            </div>
            <input type="number" step="any" id="per_price_{{ $product->id }}" value="{{ $product->per_bag_price }}" name="per_bag_price[{{ $product->id }}]" onkeyup="measure_bag_price(this)" class="form-control" data-info="{{ $product->id }}">
        </td>
        <td>
            <input type="number" step="any" id="net_price_{{ $product->id }}" value="{{ $product->net_price }}" name="net_price[{{ $product->id }}]" class="form-control" readonly>
        </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnPurchase">Save</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("change", "#head", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subhead");
                    $('#subhead').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });
    });
    function weight_measure() {
        var quantity = document.getElementById("quantity").value;
        var net_weight = document.getElementById("net_weight").value;
        wpq = net_weight / quantity;
        mon = kgToMon(net_weight);
        document.getElementById('wpq').value = wpq.toFixed(2);
        document.getElementById('mon').value = mon;
    }

    function CheckInvoice(invoice) {
        var _url = "{{ URL::to('check-invoice') }}/" + invoice;
        $.ajax({
            url: _url,
            type: "get",
            success: function (data) {
                $('#check_inv').html(data);
            }, error: function (xhr, status) {
                alert('There is some error.Try after some time.');
            }
        });
    }

    function measure_wpq(elm) {
        var id = $(elm).attr('data-info');
        var total_quantity = document.getElementById("quantity").value;
        var wpq = parseFloat(document.getElementById("wpq").value, 10);
        var qun = document.getElementById("qty_" + id).value;
        var sumqty = get_sum("tqty_check");
        if (isNaN(total_quantity)) {
            total_quantity = 0;
        }

        if (sumqty > total_quantity) {
            document.getElementById("alt_" + id).style.display = "block";
        } else {
            document.getElementById("alt_" + id).style.display = "none";
            var mainwpq = (qun * wpq);
            var mainmon = kgToMon(mainwpq);
            document.getElementById("wpq_" + id).value = mainwpq.toFixed(2);
            document.getElementById("mon_" + id).value = mainmon;
        }
    }

    function measure_bag_price(elm) {
        var id = $(elm).attr('data-info');
        var mon = document.getElementById("mon_" + id).value;
        var per_price = document.getElementById("per_price_" + id).value;
        var mulprice = mon * per_price;
        if (isNaN(per_price)) {
            document.getElementById("palt_" + id).style.display = "block";
        } else {
            document.getElementById("palt_" + id).style.display = "none";
            var mulprice = mon * per_price;
            document.getElementById("net_price_" + id).value = mulprice.toFixed(2);
        }
    }


</script>
@endsection