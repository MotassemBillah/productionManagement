@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Sales Ledger</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Order</span></li>
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
                            <select id="itemCount" class="form-control" name="item_count" style="width:58px;">
                                <?php
                                for ($i = 10; $i <= 100; $i += 10):
                                    echo "<option value='{$i}'>{$i}</option>";
                                endfor;
                                ?>                        
                            </select>
                            <div style="width:18%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by_customer">
                                    <option value="" selected>Select Head</option>                  
                                    @foreach( $particular->where('head_id', HEAD_DEBTORS)->get() as $head )
                                    <option value="{{ $head->id }}">{{ $head->name }}</option>
                                    @endforeach
                                </select>
                            </div>  
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                            </div> 
                            <div style="width:5%" class="col-md-1 col-sm-1 no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div> 
                            <div class="col-md-2 col-sm-3 no_pad">
                                <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                            </div> 
                             <div style="width:18%;" class="col-md-2 col-sm-3 no_pad">
                                <select id="sortBy" class="form-control" name="search_by_product">
                                    <option value="" selected>Select Product</option>                  
                                    @foreach( $product->all() as $pro )
                                    <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right" style="width:20%">
                    <a href="{{ url ('sales/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <button class="btn btn-primary btn-xs" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="order-list"> 
    {!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!} 
    <div id="print_area">
        <?php print_header("Purchase Ledger"); ?>
        <div id="ajax_content">
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:5%;">SL#</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th class="text-right">Weight</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Price</th>
                        </tr>
                        <?php
                        $counter = 0;
                        if (isset($_GET['page']) && $_GET['page'] > 1) {
                            $counter = ($_GET['page'] - 1) * $dataset->perPage();
                        }
                        $total_weight = 0;
                        $total_quantity = 0;
                        $total_price = 0;
                        ?>
                        @foreach ($dataset as $data)
                        <?php
                        $counter++;
                        $total_weight += $data->weight;
                        $total_quantity += $data->quantity;
                        $total_price += $data->net_price;
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
                            <td>{{ $data->weights->invoice_no }}</td>
                            <td>{{ !empty($data->head_id) ? $subhead->find($data->head_id)->name : 'N\A' }} {{ !empty($data->subhead_id) ? ' -> ' . $particular->find($data->subhead_id)->name : '' }}</td>
                            <td>{{ $data->after_product_name($data->after_production_id) }}</td>
                            <td class="text-right">{{ $data->weight }}</td>
                            <td class="text-right">{{ $data->quantity }}</td>
                            <td class="text-right">{{ $data->net_price }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg_gray">
                            <th colspan="5" class="text-center" style="background:#ddd; font-weight:600; width:5%;">Total</th>
                            <th class="text-right">{{ $total_weight }}</th>
                            <th class="text-right">{{ $total_quantity }}</th>
                            <th class="text-right">{{ $total_price }}</th>
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
            var _url = "{{ URL::to('sale/ledger/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });

        })

    });
</script>

@endsection