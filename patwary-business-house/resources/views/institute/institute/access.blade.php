@extends('admin.layouts.column1')
<?php

use App\Models\Institute;

$access_items = institute_access_items();
//pr(allAccessItems(TRUE));
$active_access_items = Institute::get_institute_permission_by_id($data->id);
$active_access_item_list = !empty($active_access_items) ? $active_access_items : [];
$accitems = "access_items_";
?>
@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Institute Permissions</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/institute') }}">Company</a> <i class="fa fa-angle-right"></i></li>
            <li>Permissions</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="customer_info">
    <div class="clearfix">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Institute Access List for <strong><u>{{ $data->name }}</u></strong>
                    <label class="pull-right" for="select_all" style="font-size: 14px;margin: 0;"><input type="checkbox" id="select_all" value=""style="margin: -1px 0 0;vertical-align: middle;"> <span id="txtVal">Select All</span></label>
                </h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'url' => 'institute/acess/update', 'class' => 'form-horizontal']) !!}
                {{ csrf_field() }}
                <div class="user_access">
                    <input type="hidden" name="institute_id" value="{{ $data->id }}">
                    <div class="access_item_list" id="check">
                        <div class="row clearfix">
                            @foreach ( $access_items as $key => $item)
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <label class="" style="margin: 0">
                                                <input type="checkbox" class="title_chkbox" id="title_chkbox_{{ $key }}" name="access[{{ $key }}]" value="{{ $item }}" rel="{{ $key }}" <?php if (array_key_exists($key, $active_access_item_list)) echo " checked"; ?> style="margin:-2px 3px 0 0;vertical-align:middle;"> {{ $item }}
                                            </label>
                                            <label class="pull-right" style="font-size: 14px;margin: 0;"><span class="icon_caret_in_out fa fa-2x fa-caret-down" rel="{{ $key }}"></span></label>
                                        </h3>
                                    </div>
                                    <div class="panel-body" id="panel_for_{{ $key }}">
                                        <ul class="list-group no_mrgn" id="access_list_{{ $key }}">
                                            @foreach ( $key() as $_key => $_item)
                                            <li style="width: 24.5%; display: inline-block;" class="list-group-item access_item_sub <?php if (array_key_exists($_key, $active_access_item_list)) echo " active_access_item_sub"; ?>">
                                                <label class="no_mrgn" for="access_{{ $_key }}">
                                                    <input type="checkbox" class="single_chkbox" id="access_{{ $_key }}" name="access[{{ $_key }}]" value="{{ $_item }}"  rel="{{ $key }}" <?php if (array_key_exists($_key, $active_access_item_list)) echo " checked"; ?> style="margin:-2px 3px 0 0;vertical-align:middle;"> {{ $_item }}
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-4 col-md-offset-4 text-center">
                            <input type="submit" class="btn btn-primary btn-block" id="btnSavePermission" name="btnSavePermission" value="Save">
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#select_all", function () {
            var _elm = $("#check input[type='checkbox']");
            if ($(this).is(":checked")) {
                $("#txtVal").html("Unselect All");
                $(_elm).prop('checked', true);
                $("#check .panel-body").slideDown(200);
                $(".icon_caret_in_out").removeClass('fa-caret-left').addClass('fa-caret-down');
                $("#check li").removeClass("active_access_item");
                $("#check li").removeClass("active_access_item_sub");
                $("#check li").addClass("active_access_item");
            } else {
                $("#txtVal").html("Select All");
                $(_elm).prop('checked', false);
                //$(_elm).closest('li').removeClass('active_access_item');
                $("#check li").removeClass("active_access_item");
                $("#check li").removeClass("active_access_item_sub");
            }
        });

        $(document).on("change", ".title_chkbox", function () {
            var _rel = $(this).attr('rel');
            if ($(this).is(":checked")) {
                $("#access_list_" + _rel + " input[type='checkbox']").prop('checked', true);
                $("#access_list_" + _rel + " input[type='checkbox']").closest('li').addClass('active_access_item');
            } else {
                $("#access_list_" + _rel + " input[type='checkbox']").prop('checked', false);
                $("#access_list_" + _rel + " input[type='checkbox']").closest('li').removeClass('active_access_item');
            }
        });

        $(document).on("change", ".single_chkbox", function () {
            var _rel = $(this).attr('rel');
            if ($(this).is(":checked")) {
                $(this).prop('checked', true);
                $(this).closest('li').addClass('active_access_item');
            } else {
                $(this).prop('checked', false);
                $(this).closest('li').removeClass('active_access_item');
            }

            if ($("#access_list_" + _rel + " input[type='checkbox']:checked").length > 0) {
                $("#title_chkbox_" + _rel).prop('checked', true);
            } else {
                $("#title_chkbox_" + _rel).prop('checked', false);
            }
        });

        $(document).on("click", ".icon_caret_in_out", function () {
            var _rel = $(this).attr('rel');
            if ($("#panel_for_" + _rel).is(":visible")) {
                $("#panel_for_" + _rel).slideUp(200);
                $(this).removeClass('fa-caret-down').addClass('fa-caret-left');
            } else {
                $("#panel_for_" + _rel).slideDown(200);
                $(this).removeClass('fa-caret-left').addClass('fa-caret-down');
            }
        });
    });
</script>
@endsection