<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped tbl_thin">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Per Qty Price</th>
                    <th class="text-right">Total Price</th>
                </tr>
                <?php
                $sl = 1;
                $total_quantity = 0;
                $total_avg_price = 0;
                $total_price = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $stock_quantity = $product->sumInQuantity($data->id);
                $stock_price = $product->sumInNetPrice($data->id);
                $total_quantity += $stock_quantity;
                $total_price += $stock_price;
                $avg_qty_price = $product->avgPurchasePrice($data->id);
                $total_avg_price += $avg_qty_price;
                ?>                       
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->categoryName($data->raw_category_id) }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td class="text-right">{{ $stock_quantity }}</td>
                    <td class="text-right">{{ round($avg_qty_price, 2) }}</td>
                    <td class="text-right">{{ $stock_price }}</td>
                    <?php $sl++; ?>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                    <th class="text-right"></th>
                    <th class="text-right">{{ $total_price }}</th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>