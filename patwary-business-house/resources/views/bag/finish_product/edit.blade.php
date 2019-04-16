@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Finish Product</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Product</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Product Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'finishproduct/'.$data->id, 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <div class="form-group">
                <label for="finishCategory" class="col-md-4 control-label">Finish Category</label>
                <div class="col-md-6">
                    <select name="finish_category_id" id="finishCategory" class="form-control" required="required">
                        <option value="">Select Finish Category</option>
                        @foreach($category->all() as $cat)
                        <option value="{{ $cat->id }}" @if($cat->id==$data->finish_category_id) {{ "selected" }} @endif >{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="name"  class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="rawUnit"  class="col-md-4 control-label">Unit</label>
                <div class="col-md-6">
                    <select name="unit" id="rawUnit" class="form-control" required="required">
                        <option value="">Select Unit</option>
                        @foreach(unit_list() as $unit)
                        <option value="{{ $unit }}" @if($unit==$data->unit) {{ "selected" }} @endif>{{ $unit }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('unit') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="size"  class="col-md-4 control-label">Size</label>
                <div class="col-md-6">
                    <input id="size" type="text" class="form-control" name="size" value="{{ $data->size }}">
                    <small class="text-danger">{{ $errors->first('size') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="buy_price"  class="col-md-4 control-label">Sale Price</label>
                <div class="col-md-6">
                    <input id="buy_price" type="number" class="form-control" step="any" min="0" name="sale_price" value="{{ $data->sale_price }}">
                    <small class="text-danger">{{ $errors->first('buy_price') }}</small>
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