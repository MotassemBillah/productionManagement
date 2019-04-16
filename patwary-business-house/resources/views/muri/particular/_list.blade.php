<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Sub Head</th>
                    <th>Name</th>
                    <th class="text-right">Mon Weight</th>
                    <th>Company</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                    <th class="text-right">Balance</th>
                    <th class="text-center hip" style="width:12%;">Actions</th>
                    <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
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
                $_debit = $tmodel->sumPartDebit($data->id);
                $_credit = $tmodel->sumPartCredit($data->id);
                $_balance = $tmodel->sumPartBalance($data->id);
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ $data->subhead->name }}</td>
                    <td>{{ $data->name }}</td>
                    <td class="text-right">{{ $data->mon }}</td>
                    <td>{{ $data->company_name }}</td>
                    <td>{{ $data->mobile }}</td>
                    <td>{{ $data->address }}</td>
                    <td class="text-right">{{ $_debit }}</td>
                    <td class="text-right">{{ $_credit }}</td>
                    <td class="text-right">{{ $_balance }}</td>
                    <td class="text-center hip">
                        <a class="btn btn-info btn-xs" href="particular/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                        <a class="btn btn-primary btn-xs" href="{{ url('ledger/particular/'.$data->id) }}"><i class="fa fa-dashboard"></i> Ledger</a>
                    </td>
                    <td class="text-center hip"><input type="checkbox" name="data[]" value="{{ $data->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center hip">
            {{ $dataset->render() }}
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>