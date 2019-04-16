<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>From Account</th>
                    <th>To Account</th>
                    <th class="text-right">Quantity</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Type</th>
                    <th class="text-right">Bag Price</th>
                    <th class="text-right">Total Price</th>
                    <th class="text-center hip">Actions</th>
                    <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                $total_quantity = 0;
                $total_bag_price = 0;
                $total_price = 0;
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $total_quantity += $data->quantity;
                $total_bag_price += $data->per_bag_price;
                $total_price += $data->total_price;
                $_frmpar_name = $data->particular_name($data->cr_particular_id);
                $_topar_name = $data->particular_name($data->dr_particular_id);
                $_frmsub_name = $data->subhead_name($data->cr_subhead_id);
                $_tosub_name = $data->subhead_name($data->dr_subhead_id);
                ?>   
                <tr>
                    <td class="text-center">{{ $counter }}</td>
                    <td>{{ date_dmy( $data->date ) }}</td>
                    <td>{{ $data->type }}</td>
                    <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
                    <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
                    <td class="text-right">{{ $data->quantity }}</td>
                    <td>{{ $data->size }}</td>
                    <td>{{ $data->color }}</td>
                    <td>{{ $data->bag_type }}</td>
                    <td class="text-right">{{ $data->per_bag_price }}</td>
                    <td class="text-right">{{ $data->total_price }}</td>
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
                    <th class="text-right">{{ $total_quantity }}</th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right">{{ $total_price }}</th>
                    <th class="hip" colspan="2"></th>
                </tr>
            </tbody>
        </table>
        <div class="clearfix" style="padding-top:30px;">
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Accountant</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Manager</div>
            </div>
            <div class="col-md-4 form-group mp_30">
                <div style="border-top:1px solid #000000;text-align:center;">Managing Director</div>
            </div>
        </div>
        <div class="text-center hip" id="apaginate">
            {{ $dataset->render() }}
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>