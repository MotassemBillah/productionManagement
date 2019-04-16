<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:4%;">SL#</th>
                    <th class="{{ show_hide() }} ">Company Name</th>
                    <th>Head Name</th>
                    <th>Sub Head Name</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center hip" style="width:15%;">Actions</th>
                    <th class="text-center hip" style="width:3%;"><input type="checkbox" id="check_all"value="all"></th>
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
                $_debit = $tmodel->sumSubDebit($data->id);
                $_credit = $tmodel->sumSubCredit($data->id);
                $_balance = $tmodel->sumSubBalance($data->id);
                ?>
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td class="{{ show_hide() }} ">{{ $data->institute->name }}</td>
                    <td>{{ $data->head->name }}</td>
                    <td>{{ $data->name }}</td>
                    <td class="text-right">{{ $_debit }}</td>
                    <td class="text-right">{{ $_credit }}</td>
                    <td class="text-right">{{ $_balance }}</td>
                    <td class="text-center hip">
                        @if($data->is_edible == 1)
                        <a class="btn btn-info btn-xs" href="subhead/{{ $data->_key }}/edit">Edit</a>
                        @endif
                        <a class="btn btn-primary btn-xs" href="{{ url('ledger/subhead/'.$data->id) }}">Ledger</a>
                    </td>
                    <td class="text-center hip">
                        @if($data->is_edible == 1)
                        <input type="checkbox" name="data[]" value="{{ $data->id }}">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center hip" id="apaginate">
            {{ $dataset->render() }}
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>