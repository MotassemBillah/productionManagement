@extends('admin.layouts.column2')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Flat List</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li>Flat</li>
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
                                <select class="form-control" id="building_id" name="building_id" required>
                                    <option value="">Select Building</option>
                                    @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-3 no_pad">                            
                                <select class="form-control" id="floor_id" name="floor_id" required>
                                    <option value="">Select Floor</option>
                                </select>
                            </div>
                            <input type="text" name="search" id="q" class="form-control" placeholder="search" size="30"/>
                            <button type="button" id="search" class="btn btn-info">Search</button>
                            <button type="button" id="clear_from" class="btn btn-primary">Clear</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </td>
                <td class="text-right wmd_30" style="">
                    <a href="{{ url ('rental/flat/create') }}"><button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> New</button></a>
                    <?php if (has_user_access('rental_flat_delete')) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="Del_btn" disabled><i class="fa fa-trash-o"></i> Delete</button>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Show Product Category List-->
{!! Form::open(['method' => 'POST', 'id'=>'frmList','name'=>'frmList']) !!}
<div id="ajax_content">
    @if(!empty($dataset) && count($dataset) > 0)
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Building Name</th>
                    <th>Floor Name</th>
                    <th>Flat Name</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                    <?php if (has_user_access('rental_flat_delete')) : ?>
                        <th class="text-center">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all"value="all"></label>
                            </div>
                        </th>
                    <?php endif; ?>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php $counter++; ?>
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ $data->building->building_name }}</td>
                    <td>{{ $data->floor->floor_name }}</td>
                    <td>{{ $data->flat_name }}</td>
                    <td>{{ $data->description }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="flat/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <?php if (has_user_access('rental_flat_delete')) : ?>
                        <td class="text-center">
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center hip">
        {{ $dataset->render() }}
    </div>
    @else
    <div class="alert alert-info">No records found.</div>
    @endif
</div>

{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("change", "#building_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('rental/building/floor') }}",
                type: "post",
                data: {'id': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#floor_id').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $("#search").click(function () {
            var _url = "{{ URL::to('rental/flat/search') }}";
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

        $("#Del_btn").click(function () {
            var _url = "{{ URL::to('rental/flat/delete') }}";
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

        })

    });
</script>

@endsection