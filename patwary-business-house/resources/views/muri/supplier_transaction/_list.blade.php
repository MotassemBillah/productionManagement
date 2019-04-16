<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Supplier</th>
                    <th>Pay Date</th>
                    <th>Invoice Number</th>
                    <th>Invoice Amount</th>
                    <th>Discount</th>
                    <th>Invoice Paid</th>
                    <th>Invoice Due</th>
                    <th>Previous Due</th>
                    <th>Advance Paid</th>
                    <th>Due Paid</th>
                    <th class="hip">Actions</th>
                    <th class="text-center hip">
                        <div class="checkbox">
                            <label><input type="checkbox" id="check_all"value="all"></label>
                        </div>
                    </th>
                </tr>
                <?php
                $sl = 1;
                $total_invoice_amount = 0;
                $total_dis_amt = 0;
                $total_inv_paid = 0;
                $total_inv_due = 0;
                $total_inv_pdue = 0;
                $total_inv_add = 0;
                $total_due_paid = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $total_invoice_amount += $data->invoice_amount;
                $total_dis_amt += $data->discount_amount;
                $total_inv_paid += $data->invoice_paid;
                $total_inv_due += $data->invoice_due;
                $total_inv_pdue += $data->previous_due;
                $total_inv_add += $data->invoice_advance;
                $total_due_paid += $data->due_paid;
                ?>
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $suppliers->find($data->supplier_id)->agent_name }}</td>
                    <td>{{ date_dmy($data->pay_date) }}</td>
                    <td>{{ $data->invoice_no }}</td>
                    <td class="text-right">{{ $data->net_amount }}</td>
                    <td class="text-right">{{ $data->discount_amount }}</td>
                    <td class="text-right">{{ $data->invoice_paid }}</td>
                    <td class="text-right">{{ $data->invoice_due }}</td>
                    <td class="text-right">{{ $data->previous_due }}</td>
                    <td class="text-right">{{ $data->invoice_advance }}</td>
                    <td class="text-right">{{ $data->due_paid }}</td>
                    <td class="text-center hip">
                        <?php if ($data->is_edible == 1) : ?>
                            <a class="btn btn-info btn-xs" href="supplier-transaction/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                        <?php endif; ?>
                    </td>

                    <td class="text-center hip">
                        <?php if ($data->is_edible == 1) : ?>
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                            <?php
                        endif;
                        $sl++;
                        ?>
                    </td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th class="text-right" colspan="4">Total</th>
                    <th class="text-right">{{ $total_invoice_amount }}</th>
                    <th class="text-right">{{ $total_dis_amt }}</th>
                    <th class="text-right">{{ $total_inv_paid }}</th>
                    <th class="text-right">{{ $total_inv_due }}</th>
                    <th class="text-right">{{ $total_inv_pdue }}</th>
                    <th class="text-right">{{ $total_inv_add }}</th>
                    <th class="text-right">{{ $total_due_paid }}</th>
                    <th class="hip" colspan="2"></th>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>