<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Date</th>
                    <th class="text-center">Order No</th>
                    <th style="width:15%;">Drawer Name</th>
                    <th style="width:15%;">Product</th>
                    <th class="text-right" style="width:15%;">Net Weight</th>
                    <th class="text-right" style="width:15%;">Quantity</th>
                </tr>
                <?php
                $counter = 0;
                $gtotal_weight = 0;
                $gtotal_drawer = 0;
                $gtotal_quantity = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                $date = date_dmy($data->date);
                $order_no = !empty($data->order_no) ? $data->order_no : '';
                ?>   
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ $date }}</td>
                    <td class="text-center">{{ $order_no }}</td>
                    <td colspan="4" style="padding:0;">
                        <table class="table table-bordered tbl_thin" style="margin:0;">
                            @foreach ( $data->getDrawerByOrder($order_no) as $item )
                            <tr>
                                <td style="width:25%;">
                                    <?php
                                    $tweight = 0;
                                    $tquantity = 0;
                                    $draws = json_decode($item->drawer_id);
                                    $gtotal_drawer += is_array($draws) ? count($draws) : 0;
                                    if (is_array($draws)) {
                                        foreach ($draws as $_key => $dr) {
                                            $drName = $drawer->find($dr)->name;
                                            if ($_key == (count($draws) - 1)) {
                                                echo $drName;
                                            } else {
                                                echo $drName . ", ";
                                            }
                                        }
                                    }
                                    ?>                     
                                </td> 
                                <td style="padding: 0">                                                    
                                    <table class="table table-bordered tbl_thin" style="margin: 0">
                                        @foreach ( $data->getProductByDrawer($order_no, $item->drawer_id ) as $pro )
                                        <?php
                                        $tweight += $pro->weight;
                                        $tquantity += $pro->quantity;
                                        ?>
                                        <tr>
                                            <td style=" width:33%;">{{ $product->find($pro->after_production_id)->name }}</td>
                                            <td class="text-right" style=" width:35%;">{{ $pro->weight }}</td>
                                            <td class="text-right">{{ $pro->quantity }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="bg_gray">
                                            <th class="text-right">Total</th>
                                            <th class="text-right">{{ $tweight }}</th>
                                            <th class="text-right">{{ $tquantity }}</th>
                                        </tr>
                                    </table>                 
                                </td>
                            </tr> 
                            <?php $gtotal_weight += $tweight;
                            $gtotal_quantity += $tquantity;
                            ?>
                            @endforeach
                        </table>
                    </td>
                </tr>
                @endforeach
                <tr class="bg-gray">
                    <th class="text-right" colspan="3">Grand Total</th>
                    <th class="text-right">Total Drawer = {{ $gtotal_drawer }}</th>
                    <th class="text-right"></th>
                    <th class="text-right">Total Weight = {{ $gtotal_weight }}</th>
                    <th class="text-right">Total Quantity = {{ $gtotal_quantity }}</th>
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