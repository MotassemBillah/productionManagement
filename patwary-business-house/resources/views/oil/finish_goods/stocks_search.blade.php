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
                $total_quantity += $stock_quantity;
                ?>                       
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->categoryName($data->finish_category_id) }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td class="text-right">{{ $stock_quantity }}</td>
                    <?php $sl++; ?>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>