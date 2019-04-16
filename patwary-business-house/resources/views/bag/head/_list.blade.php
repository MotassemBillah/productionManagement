<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Name</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center hip" style="width:12%;">Actions</th>
                    <?php if (has_user_access('manage_head')) : ?><th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th> <?php endif; ?>
                </tr>
                <?php $counter = 0; ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $_debit = $tmodel->sumDebit($data->id);
                $_credit = $tmodel->sumCredit($data->id);
                $_balance = $tmodel->sumBalance($data->id);
                ?>   
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $data->name }}</td>
                    <td class="text-right">{{ $_debit }}</td>
                    <td class="text-right">{{ $_credit }}</td>
                    <td class="text-right">{{ $_balance }}</td>
                    <td class="text-center hip">
                        <?php if (has_user_access('manage_head')) : ?>  <a class="btn btn-info btn-xs" href="head/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a> <?php endif; ?>
                        <a class="btn btn-primary btn-xs" href="{{ url('ledger/head/'.$data->id) }}"><i class="fa fa-dashboard"></i> Ledger</a>
                    </td>
                    <?php if (has_user_access('manage_head')) : ?> <td class="text-center hip"><input type="checkbox" name="data[]" value="{{ $data->id }}"></td> <?php endif; ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>