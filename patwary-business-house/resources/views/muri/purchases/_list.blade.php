<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Supplier</th>
                    <th>Items</th>
                    <th>Quantity</th>
                    <th>Weight</th>
                    <th>Mon</th>
                    <th>Total Price</th>
                    <th class="text-center hip">Process Status</th>
                    <th class="text-center hip">Payment Status</th>
                    <th class="text-center hip">Actions</th>
                    <?php if (has_user_access('purchase_delete')) : ?>
                        <th class="text-center hip">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all"value="all"></label>
                            </div>
                        </th>
                    <?php endif; ?>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                $total_weight = 0;
                $total_quantity = 0;
                $total_price = 0;
                $total_mon = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $total_weight += $data->weight;
                $total_quantity += $data->quantity;
                $total_price += $data->invoice_amount;
                $total_mon += $data->mon;
                if ($data->process_status == 0) {
                    $process_status = 'Pending';
                    $process_btn = 'warning';
                } else {
                    $process_status = 'Completed';
                    $process_btn = 'success';
                }

                if ($data->payment_status == 0) {
                    $payment_status = 'Pending';
                    $payment_btn = 'warning';
                } else {
                    $payment_status = 'Completed';
                    $payment_btn = 'success';
                }
                ?>   
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ date_dmy($data->date) }}</td>
                    <td>{{ !empty($data->invoice_no) ? $data->invoice_no : '' }}</td>
                    <td>{{ !empty($data->head_id) ? $subhead->find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . $particular->find($data->subhead_id)->name : '' }}</td>
                    <td class="text-center">{{ $data->items()->count()}}</td>
                    <td class="text-right">{{ $data->quantity }}</td>
                    <td class="text-right">{{ $data->weight }}</td>
                    <td class="text-right">{{ $data->mon }}</td>
                    <td class="text-right">{{ $data->invoice_amount }}</td>
                    <td class="text-center hip" ><span class="label label-{{ $process_btn }} btn-xs">{{ $process_status }}</span></td>
                    <td class="text-center hip" ><span class="label label-{{ $payment_btn }} btn-xs">{{ $payment_status }}</span></td>
                    <td class="text-center hip">
                        <?php if ($process_status == 'Pending'): ?>
                            <a class="btn btn-success btn-xs" href="purchases/{{ $data->id }}"><i class="fa fa-plus"></i> View</a> 
                            <a class="btn btn-info btn-xs" href="purchases/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                            <?php if (has_user_access('purchase_confirm')) : ?>
                                <a class="btn btn-primary btn-xs" href="purchases/{{ $data->id }}/confirm" onClick="return confirm('Are you sure, Purchase Complete? This cannot be undone!');" ><i class="fa fa-gavel"></i> Process</a>
                            <?php endif; ?>
                        <?php else : ?>
                            <a class="btn btn-success btn-xs" href="purchases/{{ $data->id }}"><i class="fa fa-plus"></i> View</a>  
                            <?php if (has_user_access('purchase_confirm')) : ?>
                                <a class="btn btn-danger btn-xs" href="purchases/{{ $data->id }}/reset" onClick="return confirm('Are you sure, Purchase Reset? This cannot be undone!');" ><i class="fa fa-refresh"></i> Reset</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center hip">
                        <?php if (has_user_access('purchase_delete')) : ?>
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                @endforeach
                <tr class="bg_gray">
                    <th colspan="5" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                    <th class="text-right">{{ $total_quantity }}</th>
                    <th class="text-right">{{ $total_weight }}</th>
                    <th class="text-right">{{ $total_mon }}</th>
                    <th class="text-right">{{ $total_price }}</th>
                    <th colspan="2" class="hip"></th>
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