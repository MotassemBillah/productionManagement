@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Stock Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span> Production</span></li>
        </ul>                            
    </div>
</div>
<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!} 
                    {{ csrf_field() }}
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                           <?php echo number_dropdown(50, 500, 50) ?>
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <input type="text" style="width:182px;" name="search" id="q" class="form-control" placeholder="search order no" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:12%">
                    <a href="{{ url ('flour/production-stocks/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list"> 
    {!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
    <div id="print_area">
        <?php print_header("Prouduction Stock Details"); ?>
        <div id="ajax_content">
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
                                    $gtotal_quantity += $tquantity; ?>
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
                <div class="text-center hip">
                    {{ $dataset->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").click(function () {
            var _url = "{{ URL::to('flour/productionstocks/details/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function () {
                    $('#ajaxMessage').showAjaxMessage({html: 'There is some error.Try after some time.', type: 'error'});
                }
            });
        });
    });
</script>

@endsection