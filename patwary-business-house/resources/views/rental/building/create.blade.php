@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Building Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/rental/building') }}">Building</a> <i class="fa fa-angle-right"></i></li>
        </ul>
    </div>
</div>

<div class="clearfix">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Building Information</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'rental/building', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="buildingType" class="col-md-4 control-label">Building Type</label>
                <div class="col-md-6">
                    <select name="building_type" id="buildingType" class="form-control" required="required">
                        <option value="">Select Building Type</option>
                        <?php foreach (building_type_list() as $type): ?>
                            <option value="{{ $type }}">{{ $type }}</option>
                        <?php endforeach ?>
                    </select>
                    <small class="text-danger">{{ $errors->first('building_type') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Building Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="building_name" required>
                    <small class="text-danger">{{ $errors->first('building_name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Building No</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="building_no" required>
                    <small class="text-danger">{{ $errors->first('building_no') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-md-4 control-label">Mobile No</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="mobile_no" required>
                    <small class="text-danger">{{ $errors->first('mobile_no') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-4 control-label">Address</label>
                <div class="col-md-6">
                    <textarea id="address" name="address" class="form-control"></textarea>
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

@endsection