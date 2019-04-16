@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Party Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/rental/party') }}">Party</a> <i class="fa fa-angle-right"></i></li>
        </ul>
    </div>
</div>

<div class="clearfix">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Party Information</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'rental/party', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="form-group">
                <label  class="col-md-4 control-label">Rental Date</label>
                <div class="col-md-6">
                    <input type="text" class="form-control pickdate" name="rental_date" value="<?php echo date('d-m-Y'); ?>" required readonly>
                    <small class="text-danger">{{ $errors->first('rental_date') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="building_id" class="col-md-4 control-label">Building</label>
                <div class="col-md-6">
                    <select name="building_id" id="buildin_id" class="form-control" required="required">
                        <option value="">Select Building</option>
                        <?php foreach ($buildings as $building): ?>
                            <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                        <?php endforeach ?>
                    </select>
                    <small class="text-danger">{{ $errors->first('building_id') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="floor_id" class="col-md-4 control-label">Floor</label>
                <div class="col-md-6">
                    <select name="floor_id" id="floor_id" class="form-control" required="required">
                        <option value="">Select Floor</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('floor_id') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="flat_id" class="col-md-4 control-label">Flat</label>
                <div class="col-md-6">
                    <select name="flat_id" id="flat_id" class="form-control" required="required">
                        <option value="">Select Flat</option>
                    </select>
                    <small class="text-danger">{{ $errors->first('flat_id') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Monthly Rent</label>
                <div class="col-md-6">
                    <input type="number" class="form-control" name="monthly_rent" required>
                    <small class="text-danger">{{ $errors->first('monthly_rent') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Party Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="party_name" required>
                    <small class="text-danger">{{ $errors->first('party_name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Mobile</label>
                <div class="col-md-6">
                    <input type="number" class="form-control" name="mobile_no" required>
                    <small class="text-danger">{{ $errors->first('mobile_no') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Address</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="address">
                    <small class="text-danger">{{ $errors->first('address') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Description</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="description">
                    <small class="text-danger">{{ $errors->first('description') }}</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" class="btn btn-info">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("change", "#buildin_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('rental/building/floor') }}",
                type: "post",
                data: {'id': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#floor_id').html(data);
                    $('#flat_id').empty();
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#floor_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('rental/floor/flat') }}",
                type: "post",
                data: {'id': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#flat_id').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

    });

</script>

@endsection