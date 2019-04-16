<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>SR No</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th class="text-right">Quantity</th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                $total_quantity = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $total_quantity += $data->quantity;
                if ($data->process_status == 0) {
                    $process_status = 'Pending';
                    $process_btn = 'warning';
                } else {
                    $process_status = 'Completed';
                    $process_btn = 'success';
                }
                ?>   
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ date_dmy($data->date) }}</td>
                    <td>{{ $data->invoice_no }}</td>
                    <td>{{ $data->production_type }}</td>
                    <td>{{ $data->categoryName($data->category_id) }} </td>
                    <td>{{ $data->productName($data->product_id) }}</td>
                    <td class="text-right">{{ $data->quantity }}</td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="6" class="text-right" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_quantity }}</th>
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