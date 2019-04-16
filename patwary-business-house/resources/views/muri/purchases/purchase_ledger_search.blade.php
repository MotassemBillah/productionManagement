<?php if (!empty($dataset) && count($dataset) > 0) : ?>
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Date</th>
                <th>Invoice No</th>
                <th>Supplier</th>
                <th>Product</th>
                <th class="text-right">Weight</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Price</th>
            </tr>
            <?php
            $counter = 0;
            if (isset($_GET['page']) && $_GET['page'] > 1) {
                $counter = ($_GET['page'] - 1) * $dataset->perPage();
            }
            $total_weight = 0;
            $total_quantity = 0;
            $total_price = 0;
            ?>
            @foreach ($dataset as $data)
            <?php
            $counter++;
            $total_weight += $data->weight;
            $total_quantity += $data->quantity;
            $total_price += $data->net_price;
            ?>   
            <tr>
                <td class="text-center" style="width:5%;">{{ $counter }}</td>
                <td>{{ date_dmy($data->date) }}</td>
                <td>{{ $data->weights->invoice_no }}</td>
                <td>{{ !empty($data->head_id) ? $subhead->find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . $particular->find($data->subhead_id)->name : '' }}</td>
                <td>{{ $data->product_name($data->product_id) }}</td>
                <td class="text-right">{{ $data->weight }}</td>
                <td class="text-right">{{ $data->quantity }}</td>
                <td class="text-right">{{ $data->net_price }}</td>
            </tr>
            @endforeach
            <tr class="bg_gray">
                <th colspan="5" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                <th class="text-right">{{ $total_weight }}</th>
                <th class="text-right">{{ $total_quantity }}</th>
                <th class="text-right">{{ $total_price }}</th>
            </tr>
        </tbody>
    </table>
    <div class="text-center hip" id="apaginate">
        {{ $dataset->render() }}
    </div>
</div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>