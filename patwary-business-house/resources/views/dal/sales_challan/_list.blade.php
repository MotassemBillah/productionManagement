<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <table class="table table-bordered" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Date</th>
                <th>Supplier</th>
                <th>Challan No</th>
                <th>Order No</th>
                <th class="text-center">Truck No</th>
                <th class="text-right">Total Quantity</th>
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
            ?>
            @foreach ($dataset as $data)
            <?php
            $counter++;
            $total_quantity[] = $data->total_quantity;
            ?>   
            <tr>
                <td class="text-center" style="width:5%;">{{ $counter }}</td>
                <td>{{ date_dmy($data->date) }}</td>
                <td>{{ !empty($data->supplier_particular) ? $data->particularName($data->supplier_particular) : '' }}</td>
                <td>{{ $data->challan_no }}</td>
                <td>{{ $data->order_no }}</td>
                <td class="text-center">{{ $data->truck_no }}</td>
                <td class="text-right">{{ $data->total_quantity }}</td>
                <td class="text-center hip">
                    <a class="btn btn-success btn-xs" href="purchase-challan/{{ $data->id }}"><i class="fa fa-plus"></i> View</a> 
                    <a class="btn btn-info btn-xs" href="purchase-challan/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <td class="text-center hip">
                    <div class="checkbox">
                        <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                    </div>
                </td>
            </tr>
            @endforeach
            <tr class="bg_gray">
                <th colspan="6" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                <th class="text-right">{{ array_sum($total_quantity) }}</th>
                <td colspan="2" class="hip"></td>
            </tr>
        </tbody>
    </table>
    <div class="text-center hip" id="apaginate">
        {{ $dataset->render() }}
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>