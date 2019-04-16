<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <table class="table table-bordered" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Challan No</th>
                <th>D/O No</th>
                <th>Category</th>
                <th>Product</th>
                <th class="text-right">Bag Quantity</th>
                <th class="text-right">Scale Weight</th>
            </tr>
            <?php
            $counter = 0;
            if (isset($_GET['page']) && $_GET['page'] > 1) {
                $counter = ($_GET['page'] - 1) * $dataset->perPage();
            }
            $total_quantity = [];
            $total_weight = [];
            ?>
            @foreach ($dataset as $data)
            <?php
            $counter++;
            $total_quantity[] = $data->bag_quantity;
            $total_weight[] = $data->net_weight;
            ?>   
            <tr>
                <td class="text-center" style="width:5%;">{{ $counter }}</td>
                <td>{{ date_dmy($data->date) }}</td>
                <td>{{ !empty($data->supplier_subhead) ? $data->particular_name($data->supplier_subhead) : '' }}</td>
                <td>{{ $data->challan_no }}</td>
                <td>{{ $data->voucher_no }}</td>
                <td>{{ $data->categoryName($data->category_id) }}</td>
                <td>{{ $data->productName($data->product_id) }}</td>
                <td class="text-right">{{ $data->bag_quantity }}</td>
                <td class="text-right">{{ $data->net_weight }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="7" class="text-right">Total</th>
                <th class="text-right">{{ array_sum($total_quantity) }}</th>
                <th class="text-right">{{ array_sum($total_weight) }}</th>
            </tr>
        </tbody>
    </table>
    <div class="text-center hip" id="apaginate">
        {{ $dataset->render() }}
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>