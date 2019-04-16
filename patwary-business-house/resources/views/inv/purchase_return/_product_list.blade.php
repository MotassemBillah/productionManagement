@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-borderd table-hover tbl_thin">
        <tr>
            <th style="width: 300px;">Product Name</th>
            <th class="text-center">Unit</th>
            <th>Size</th>
            <th class="text-center">Weight</th>
            <th class="text-center" style="width: 100px;">Quantity</th>
            <th class="text-center" style="width: 100px;">Rate</th>
            <th class="text-right" style="width: 130px;">Amount</th>
            <th class="text-center">Action</th>
        </tr>
        @foreach ($dataset as $data)
        <tr id="row_{{$data->id}}">
            <td>{{$data->name}}</td>
            <td class="text-center">{{$data->unit}}</td>
            <td>{{$data->size}}</td>
            <td class="text-center">{{$data->weight}}</td>
            <td class="text-center">
                <input type="number" class="wfull bdr_black text-center qty_rate" id="qty_{{$data->id}}" name="quantity[{{$data->id}}]" min="0" step="any" data-info="{{$data->id}}"> 
            </td>
            <td class="text-center">
                <input type="number" class="wfull bdr_black text-center qty_rate" id="rate_{{$data->id}}" name="rate[{{$data->id}}]" min="0" step="any" data-info="{{$data->id}}">                             
            </td>
            <td class="text-right">
                <input type="number" class="wfull bdr_black text-right subtotal" id="subtotal_{{$data->id}}" name="subtotal[{{$data->id}}]" min="0" step="any" readonly>                             
            </td>
            <td class="text-center">
                <a href="javascript:void(0)" class="btn btn-info btn-xs add_to_cart" data-pid="{{$data->id}}">Add To Cart</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif