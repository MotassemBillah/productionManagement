<?php
print_header($printHeader, true, true);
//pr($dataset, false);
?>

<div class="text-center mb_10 clearfix">
    <strong>Date : </strong> <u>{{ date_dmy($fromDate) }} <strong>-TO-</strong> {{ date_dmy($toDate) }}</u>
</div>

@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tr class="bg-info" id="r_checkAll">
            <th class="text-center" style="width:5%;">SL#</th>
            <th style="width:15%">Date</th>
            <th class="text-center" style="width:20%">Previous</th>
            <th class="text-center" style="width:20%">Purchase</th>
            <th class="text-center" style="width:20%">Sale</th>
            <th class="text-center" style="width:20%">Stock</th>
        </tr>
        <?php
        $counter = 0;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $counter = ($_GET['page'] - 1) * $dataset->perPage();
        }
        foreach ($dataset as $_key => $data):
            $counter++;
            //$_pqty = $data->sum_qty_by_date_product_particular(STOCK_PURCHASE, $data->invoice_date, $data->product_id, $data->particular_id);
            //$_sqty = $data->sum_qty_by_date_product_particular(STOCK_SALE, $data->invoice_date, $data->product_id, $data->particular_id);
            $_previous = 0;
            $_pqty = 0;
            $_sqty = 0;
            if ($data->stock_type == STOCK_PURCHASE) {
                $_pqty += $data->quantity;
            }
            if ($data->stock_type == STOCK_SALE) {
                $_sqty += $data->quantity;
            }
            //$_previous = $data->available_prev_qty($data->product_id, $data->invoice_date);            
            //$_stock = ($_pqty - $_sqty);

            if ($_key == 0) {
                $_previous = 0;
                $_stock = ($_previous + $_pqty) - $_sqty;
            } else {
                $_previous = $_stock;
                $_stock = ($_previous + $_pqty) - $_sqty;
            }
            ?>
            <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                <td class="text-center">{{ $counter }}</td>
                <td>{{ date_dmy($data->invoice_date) }}</td>
                <td class="text-center">{{ $_previous }}</td>
                <td class="text-center">{{ $_pqty }}</td>
                <td class="text-center">{{ $_sqty }}</td>
                <td class="text-center">{{ $_stock }}</td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif