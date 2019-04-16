<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <?php print_header("Product ( $product  )", true, true); ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th class="text-right">Previous (Bag)</th>
                    <th class="text-right">Production (Bag)</th>
                    <th class="text-right">Sales (Bag)</th>
                    <th class="text-right">Remain (Bag)</th>
                </tr>
                <?php
                $counter = 0;
                $total_production = [];
                $total_sale = [];

                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $production = 0;
                $sales = 0;
                $remain = 0;

                if ($data->type == 'in' && !empty($data->quantity)) {
                    $production = $data->quantity;
                }

                if ($data->type == 'out' && !empty($data->sales_challan_id)) {
                    $sales = $data->quantity;
                }

                $remain = ($previous + $production) - $sales;
                $total_production[] = $production;
                $total_sale[] = $sales;
                ?>   
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ date_dmy($data->date) }}</td>
                    <td class="text-right">{{ $previous }}</td>
                    <td class="text-right">{{ $production }}</td>
                    <td class="text-right">{{ $sales }}</td>
                    <td class="text-right">{{ $remain }}</td>
                </tr>
                <?php
                $previous = $remain;
                ?>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="3" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ array_sum($total_production) }}</th>
                    <th class="text-right">{{ array_sum($total_sale) }}</th>
                    <th class="hip"></th>
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