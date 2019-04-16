<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <table class="table table-bordered" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Date</th>
                <th>Order No</th>
                <th class="text-center">Items</th>
                <th class="text-right">Net Weight</th>
                <th class="text-right">Quantity</th>
                <th class="text-center">Status</th>
                <th class="text-center hip">Actions</th>
                <th class="text-center hip">
                    <?php if (has_user_access('flour_production_delete')) : ?>
                        <div class="checkbox">
                            <label><input type="checkbox" id="check_all"value="all"></label>
                        </div>
                    <?php endif; ?>
                </th>
            </tr>
            <?php
            $sl = 1;
            $total_weight = 0;
            $total_quantity = 0;
            $status = '';
            $btn = '';
            ?>
            @foreach ($dataset as $data)
            <?php
            $date = date_dmy($data->date);
            $order_no = !empty($data->order_no) ? $data->order_no : '';
            $no_of_item = $data->items()->count();

            $net_weight = $data->items()->sum('net_weight');
            $net_quantity = $data->items()->sum('net_quantity');

            $total_weight += $net_weight;
            $total_quantity += $net_quantity;

            if ($data->process_status == 0) {
                $status = 'Pending';
                $btn = 'warning';
            } else {
                $status = 'Completed';
                $btn = 'success';
            }
            ?>   
            <tr>
                <td class="text-center" style="width:5%;">{{ $sl }}</td>
                <td>{{ $date }}</td>
                <td>{{ $order_no }}</td>
                <td class="text-center">{{ $no_of_item }}</td>
                <td class="text-right">{{ round($net_weight, 2) }}</td>
                <td class="text-right">{{ $net_quantity }}</td>
                <td class="text-center" ><span class="label label-{{ $btn }} btn-xs">{{ $status }}</span></td>
                <td class="text-center hip">
                    <?php if ($status == 'Pending'): ?>
                        <a class="btn btn-success btn-xs" href="production/{{ $data->id }}"><i class="fa fa-eye"></i> View</a> 
                        <a class="btn btn-info btn-xs" href="production/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>    
                        <?php if (has_user_access('flour_production_confirm')) : ?>
                            <a class="btn btn-primary btn-xs" href="production/{{ $data->id }}/confirm" onClick="return confirm('Are you sure, Production Complete? This cannot be undone!');" ><i class="fa fa-gavel"></i> Process</a>
                        <?php endif; ?>
                    <?php else : ?>
                        <a class="btn btn-success btn-xs" href="production/{{ $data->id }}"><i class="fa fa-plus"></i> View</a>  
                    <?php endif; ?>
                </td>
                <td class="text-center hip">
                    <?php if (has_user_access('flour_production_delete')) : ?>
                        <div class="checkbox">
                            <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                        </div>
                    <?php endif; ?> 
                </td>
                <?php $sl++; ?>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</td>
                <td class="text-right" style="font-weight:600;">{{ round($total_weight, 2) }}</td>
                <td class="text-right" style="font-weight:600;">{{ $total_quantity }}</td>
                <td style="font-weight:600;"></td>
                <td class="hip" style="font-weight:600;"  colspan="2"></td>
            </tr>
        </tbody>
    </table>
    <div class="text-center hip" id="apaginate">
        {{ $dataset->render() }}
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>