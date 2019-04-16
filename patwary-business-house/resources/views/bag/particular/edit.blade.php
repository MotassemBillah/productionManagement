@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?php echo url('view-clear'); ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Particular </h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Particular</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Particular Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'particular/'.$data->id, 'id' => 'frmParticular'  , 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <div class="form-group">
                <label for="head" class="col-md-4 control-label">Sub Head Name</label>
                <div class="col-md-6">
                    <select id="subhead" class="form-control" name="subhead" required>
                        <option value="">Select Sub Head</option>
                        @foreach($subhead_set as $subhead)
                        <option value="{{$subhead->id}}" @if( $data->subhead_id == $subhead->id) {{ 'selected' }}@endif>{{$subhead->name}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('subhead') }}</small>
                </div> 
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <label for="company_name" class="col-md-4 control-label">Company</label>
                <div class="col-md-6">
                    <input id="company_name" type="text" class="form-control" name="company_name" value="{{ $data->company_name }}">
                    <small class="text-danger">{{ $errors->first('company_name') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <label for="mobile" class="col-md-4 control-label">Mobile No</label>
                <div class="col-md-6">
                    <input type="text" id="mobile" class="form-control" name="mobile" value="{{ $data->mobile }}">
                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <label for="commission" class="col-md-4 control-label">Broker Commission</label>
                <div class="col-md-6">
                    <input type="number" id="commission" class="form-control" name="commission" value="{{ $data->commission }}" min="0" step="any">
                    <small class="text-danger">{{ $errors->first('commission') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <label for="address" class="col-md-4 control-label">Address</label>
                <div class="col-md-6">                    
                    <textarea id="address" class="form-control" name="address">{{ $data->address }}</textarea>
                    <small class="text-danger">{{ $errors->first('address') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                    <input type="submit" class="btn btn-primary" name="btnSave" value="Update">
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!} 
@endsection