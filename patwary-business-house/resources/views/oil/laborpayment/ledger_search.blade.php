<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div id="print_area">
        <?php print_header("Labor Payment Information"); ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Date</th>
                        <th>Labor Type</th>
                        <th>Shift</th>
                        <th>Name</th>
                        <th class="text-right">Net Price</th>
                    </tr>
                    <?php
                    $counter = 0;
                    if (isset($_GET['page']) && $_GET['page'] > 1) {
                        $counter = ($_GET['page'] - 1) * $dataset->perPage();
                    }
                    $total_price = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    $counter++;
                    $total_price += $data->net_price;
                    ?>
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $counter }}</td>
                        <td>{{ date_dmy($data->date) }}</td>
                        <td>{{ $data->subheadName($data->subhead_id) }}</td>
                        <td>{{ $data->payment->shift }}</td>
                        <td>{{ $data->particularName($data->particular_id) }}</td>
                        <td class="text-right">{{ $data->net_price }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th colspan="5" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                        <th class="text-right">{{ $total_price }}</th>
                    </tr>
                </tbody>
            </table>
            <div class="text-center hip" id="apaginate">
                {{ $dataset->render() }}
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>