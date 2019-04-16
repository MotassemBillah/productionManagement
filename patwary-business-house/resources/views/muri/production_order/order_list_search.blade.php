<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
            <table class="table table-bordered" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Date</th>
                        <th class="text-center">Order No</th>
                        <th style="width:15%;">Product</th>
                        <th style="width:15%;">Drawer Name</th>
                        <th class="text-right" style="width:15%;">Net Weight</th>
                        <th class="text-right" style="width:15%;">Quantity</th>
                    </tr>
                    <?php $sl = 1; ?>
                    @foreach ($dataset as $data)
                    <?php
                    $total_weight = 0;
                    $total_quantity = 0;
                    $date = date_dmy($data->date);
                    $order_no = !empty($data->order_no) ? $data->order_no : '';
                    ?>   
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ $date }}</td>
                        <td class="text-center">{{ $order_no }}</td>
                        <td colspan="4" style="padding:0;">
                            <table class="table table-bordered tbl_thin" style="margin:0;">
                                @foreach ( $data->items as $item )
                                <?php
                                $total_weight += $item->net_weight;
                                $total_quantity += $item->net_quantity;
                                ?>
                                <tr>
                                    <td style="width:15%">{{ $product->find($item->product_id)->name }}</td>
                                    <td style="width:15%">{{ $drawer->find($item->drawer_id)->name }}</td>
                                    <td class="text-right" style="width:15%">{{ $item->net_weight }}</td>
                                    <td class="text-right" style="width:15%">{{ $item->net_quantity }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg_gray">
                                    <th class="text-right" colspan="2">Total</th>
                                    <th class="text-right">{{ $total_weight }}</th>
                                    <th class="text-right">{{ $total_quantity }}</th>
                                </tr>
                            </table>
                        </td>
                        <?php $sl++; ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>