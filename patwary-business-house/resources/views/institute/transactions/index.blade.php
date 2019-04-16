@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Transaction List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li>Transactions</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="well">
    <table width="100%">
        <tbody>
            <tr>
                <td class="wmd_70">
                    {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!}
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <?php echo number_dropdown(50, 550, 50, null, 'xsw_30') ?>
                            @if( is_Admin() )
                            <div style="width:12%;"  class="col-md-2 col-sm-3 xsw_70 no_pad">
                                <select id="InstituteList" class="form-control" name="institute_id">
                                    <option value="">All Company</option>
                                    @foreach ( $insList as $ins )
                                    <option value="{{ $ins->id  }}">{{ $ins->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div style="width:12%;"  class="col-md-2 col-sm-3 xsw_60 no_pad">
                                <select id="head" class="form-control" name="head_id" required>
                                    @if ( !is_Admin() )
                                    <option value="">All Head</option>
                                    @foreach($heads as $head)
                                    <option value="{{$head->id}}">{{$head->name}}</option>
                                    @endforeach
                                    @else
                                    <option value="">All Head</option>
                                    @endif
                                </select>
                            </div>
                            <div style="width:12%;" class="col-md-2 col-sm-3 xsw_40 no_pad">
                                <select id="sortBy" class="form-control" name="voucher_type">
                                    <option value="">Voucher Type</option>
                                    <option value="Payment Voucher">Payment Voucher</option>
                                    <option value="Receive Voucher">Receive Voucher</option>
                                    <option value="Journal Voucher">Journal Voucher</option>
                                    <option value="Purchase Voucher">Purchase Voucher</option>
                                    <option value="Sales Voucher">Sales Voucher</option>
                                </select>
                            </div>
                            <div style="width:16%;" class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <div class="input-group">
                                    <input type="text" name="from_date" placeholder="(dd-mm-yyyy)" class="form-control pickdate" size="30" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div style="width:6%" class="col-md-1 col-sm-1 hidden-xs no_pad">
                                <span style="font-size:14px; padding:14px; font-weight:600;">TO</span>
                            </div>
                            <div style="width:16%;" class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <div class="input-group">
                                    <input type="text" placeholder="(dd-mm-yyyy)" name="end_date" class="form-control pickdate" size="30" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 xsw_100 no_pad" style="width:18%;">
                                <input type="text" name="search" id="q" class="form-control" placeholder="search particular" size="30">
                            </div>
                            <div style="width:15%;" class="col-md-2 col-sm-3 xsw_100 no_pad">
                                <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                                <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right wmd_30" style="width:26%">
                    <a class="btn btn-success btn-xs xsw_33" href="{{ url('/transactions/create/d') }}"><i class="fa fa-plus"></i>&nbsp;Receive</a>
                    <a class="btn btn-warning btn-xs xsw_33" href="{{ url('/transactions/create/c') }}"><i class="fa fa-minus"></i>&nbsp;Payment</a>
                    <a class="btn btn-info btn-xs xsw_33" href="{{ url('/transactions/create/journal') }}"><i class="fa fa-plus"></i>&nbsp;Journal</a>
                    <button type="button" class="btn btn-danger btn-xs xsw_33" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs xsw_33" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
{!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmList','name'=>'frmList']) !!}
<div id="print_area">
    <?php print_header("Transactions Information"); ?>
    <div id="ajax_content">
        <?php if (!empty($dataset) && count($dataset) > 0) : ?>
            <div class="table-responsive">
                <table class="table table-bordered tbl_thin" id="check">
                    <tbody>
                        <tr class="bg_gray" id="r_checkAll">
                            <th class="text-center" style="width:3%;">SL#</th>
                            <th class="{{ show_hide() }} ">Company Name</th>
                            <th style="width:90px">Date</th>
                            <th>Voucher Type</th>
                            <th>From Head</th>
                            <th>To Head</th>
                            <th style="width:25%">Description</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th class="text-center hip" style="width:5%">Actions</th>
                            <th class="text-center hip" style="width:2%;"><input type="checkbox" id="check_all"value="all"></th>
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
                        $_frmpar_name = $data->particular_name($data->cr_particular_id);
                        $_topar_name = $data->particular_name($data->dr_particular_id);
                        $_frmsub_name = $data->subhead_name($data->cr_subhead_id);
                        $_tosub_name = $data->subhead_name($data->dr_subhead_id);
                        ?>
                        <tr>
                            <td class="text-center">{{ $counter }}</td>
                            <td class="{{ show_hide() }} ">{{ $data->institute->name }}</td>
                            <td>{{ date_dmy( $data->date ) }}</td>
                            <td>{{ $data->voucher_type }}</td>
                            <td>{{ !empty($_frmsub_name) ? $_frmsub_name : $data->head_name($data->cr_head_id) }} {{ !empty($_frmpar_name) ? ' -> ' . $_frmpar_name : '' }}</td>
                            <td>{{ !empty($_tosub_name) ? $_tosub_name : $data->head_name($data->dr_head_id) }} {{ !empty($_topar_name) ? ' -> ' . $_topar_name : '' }}</td>
                            <td>{{ $data->description }}</td>
                            <td class="text-right">{{ $data->debit }}</td>
                            <td class="text-right">{{ $data->credit }}</td>
                            <td class="text-center hip">
                                @if( $data->is_edible == 1 )
                                <a class="btn btn-info btn-xs mb_5" href="transactions/{{ $data->_key }}/edit">Edit</a>
                                @endif
                                <a class="btn btn-success btn-xs" href="transactions/{{ $data->_key }}">View</a>
                            </td>
                            <td class="text-center hip">
                                @if( $data->is_edible == 1 )
                                <input type="checkbox" name="data[]" value="{{ $data->id }}">
                                @endif
                            </td>
                        </tr>
                        <?php
                        $debit[] = $data->debit;
                        $credit[] = $data->credit;
                        ?>
                        @endforeach
                        <tr class="bg_gray">
                            <th colspan="{{ colspan(7,6) }}" class="text-right">Total</th>
                            <th class="text-right">{{ array_sum($debit) }}</th>
                            <th class="text-right">{{ array_sum($credit) }}</th>
                            <th class="hip" colspan="2"></th>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center hip">
                    {{ $dataset->render() }}
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No records found!</div>
        <?php endif; ?>
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {


        $(document).on("change", "#InstituteList", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('institute/subhead') }}",
                type: "post",
                data: {'institute': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    //enable("#subhead");
                    $('#head').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $("#search").click(function () {
            var _url = "{{ URL::to('transactions/search') }}";
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

        $("#Del_btn").click(function () {
            var _url = "{{ URL::to('transactions/delete') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {

                $.post(_url, _form.serialize(), function (data) {
                    if (data.success === true) {
                        $('#ajaxMessage').showAjaxMessage({html: data.message, type: 'success'});
                        $("#search").trigger("click");
                    } else {
                        $('#ajaxMessage').showAjaxMessage({html: data.message, type: 'error'});
                    }
                }, "json");

            }

        });
    });
</script>
@endsection