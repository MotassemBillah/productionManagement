@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tr class="bg-info" id="r_checkAll">
            <th class="text-center" style="width:4%;">SL#</th>
            <th style="width:100px">Date</th>
            <th>Company</th>
            <th>Business</th>
            <th>Category</th>
            <th>Product</th>
            <th class="text-center" style="width: 80px;">Quantity</th>
            <th class="text-center" style="width: 80px;">Rate</th>
            <th class="text-right" style="width: 100px;">Amount</th>
        </tr>
        <?php
        $counter = 0;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $counter = ($_GET['page'] - 1) * $dataset->perPage();
        }
        foreach ($dataset as $data):
            $counter++;
            $_qty = round($data->quantity, 2);
            $_rate = round($data->rate, 2);
            $_amount = round($data->amount, 2);
            ?>
            <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                <td class="text-center">{{ change_lang($counter) }}</td>
                <td>{{ change_lang(date_dmy($data->invoice_date)) }}</td>
                <td><?= !empty($data->institute) ? $data->institute->name : ""; ?></td>
                <td><?= !empty($data->business_type) ? $data->business_type->business_type : ""; ?></td>
                <td><?= $data->category->name; ?></td>
                <td><?= $data->product->name; ?></td>
                <td class="text-center"><?= change_lang($_qty); ?></td>
                <td class="text-center"><?= change_lang($_rate); ?></td>
                <td class="text-right"><?= change_lang($_amount); ?></td>
            </tr>
            <?php
            $_sumQty[] = $_qty;
            $_sumAmount[] = $_amount;
        endforeach;
        ?>
        <tr class="bg-info">
            <th class="text-right" colspan="6">Total</th>
            <th class="text-center" style="width: 80px;"><?= change_lang(array_sum($_sumQty)); ?></th>
            <th class="text-center" style=""></th>
            <th class="text-right" style="width: 100px;"><?= change_lang(array_sum($_sumAmount)); ?></th>
        </tr>
    </table>
</div>
<div class="mb_10 text-center hip" id="apaginate">
    {{ $dataset->render() }}
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif