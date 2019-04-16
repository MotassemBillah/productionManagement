<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Account</th>
                    <th>Description</th>
                    <th class="text-right">Payment</th>
                    <th class="text-right">Receive</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center hip">Actions</th>
                    <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                $total_quantity = 0;
                $total_debit = 0;
                $total_credit = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $total_quantity += ($data->debit - $data->credit);
                $total_debit += $data->debit;
                $total_credit += $data->credit;
                $_par_name = $data->particular_name($data->particular_id);
                $_sub_name = $data->subhead_name($data->subhead_id);
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ date_dmy( $data->date ) }}</td>
                    <td>{{ $data->type }}</td>
                    <td>{{ !empty($_sub_name) ? $_sub_name : $data->head_name($data->head_id) }} {{ !empty($_par_name) ? ' -> ' . $_par_name : '' }}</td>
                    <td>{{ $data->description }}</td>
                    <td class="text-right">{{ $data->credit }}</td>
                    <td class="text-right">{{ $data->debit }}</td>
                    <td class="text-right">{{ ($data->credit - $data->debit) }}</td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <a class="btn btn-info btn-xs" href="emptybags/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                        @endif
                        <a class="btn btn-success btn-xs" href="emptybags/{{ $data->id }}"><i class="fa fa-dashboard"></i> View</a>
                    </td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <input type="checkbox" name="data[]" value="{{ $data->id }}">
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="5" class="text-right">Total</th>
                    <th class="text-right">{{ $total_credit }}</th>
                    <th class="text-right">{{ $total_debit }}</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                    <th class="hip" colspan="2"></th>
                </tr>
            </tbody>
        </table>
        <div class="text-center hip">
            {{ $dataset->render() }}
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>