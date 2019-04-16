@extends('admin.layouts.column1')
<?php

use App\Models\User;

$institute_id = $user->institute_id;
//pr($institute_id);
$access_items = user_access_item_by_institute($institute_id);
$active_access_items = User::get_user_permisstion_by_id($user->id);
$active_access_item_list = !empty($active_access_items) ? $active_access_items : [];
?>
@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">User Permissions</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/user') }}">User</a> <i class="fa fa-angle-right"></i></li>
            <li>Permissions</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="customer_info">
    <div class="clearfix">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    User Access List for <strong><u>{{ $user->name }}</u></strong>
                    <label class="pull-right" for="select_all" style="font-size: 14px;margin: 0;"><input type="checkbox" id="select_all" value=""style="margin: -1px 0 0;vertical-align: middle;"> <span id="txtVal">Select All</span></label>
                </h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'url' => 'user/acess/update', 'class' => 'form-horizontal']) !!}
                <div class="user_access">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="access_item_list" id="check">
                        <ul id="access_list" class="list-group">
                            @foreach ( $access_items as $key => $item)
                            <li class="list-group-item access_item <?php if (array_key_exists($key, $active_access_item_list)) echo "active_access_item"; ?>">
                                <label>
                                    <input type="checkbox" name="access[{{ $key }}]" value="{{ $item }}" <?php if (array_key_exists($key, $active_access_item_list)) echo "checked"; ?>> {{ $item }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary xsw_100">Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($("#access_list input[type='checkbox']:checked").length > 0) {
            $("#check_all").prop('checked', true);
        }

        $(document).on("change", "#check input[type='checkbox']", function () {
            if (this.checked) {
                $(this).closest("li").not("#r_checkAll").addClass("active_access_item");
            } else {
                $(this).closest("li").removeClass("active_access_item");
            }
        });

        $(document).on("change", "#select_all", function () {
            if ($(this).is(":checked")) {
                $("#txtVal").html("Unselect All");
                $("#check input[type='checkbox']").prop('checked', true);
                $("#check li").not("#r_checkAll").addClass("active_access_item");
            } else {
                $("#txtVal").html("Select All");
                $("#check input[type='checkbox']").prop('checked', false);
                $("#check li").removeClass("active_access_item");
            }
        });
    });
</script>
@endsection