<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <table class="table table-bordered tbl_thin" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th class="{{ show_hide() }} ">Company</th>
                <th>Date</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Challan No</th>
                <th>Slip No</th>
                <th class="text-right">Bag Quantity</th>
                <th class="text-right">Net Mon</th>
                <th class="text-right">Net Weight</th>
                <th class="text-right">Per Mon Price</th>
                <th class="text-center">Total Price</th>
                <th class="text-center hip">Actions</th>
                <th class="text-center hip">
                    <div class="checkbox">
                        <label><input type="checkbox" id="check_all"value="all"></label>
                    </div>
                </th>
            </tr>
            <?php
            $counter = 0;
            if (isset($_GET['page']) && $_GET['page'] > 1) {
                $counter = ($_GET['page'] - 1) * $dataset->perPage();
            }
            $total_bag_quantity = 0;
            $total_net_weight = 0;
            $total_net_mon = 0;
            $total_price = 0;
            $total_per_price = 0;
            ?>
            @foreach ($dataset as $data)
            <?php
            $counter++;
            $total_bag_quantity += $data->bag_quantity;
            $total_net_weight += $data->net_weight;
            $total_net_mon += $data->net_mon;
            $total_per_price += $data->per_mon_price;
            $total_price += $data->total_price;
            ?>   
            <tr>
                <td class="text-center" style="width:5%;">{{ $counter }}</td>
                <td class="{{ show_hide() }} ">{{ $data->institute->name }}</td>
                <td>{{ date_dmy($data->date) }}</td>
                <td>{{ !empty($data->supplier_particular) ? $data->particularName($data->supplier_particular) : '' }}</td>
                <td>{{ $data->productName($data->product_id) }}</td>
                <td>{{ $data->challan_no }}</td>
                <td>{{ $data->slip_no }}</td>
                <td class="text-right">{{ $data->bag_quantity }}</td>
                <td class="text-right">{{ $data->net_mon }}</td>
                <td class="text-right">{{ $data->net_weight }}</td>
                <td class="text-right">{{ $data->per_mon_price }}</td>
                <td class="text-right">{{ $data->total_price }}</td>
                <td class="text-center hip">
                    <a class="btn btn-success btn-xs" href="purchase-challan/{{ $data->id }}"><i class="fa fa-plus"></i> View</a> 
                    <a class="btn btn-info btn-xs" href="purchase-challan/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <td class="text-center hip">
                    <div class="checkbox">
                        <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                    </div>
                </td>
            </tr>
            @endforeach
            <tr class="bg_gray">
                <th colspan="{{ colspan(7,6) }}" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                <th class="text-right">{{ $total_bag_quantity }}</th>
                <th class="text-right">{{ $total_net_mon }}</th>
                <th class="text-right">{{ $total_net_weight }}</th>
                <th class="text-right">{{ $total_per_price }}</th>
                <th class="text-right">{{ $total_price }}</th>
                <th colspan="2"></th>
            </tr>
        </tbody>
    </table>
    <div class="text-center hip" id="apaginate">
        {{ $dataset->render() }}
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>