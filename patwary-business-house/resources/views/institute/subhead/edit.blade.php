@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Subhead Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li><a href="{{ url('/subhead') }}">Subhead</a> <span class="fa fa-angle-right"></span></li>
            <li>Form</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Update SubHead Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'PUT', 'url' => 'subhead/'.$data->id, 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Head Name</label>
            <div class="col-md-6">
                <select id="ledger_head_id" class="form-control" name="head_id">
                    <option value="">Select Head</option>
                    @foreach($head_set as $hs)
                    <?php $sel = ($hs->id == $data->head_id) ? 'selected="selected"' : ''; ?>
                    <option value="{{$hs->id}}" {{$sel}}>{{$hs->name }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('ledger_head_id') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{$data->name}}">
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="button" id="reset_from" class="btn btn-info xsw_50">Reset</button>
                <input type="submit" class="btn btn-primary xsw_50" name="btnSave" value="Update">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection