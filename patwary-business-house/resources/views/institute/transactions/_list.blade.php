<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:3%;">SL#</th>
                    <th class="{{ show_hide() }} ">Company Name</th>
                    <th style="width:90px">Date</th>
                    <th>Voucher Type</th>
                    <th>From Head</th>
                    <th>To Head</th>
                    <th style="width:25%">Description</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-center hip" style="width:5%">Actions</th>
                    <th class="text-center hip" style="width:2%;"><input type="checkbox" id="check_all"value="all"></th>
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
                $_frmpar_name = $data->particular_name($data->cr_particular_id);
                $_topar_name = $data->particular_name($data->dr_particular_id);
                $_frmsub_name = $data->subhead_name($data->cr_subhead_id);
                $_tosub_name = $data->subhead_name($data->dr_subhead_id);
                ?>
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td class="{{ show_hide() }} ">{{ $data->institute->name }}</td>
                    <td>{{ date_dmy( $data->date ) }}</td>
                    <td>{{ $data->voucher_type }}</td>
                    <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
                    <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
                    <td>{{ $data->description }}</td>
                    <td class="text-right">{{ $data->debit }}</td>
                    <td class="text-right">{{ $data->credit }}</td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <a class="btn btn-info btn-xs mb_5" href="transactions/{{ $data->_key }}/edit">Edit</a>
                        @endif
                        <a class="btn btn-success btn-xs" href="transactions/{{ $data->_key }}">View</a>
                    </td>
                    <td class="text-center hip">
                        @if( $data->is_edible == 1 )
                        <input type="checkbox" name="data[]" value="{{ $data->id }}">
                        @endif
                    </td>
                </tr>
                <?php
                $debit[] = $data->debit;
                $credit[] = $data->credit;
                ?>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="{{ colspan(7,6) }}" class="text-right">Total</th>
                    <th class="text-right">{{ array_sum($debit) }}</th>
                    <th class="text-right">{{ array_sum($credit) }}</th>
                    <th class="hip" colspan="2"></th>
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