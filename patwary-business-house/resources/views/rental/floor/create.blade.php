@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Floor Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/rental/floor') }}">Floor</a> <i class="fa fa-angle-right"></i></li>
        </ul>
    </div>
</div>

<div class="clearfix">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Floor Information</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'rental/floor', 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
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
                <label  class="col-md-4 control-label">Floor Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="floor_name" required>
                    <small class="text-danger">{{ $errors->first('floor_name') }}</small>
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

@endsection