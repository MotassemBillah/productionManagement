<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>PS No</th>
                    <th>Drawer No</th>
                    <th class="text-center">Items</th>
                    <th class="text-right">Net Weight</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-center hip">Actions</th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                $total_weight = 0;
                $total_quantity = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $date = date_dmy($data->date);
                $ps_no = !empty($data->production_stocks_no) ? $data->production_stocks_no : '';
                $dr_no = $no_of_item = $data->items()->count();
                $net_weight = $data->items()->sum('weight');
                $net_quantity = $data->items()->sum('quantity');

                $total_weight += $net_weight;
                $total_quantity += $net_quantity;
                ?>   
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ $date }}</td>
                    <td>{{ $ps_no }}</td>
                    <td>
                        <?php
                        $draws = json_decode($data->drawer_id);
                        if (is_array($draws)) {
                            foreach ($draws as $_key => $dr) {
                                $drName = $drawer->find($dr)->name;
                                if ($_key == (count($draws) - 1)) {
                                    echo $drName;
                                } else {
                                    echo $drName . ", ";
                                }
                            }
                        }
                        ?> 
                    </td>
                    <td class="text-center">{{ $no_of_item }}</td>
                    <td class="text-right">{{ round($net_weight, 2) }}</td>
                    <td class="text-right">{{ $net_quantity }}</td>
                    <td class="text-center hip">
                        <a class="btn btn-info btn-xs" href="production-stocks/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a> 
                        <a class="btn btn-success btn-xs" href="production-stocks/{{ $data->id }}"><i class="fa fa-eye"></i> View</a>
                    </td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <td colspan="5" class="text-right"style="background:#ddd; font-weight:600; width:5%;">Total</td>
                    <td class="text-right" style="font-weight:600;">{{ round($total_weight, 2)  }}</td>
                    <td class="text-right" style="font-weight:600;">{{ $total_quantity }}</td>
                    <td class="hip" style="font-weight:600;"></td>
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