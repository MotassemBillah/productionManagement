@extends('admin.layouts.column2')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Packaging Category Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/packaging/category') }}">Category</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>
    </div>
</div>

<div class="clearfix">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Update Category Information</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'packaging/category/'.$data->id, 'class' => 'form-horizontal']) !!}
            {{ csrf_field() }}
            <div class="form-group">
                <label  class="col-md-4 control-label">Category Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="cat_name" value="{{ $data->name }}" required>
                    <small class="text-danger">{{ $errors->first('cat_name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Category Unit</label>
                <div class="col-md-6">
                    <select name="cat_unit" id="inputCat_unit" class="form-control" required="required">
                        <option value="">Select Category Unit</option>
                        <?php foreach (unit_list() as $key => $unit): ?>
                            <option value="{{ $key }}" @if($data->unit == $key) {{ 'selected' }} @endif>{{ $unit }}</option>
                        <?php endforeach ?>
                    </select>
                    <small class="text-danger">{{ $errors->first('cat_unit') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Category Description</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="cat_description" required value="{{ $data->description }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" class="btn btn-info">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection