@extends('layouts.app')

@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Create New Product Category</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> New Category</span></li>
        </ul>                            
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Product Category Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'category', 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }} 
            <div class="form-group">
                <label  class="col-md-4 control-label">Category Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="cat_name" required>
                    <small class="text-danger">{{ $errors->first('cat_name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Category Unit</label>
                <div class="col-md-6">
                    <select name="cat_unit" id="inputCat_unit" class="form-control" required="required">
                        <option value="">Select Category Unit</option>
                        <?php foreach (unit_list() as $key => $unit): ?>
                            <option value="{{ $key }}">{{ $unit }}</option>
                        <?php endforeach ?>
                    </select>
                    <small class="text-danger">{{ $errors->first('cat_unit') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Category Description</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="Raw Material" name="cat_description" required>
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