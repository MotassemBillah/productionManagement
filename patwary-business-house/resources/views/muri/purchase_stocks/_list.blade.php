<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped tbl_thin">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th class="text-right">Quantity (Bag)</th>
                    <th class="text-right">Net Weight (Kg)</th>
                    <th class="text-right">Mon</th>
                    <th class="text-right">Sher</th>
                    <th class="text-right">Avg Mon Price</th>
                    <th class="text-right">Total Price</th>
                </tr>
                <?php
                $sl = 1;
                $total_weight = 0;
                $total_mon = 1;
                $total_sher = 0;
                $total_quantity = 0;
                $total_mon_price = 0;
                $total_net_price = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $stock_weight = $stock->sumInWeight($data->id);
                $stock_quantity = $stock->sumInQuantity($data->id);
                $total_weight += $stock_weight;
                $total_quantity += $stock_quantity;
                $total_mon += floor(kgToMon($stock_weight));
                $total_sher += kgToSher($stock_weight);
                $total_price = $stock->sumInNetPrice($data->id);
                if ($stock_weight > 0 || $stock_quantity > 0) :
                    $avg_mon_price = ($total_price / $stock_weight) * 40;
                    $total_mon_price += $avg_mon_price;
                    $total_net_price += $total_price;
                    ?>                       
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $category->find($data->category_id)->name }}</td>
                        <td>{{ $product->find($data->id)->name }}</td>
                        <td class="text-right">{{ $stock_quantity }}</td>
                        <td class="text-right">{{ $stock_weight }}</td>
                        <td class="text-right">{{ floor( kgToMon($stock_weight) ) }}</td>
                        <td class="text-right">{{ kgToSher($stock_weight) }}</td>
                        <td class="text-right">{{ round($avg_mon_price, 2) }}</td>
                        <td class="text-right">{{ $total_price }}</td>
                        <?php $sl++; ?>
                    </tr>
                <?php endif; ?>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="3" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                    <th class="text-right">{{ $total_weight }}</th>
                    <th class="text-right">{{ $total_mon }}</th>
                    <th class="text-right">{{ $total_sher }}</th>
                    <th class="text-right"></th>
                    <th class="text-right">{{ $total_net_price }}</th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>