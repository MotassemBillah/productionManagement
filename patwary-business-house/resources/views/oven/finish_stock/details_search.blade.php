<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive" id="print_area">
        {{ print_header("Raw Stocks Details") }}
        <table class="table table-bordered table-striped tbl_thin">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th class="text-right">Previous</th>
                    <th class="text-right">Production</th>
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
                $total_previous += $stock->sumOpeningQuantity($data->id);
                $total_purchase += $stock->sumInQuantity($data->id);
                $total_production += $stock->sumOutQuantity($data->id);
                $total_remain += $stock->sumStockQuantity($data->id);
                ?>                       
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td class="text-right">{{ $stock->sumOpeningQuantity($data->id) }}</td>
                    <td class="text-right">{{ $stock->sumInQuantity($data->id) }}</td>
                    <td class="text-right">{{ $stock->sumOutQuantity($data->id) }}</td>
                    <td class="text-right">{{ $stock->sumStockQuantity($data->id) }}</td>
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