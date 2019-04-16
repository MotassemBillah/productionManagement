@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">User Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/user') }}">User</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row customer_info">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Update User Information</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'PUT', 'url' => 'user/'.$user->id, 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">User Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  value = "{{ $user->name }}" name="name" required>
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">Email Address</label>
                    <div class="col-md-6">
                        <input  type="email" class="form-control" value = "{{ $user->email }}" name="email"  required>
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="language" class="col-md-4 control-label">Language</label>
                    <div class="col-md-6">
                        <select id="language" class="form-control" name="locale">
                            <option value="">Select Language</option>
                            <option value="bn" @if($user->locale == 'bn') {{ ' selected' }} @endif>Bangla</option>
                            <option value="en" @if($user->locale == 'en') {{ ' selected' }} @endif>English</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-info xsw_50">Reset</button>
                        <button type="submit" class="btn btn-primary xsw_50">Update</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection