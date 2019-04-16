<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive" id="print_area">
        {{ print_header("Finish Stocks Details") }}
        <table class="table table-bordered table-striped tbl_thin">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th class="text-right">Previous</th>
                    <th class="text-right">Finish Production</th>
                    <th class="text-right">Sales</th>
                    <th class="text-right">Remain</th>
                </tr>
                <?php
                $sl = 1;
                $total_previous = 0;
                $total_purchase = 0;
                $total_production = 0;
                $total_remain = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $total_previous += $product->sumOpeningQuantity($data->id);
                $total_purchase += $product->sumInQuantity($data->id);
                $total_production += $product->sumOutQuantity($data->id);
                $total_remain += $product->sumStockQuantity($data->id);
                ?>                       
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->categoryName($data->finish_category_id) }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td class="text-right">{{ $product->sumOpeningQuantity($data->id) }}</td>
                    <td class="text-right">{{ $product->sumInQuantity($data->id) }}</td>
                    <td class="text-right">{{ $product->sumOutQuantity($data->id) }}</td>
                    <td class="text-right">{{ $product->sumStockQuantity($data->id) }}</td>
                    <?php $sl++; ?>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_previous }}</th>
                    <th class="text-right">{{ $total_purchase }}</th>
                    <th class="text-right">{{ $total_production }}</th>
                    <th class="text-right">{{ $total_remain }}</th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>