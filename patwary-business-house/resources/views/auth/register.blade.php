<?php

use App\Models\Institute;

$institutes = Institute::where('status', 1)->get();
?>
@extends('admin.layouts.column1')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('/en/site/clear_cache')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">User Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/user') }}">User</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>
    </div>
</div>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter User Informaiton</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                @if( Auth::user()->type == 'admin' )
                <div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">User Type</label>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="user_type" id="AdminUser" class="user_type" value="admin">
                                Admin
                            </label>
                            <label>
                                <input type="radio" name="user_type" id="InstituteUser" class="user_type" value="institute">
                                Institute
                            </label>
                        </div>
                        @if ($errors->has('user_type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_type') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('institute_id') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Branch</label>
                    <div class="col-md-6">
                        <select name="institute_id" id="InstituteList" class="form-control" disabled>
                            <option value="">Select User Type First</option>
                        </select>
                        @if ($errors->has('institute_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('institute_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="form-group {{ $errors->has('user_role_id') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">User Role</label>
                    <div class="col-md-6">
                        <select name="user_role_id" id="input" class="form-control" required>
                            <option value="">Select User Role</option>
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                            <option value="3">Editor</option>
                        </select>
                        @if ($errors->has('user_role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_role_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("change", ".user_type", function () {
        var _type = $(".user_type:checked").val();
        $.ajax({
            url: "{{ URL::to('institute/type') }}",
            type: "post",
            data: {'type': _type, '_token': '{{ csrf_token() }}'},
            success: function (data) {
                enable("#InstituteList");
                $('#InstituteList').html(data);
            },
            error: function (xhr, status) {
                alert('There is some error.Try after some time.');
            }
        });


    });
</script>

@endsection