@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Company List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li>Company List</li>
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
                    {{ csrf_field() }}
                    <div class="input-group">
                        <div class="input-group-btn clearfix">
                            <?php echo number_dropdown(50, 550, 50, null, 'xsw_30') ?>
                            <div class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <input type="text" name="search" id="q" class="form-control" placeholder="search name or email" size="30">
                            </div>
                            <div class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <select id="sortBy" class="form-control" name="sort_by">
                                    <option value="">Sort By</option>
                                    <option value="institute" style="text-transform:capitalize">Company</option>
                                    <option value="email" style="text-transform:capitalize">Email</option>
                                    <option value="mobile" style="text-transform:capitalize">Mobile</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-3 xsw_50 no_pad">
                                <select id="sortType" class="form-control" name="sort_type">
                                    <option value="ASC">Ascending</option>
                                    <option value="DESC">Descending</option>
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
                <td class="text-right wmd_30">
                    <a class="btn btn-success btn-xs xsw_33" href="{{ url ('institute/create') }}"><i class="fa fa-plus"></i> New</a>
                    <?php if (has_user_access('institute_delete')) : ?>
                        <button type="button" class="btn btn-danger btn-xs xsw_33" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show Users List-->
{!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmList','name'=>'frmList']) !!}
<div id="ajax_content">
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr>
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Company Name</th>
                    <th>Business Type</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                    <th class="text-center">
                        <div class="checkbox">
                            <label><input type="checkbox" id="check_all"value="all"></label>
                        </div>
                    </th>
                </tr>
                <?php $sl = 1; ?>
                @foreach ($dataset as $data)
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->businessType($data->business_type_id) }}</td>
                    <td>{{ $data->email }}</td>
                    <?php if ($data->status == 0) : ?>
                        <?php if (has_user_access('institute_status')) : ?>
                            <td class="text-center" ><span title="Activate Institute" onclick = "make_institute_active(<?= $data->id ?>)" class="btn btn-warning btn-xs">Inactive</span></td>
                        <?php else : ?>
                            <td class="text-center" ><span class="label label-warning label-xs">Inactive</span></td>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if (has_user_access('institute_status')) : ?>
                            <td class="text-center" ><span title="Deactivate Institute" onclick = "make_institute_inactive(<?= $data->id ?>)" class="btn btn-success btn-xs">Active</span></td>
                        <?php else : ?>
                            <td class="text-center" ><span class="label label-success label-xs">Active</span></td>
                        <?php endif; ?>
                    <?php endif; ?>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="institute/{{ $data->_key }}/edit"><i class="fa fa-edit"></i> Edit</a>
                        <a class="btn btn-primary btn-xs" href="institute/{{ $data->_key }}"><i class="fa fa-eye"></i> View</a>
                        <a class="btn btn-warning btn-xs" href="institute/{{ $data->_key }}/access"><i class="fa fa-fw fa-wrench"></i> Access Control</a>
                    </td>
                    <td class="text-center">
                        <?php if ($data->is_fixed == 0) : ?>
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                        <?php endif; ?>
                    </td>
                    <?php $sl++; ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function () {
        $("#Del_btn").click(function () {
            var _url = "{{ URL::to('delete-institute') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");
            if (_rc == true) {
                $.post(_url, _form.serialize(), function (data) {
                    if (data.success === true) {
                        $('#ajaxMessage').removeClass('alert-danger').addClass('alert-success').show().show();
                        $('#ajaxMessage').html(data.message);
                    } else {
                        $('#ajaxMessage').removeClass('alert-success').addClass('alert-danger').show();
                        $('#ajaxMessage').html(data.message);
                    }
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }, "json");
            }
        })
    });

    function make_institute_active(id) {
        var _url = "{{ URL::to('institute-active') }}/" + id;
        var _rc = confirm("Are you sure about this action? This cannot be undone!");
        if (_rc == true) {
            $.get(_url, function (data) {
                if (data.success === true) {
                    $('#ajaxMessage').removeClass('alert-danger').addClass('alert-success').show().show();
                    $('#ajaxMessage').html(data.message);
                } else {
                    $('#ajaxMessage').removeClass('alert-success').addClass('alert-danger').show();
                    $('#ajaxMessage').html(data.message);
                }
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }, "json");
        }
    }

    function make_institute_inactive(id) {
        var _url = "{{ URL::to('institute-inactive') }}/" + id;
        var _rc = confirm("Are you sure about this action? This cannot be undone!");
        if (_rc == true) {
            $.get(_url, function (data) {
                if (data.success === true) {
                    $('#ajaxMessage').removeClass('alert-danger').addClass('alert-success').show().show();
                    $('#ajaxMessage').html(data.message);
                } else {
                    $('#ajaxMessage').removeClass('alert-success').addClass('alert-danger').show();
                    $('#ajaxMessage').html(data.message);
                }
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }, "json");
        }
    }
</script>
@endsection