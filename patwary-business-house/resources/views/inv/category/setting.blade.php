@extends('admin.layouts.column2')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">{{$breadcrumb_title}}</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/inv') }}">Inventory</a> <i class="fa fa-angle-right"></i></li>
            <li>Category Setting</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div id="print_area">
    <div id="ajax_content">
        {{ Form::open(array('url' => 'inv/category/setting')) }}
        <input type="hidden" name="model_name" value="{{$model}}">
        <div class="table-responsive">
            <table class="table table-bordered tbl_thin" id="check">
                <tr class="bg-info" id="r_checkAll">
                    <th class="text-center" style="width:4%;">SL</th>
                    <th class="text-center" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                    <th>Label Name</th>
                </tr>
                <?php
                $counter = 0;
                foreach ($labels as $lkey => $lval):
                    $counter++;
                    ?>
                    <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
                        <td class="text-center">{{ $counter }}</td>
                        <td class="text-center"><input type="checkbox" name="data[{{$lkey}}]" value="{{ $lval }}"></td>
                        <td>{{ $lval }}</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="bg-info">
                    <th class="text-center" colspan="3">
                        <input type="submit" class="btn btn-primary btn-xs xsw_100" id="submitSetting" name="submitSetting" value="Save" style="width: 33%">
                    </th>
                </tr>
            </table>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", "#search", function () {
            var _url = "{{ URL::to('inv/category/search') }}";
            var _form = $("#frmSearch");

            $.ajax({
                url: _url,
                type: "post",
                data: _form.serialize(),
                success: function (data) {
                    $('#ajax_content').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", "#Del_btn", function () {
            var _url = "{{ URL::to('inv/category/delete') }}";
            var _form = $("#frmList");
            var _rc = confirm("Are you sure about this action? This cannot be undone!");

            if (_rc == true) {
                $.post(_url, _form.serialize(), function (resp) {
                    if (resp.success === true) {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'success'});
                        $("#search").trigger("click");
                    } else {
                        $('#ajaxMessage').showAjaxMessage({html: resp.message, type: 'error'});
                    }
                }, "json");
            }
        });
    });
</script>
@endsection