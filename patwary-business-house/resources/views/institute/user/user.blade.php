@extends('admin.layouts.column1')
<?php

use App\Models\User;
?>

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">User Profile</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/user') }}">User</a> <i class="fa fa-angle-right"></i></li>
            <li>Profile</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="user_information">
    <div class="row">
        <div class="col-md-4">
            <img alt="Image goes here" class="img-responsive thumbnail" src="{{asset('img/no_photo.gif')}}">
        </div>

        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">User Profile Information</h3>
                </div>
                <div class="panel-body no_pad">
                    <table class="table table-bordered no_mrgn">
                        <thead>
                            <tr>
                                <th>Name:</th>
                                <th>{{ $user->name }}</th>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <th>{{ $user->email }}</th>
                            </tr>
                            <tr>
                                <th>Language:</th>
                                <th>{{ ($user->locale == 'bn') ? 'Bangla' : 'English' }}</th>
                            </tr>
                            <tr>
                                <th>Joined:</th>
                                <th>{{ $user->created_at }}</th>
                            </tr>
                            <tr>
                                <th>Created By:</th>
                                <th><?php echo User::get_user_info_by_id($user->created_by)->name ?></th>
                            </tr>
                            <tr>
                                <th>Last Update:</th>
                                <th>{{ $user->updated_at }}</th>
                            </tr>
                            <tr>
                                <th>Updated By:</th>
                                <th><?php
                                    if ($user->updated_by) {
                                        echo User::get_user_info_by_id($user->updated_by)->name;
                                    }
                                    ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="mb_10 clearfix">
                <div class="text-center">
                    <a href="{{ url('/user') }}/{{ $user->_key }}/edit" class="btn btn-primary xsw_100">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection