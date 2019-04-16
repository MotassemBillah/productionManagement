@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Production Stocks List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">></span></li>
            <li>Production Stocks</li>
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
                            <input type="text" style="width:182px;" name="search" id="q" class="form-control" placeholder="search PS no" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:20%">
                    <a href="{{ url ('rice/production-stocks/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list"> 
    {!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
    <div id="print_area">
        <?php print_header("Prouduction Stocks List"); ?>
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Date</th>
                            <th>PS No</th>
                            <th>Drawer No</th>
                            <th class="text-center">Items</th>
                            <th class="text-right">Net Weight</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-center hip">Actions</th>
                        </tr>
                        <?php
                        $counter = 0;
                        if (isset($_GET['page']) && $_GET['page'] > 1) {
                            $counter = ($_GET['page'] - 1) * $dataset->perPage();
                        }
                        $total_weight = 0;
                        $total_quantity = 0;
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $counter++;
                        $date = date_dmy($data->date);
                        $ps_no = !empty($data->production_stocks_no) ? $data->production_stocks_no : '';
                        $dr_no = $no_of_item = $data->items()->count();
                        $net_weight = $data->items()->sum('weight');
                        $net_quantity = $data->items()->sum('quantity');

                        $total_weight += $net_weight;
                        $total_quantity += $net_quantity;
                        ?>   
                        <tr>
                            <td class="text-center" style="width:5%;">{{ $counter }}</td>
                            <td>{{ $date }}</td>
                            <td>{{ $ps_no }}</td>
                            <td>
                                <?php
                                $draws = json_decode($data->drawer_id);
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
                            <td class="text-center">{{ $no_of_item }}</td>
                            <td class="text-right">{{ round($net_weight, 2) }}</td>
                            <td class="text-right">{{ $net_quantity }}</td>
                            <td class="text-center hip">
                                <a class="btn btn-info btn-xs" href="production-stocks/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a> 
                                <a class="btn btn-success btn-xs" href="production-stocks/{{ $data->id }}"><i class="fa fa-eye"></i> View</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg_gray">
                            <td colspan="5" class="text-right"style="background:#ddd; font-weight:600; width:5%;">Total</td>
                            <td class="text-right" style="font-weight:600;">{{ round($total_weight, 2)  }}</td>
                            <td class="text-right" style="font-weight:600;">{{ $total_quantity }}</td>
                            <td class="hip" style="font-weight:600;"></td>
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
            var _url = "{{ URL::to('rice/production-stocks/search') }}";
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