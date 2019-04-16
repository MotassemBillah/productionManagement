@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">User Password</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/user') }}">User</a> <i class="fa fa-angle-right"></i></li>
            <li>Password</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update Password</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'url' => 'password/update', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Old Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control"  name="old_password" required>
                        <small class="text-danger">{{ $errors->first('old_password') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">New Password</label>
                    <div class="col-md-6">
                        <input  type="password" class="form-control" name="password"  required>
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">Retype New Password</label>
                    <div class="col-md-6">
                        <input  type="password" class="form-control" name="password_confirmation"  required>
                        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection