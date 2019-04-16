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
                        <th class="text-right">No of Labor</th>
                        <th class="text-right">Total Price</th>
                        <th class="text-center hip">Actions</th>
                        <th class="text-center hip">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all"value="all"></label>
                            </div>
                        </th>
                    </tr>
                    <?php
                    $counter = 0;
                    if (isset($_GET['page']) && $_GET['page'] > 1) {
                        $counter = ($_GET['page'] - 1) * $dataset->perPage();
                    }
                    $total_labor = 0;
                    $total_price = 0;
                    ?>
                    @foreach ($dataset as $data)
                    <?php
                    $counter++;
                    $total_labor += $data->no_of_labor;
                    $total_price += $data->total_price;
                    ?>
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $counter }}</td>
                        <td>{{ date_dmy($data->date) }}</td>
                        <td>{{ $data->subheadName($data->subhead_id) }}</td>
                        <td>{{ $data->shift }}</td>
                        <td class="text-right">{{ $data->no_of_labor }}</td>
                        <td class="text-right">{{ $data->total_price }}</td>
                        <td class="text-center hip">
                            <a class="btn btn-success btn-xs" href="laborpayment/{{ $data->id }}"><i class="fa fa-eye"></i> View</a>
                            <a class="btn btn-info btn-xs" href="laborpayment/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                        </td>
                        <td class="text-center hip">
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="bg_gray">
                        <th colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                        <th class="text-right">{{ $total_labor }}</th>
                        <th class="text-right">{{ $total_price }}</th>
                        <th colspan="3" class=""></th>
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