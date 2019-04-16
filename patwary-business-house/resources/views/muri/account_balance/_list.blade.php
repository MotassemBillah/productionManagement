<?php 
    use App\Models\BankAccount;
    $BAmodel = new BankAccount();
?>
<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Bank Name</th>
                    <th>Manager No</th>
                    <th>Account Name</th>
                    <th>Account No</th>
                    <th>Account Type</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center" style="width:10%;">Actions</th>
                    <th class="text-center" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php $counter = 0; ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $_bank = $bank->find($data->bank_id);
                $_debit = $BAmodel->sumDebit($data->bank_id);
                $_credit = $BAmodel->sumCredit($data->bank_id);
                $_balance = $BAmodel->sumBalance($data->bank_id);
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ $_bank->name }}</td>
                    <td>{{ $data->manager_mobile }}</td>
                    <td>{{ $data->account_name }}</td>
                    <td>{{ $data->account_number }}</td>
                    <td>{{ $data->account_type }}</td>
                    <td class="text-right">{{ $_debit }}</td>
                    <td class="text-right">{{ $_credit }}</td>
                    <td class="text-right">{{ $_balance }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="bank-account/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td class="text-center"><input type="checkbox" name="data[]" value="{{ $data->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>