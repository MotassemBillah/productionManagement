<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive" id="print_area">
        {{ print_header("Production Stocks Information") }}
        <table class="table table-bordered table-striped tbl_thin">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th class="text-right">Net Weight (Kg)</th>
                    <th class="text-right">Quantity (Bag)</th>
                </tr>
                <?php
                $sl = 1;
                $total_weight = 0;
                $total_quantity = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $stock_weight = $stock->sumStockWeight($data->id);
                $stock_quantity = $stock->sumStockQuantity($data->id);
                $total_weight += $stock_weight;
                $total_quantity += $stock_quantity;
                ?>
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $category->find($data->category_id)->name }}</td>
                    <td>{{ $product->find($data->id)->name }}</td>
                    <td class="text-right">{{ $stock_weight }}</td>
                    <td class="text-right">{{ $stock_quantity }}</td>
                    <?php $sl++; ?>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="3" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_weight }}</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>