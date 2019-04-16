@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv/category') }}">Category</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Update Category Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'PUT', 'url' => 'inv/category/'.$data->id, 'class' => 'form-horizontal']) !!} 
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-md-4 control-label" for="business_type_id">Business Type</label>
            <div class="col-md-6">
                <select class="form-control" id="business_type_id" name="business_type_id" required>
                    <option value="">Select</option>
                    @foreach ($business_types as $btype)
                    <option value="{{ $btype->id }}" <?php if ($btype->id == $data->business_type_id) echo ' selected'; ?>>{{ $btype->business_type }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('business_type_id') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="type">Category Type</label>
            <div class="col-md-6">
                <select class="form-control" id="type" name="type" required>
                    <option value="">Select</option>
                    @foreach ($types as $tkey => $tval)
                    <option value="{{ $tkey }}" <?php if ($tkey == $data->type) echo ' selected'; ?>>{{ $tval }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('type') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Category Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" required>
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="unit">Category Unit</label>
            <div class="col-md-6">
                <select class="form-control" id="unit" name="unit" required>
                    <option value="">Select</option>
                    @foreach (unit_list() as $ukey => $uval)
                    <option value="{{ $ukey }}" <?php if ($ukey == $data->unit) echo ' selected'; ?>>{{ $uval }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('unit') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="description">Category Description</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="description" name="description" value="{{ $data->description }}">
            </div>
        </div>
        <div class="col-md-8 col-md-offset-4">
            <button type="button" class="btn btn-info">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
        {!! Form::close() !!} 
    </div>
</div>
@endsection