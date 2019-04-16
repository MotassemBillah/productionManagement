@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Sub Head List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li>Sub Head</li>
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
                            <div class="col-md-2 col-sm-3 xsw_70 no_pad">
                                <input type="text" name="search" id="q" class="form-control" placeholder="search" size="30">
                            </div>
                            @if( is_Admin() )
                            <div style="width:13%;"  class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <select id="InstituteList" class="form-control" name="institute_id">
                                    <option value="">All Company</option>
                                    @foreach ( $insList as $ins )
                                    <option value="{{ $ins->id  }}">{{ $ins->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-md-2 col-sm-3 xsw_50 no_pad">
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
                            <div class="col-md-2 col-sm-3 xsw_100 no_pad">
                                <button type="button" id="search" class="btn btn-info xsw_50">Search</button>
                                <button type="button" id="clear_from" class="btn btn-warning xsw_50">Clear</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right wmd_30" style="">
                    <a class="btn btn-success btn-xs xsw_33" href="{{ url ('/subhead/create') }}"><i class="fa fa-plus"></i> New</a>
                    <button type="button" class="btn btn-danger btn-xs xsw_33" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <button class="btn btn-primary btn-xs xsw_33" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

{!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmList','name'=>'frmList']) !!}
<div id="print_area">
    <?php print_header("SubHead Information"); ?>
    <div id="ajax_content">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:4%;">SL#</th>
                        <th class="{{ show_hide() }} ">Company Name</th>
                        <th>Head Name</th>
                        <th>Sub Head Name</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Credit</th>
                        <th class="text-right">Balance</th>
                        <th class="text-center hip" style="width:15%;">Actions</th>
                        <th class="text-center hip" style="width:3%;"><input type="checkbox" id="check_all"value="all"></th>
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
                    $_debit = $tmodel->sumSubDebit($data->id);
                    $_credit = $tmodel->sumSubCredit($data->id);
                    $_balance = $tmodel->sumSubBalance($data->id);
                    ?>
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td class="{{ show_hide() }} ">{{ $data->institute->name }}</td>
                        <td>{{ $data->head->name }}</td>
                        <td>{{ $data->name }}</td>
                        <td class="text-right">{{ $_debit }}</td>
                        <td class="text-right">{{ $_credit }}</td>
                        <td class="text-right">{{ $_balance }}</td>
                        <td class="text-center hip">
                            @if($data->is_edible == 1)
                            <a class="btn btn-info btn-xs" href="subhead/{{ $data->_key }}/edit">Edit</a>
                            @endif
                            <a class="btn btn-primary btn-xs" href="{{ url('ledger/subhead/'.$data->id) }}">Ledger</a>
                        </td>
                        <td class="text-center hip">
                            @if($data->is_edible == 1)
                            <input type="checkbox" name="data[]" value="{{ $data->id }}">
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center hip">
                {{ $dataset->render() }}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("change", "#InstituteList", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('institute/head') }}",
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
            var _url = "{{ URL::to('subhead/search') }}";
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
            var _url = "{{ URL::to('subhead/delete') }}";
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