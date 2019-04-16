<table class="table table-bordered">
    <tbody>
        <tr class="bg_gray" id="r_checkAll">
            <th class="text-center" style="width:5%;"></th>
            <th class="text-center" style="width:5%;">SL#</th>
            <th>Category</th>
            <th>Product</th>
            <th>Drawer</th>
            <th class="text-right">Quantity</th>
            <th class="text-right">Weight</th>
        </tr>
        <?php $sl = 1; $total_weight = 0; $total_quantity = 0; ?>
        @foreach ($dataset as $data)
        <?php  $total_weight += $data->net_weight; $total_quantity += $data->net_quantity;  ?>
        <tr>
            <td class="text-center" style="width:5%;">
                <div class="checkbox">
                    <label><input type="checkbox" id="Production_ID" class="single_check" name="item[]"  value="{{ $data->id }}"></label>
                </div>
            </td>
            <td class="text-center" style="width:5%;">{{ $sl }}</td>
            <td>{{ $category->find($data->category_id)->name }}</td>
            <td>{{ $product->find($data->product_id)->name }}</td>
            <td>{{ $drawer->find($data->drawer_id)->name }}</td>
            <td class="text-right">{{ $data->net_quantity }}</td>
            <td class="text-right">{{ $data->net_weight }}</td>
            <?php $sl++; ?>
        </tr>                      
        @endforeach
        <tr class="bg-gray" style="background: #f4f4f4;">
            <th colspan="5" class="text-right">Total</th>
            <th class="text-right">{{ $total_quantity }}</th>
            <th class="text-right">{{ $total_weight }}</th>
        </tr>
    </tbody>
</table>