<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>Head</th>
                    <th>Sub Head</th>
                    <th>Description</th>
                    <th>By Whom</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center hip">Actions</th>
                    <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php $counter = 0;
                $total_amount = 0;
                ?>
                @foreach ($dataset as $data)
                <?php $counter++;
                $total_amount += $data->credit;
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ date_dmy( $data->pay_date ) }}</td>
                    <td>{{ $head->find($data->ledger_head_id)->name }}</td>
                    <td>{{ !empty($subhead->find($data->sub_head_id)->name) ? $subhead->find($data->sub_head_id)->name : '' }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->by_whom }}</td>
                    <td class="text-right">{{ $data->amount }}</td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <a class="btn btn-info btn-xs" href="{{ url('/transactions/'.$data->id.'/edit') }}"><i class="fa fa-edit"></i> Edit</a>
                        @endif
                        <a class="btn btn-success btn-xs" href="{{ url('/transactions/'.$data->id) }}"><i class="fa fa-dashboard"></i> View</a>
                    </td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <input type="checkbox" name="data[]" value="{{ $data->id }}">
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="6" class="text-right">Total Amount</th>
                    <th class="text-right">{{ $total_amount }}</th>
                    <th colspan="2" class="hip"></th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>