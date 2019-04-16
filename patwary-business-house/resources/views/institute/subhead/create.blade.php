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
        <h3 class="panel-title">Enter SubHead Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'POST', 'url' => 'subhead', 'id' => 'frm_subhead'  , 'class' => 'form-horizontal']) !!}
        @if( is_Admin() )
        <div class="form-group">
            <label for="InstituteList" class="col-md-4 control-label">Company</label>
            <div class="col-md-6">
                <select name="institute_id" id="InstituteList" class="form-control" required>
                    <option value="">Select Company</option>
                    @foreach ($insList as $institute)
                    <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('institute_id') }}</small>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="head" class="col-md-4 control-label">Head Name</label>
            <div class="col-md-6">
                <select id="head" class="form-control" name="head_id" required>
                    @if ( !is_Admin() )
                    <option value="">Select Head</option>
                    @foreach($heads as $head)
                    <option value="{{$head->id}}">{{$head->name}}</option>
                    @endforeach
                    @else
                    <option value="">Select Head</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6 input_fields_wrap">
                <div><input type="text" class="form-control" name="name[]" required></div>
                <button class="add_field_button form-control">Add More <i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="button" id="reset_from" class="btn btn-info xsw_50">Reset</button>
                <input type="submit" class="btn btn-primary xsw_50" name="btnSave" value="Save">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#InstituteList", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('institute/head') }}",
                type: "post",
                data: {'institute': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    //enable("#subhead");
                    $('#head').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="text-center"><input type="text" class="duplicate_field" name="name[]" required/>&nbsp;<a href="#" class="remove_field btn btn-danger btn-sm">Remove </a></div>'); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })

    });

    $("#reset_from").click(function () {
        var _form = $("#frm_subhead");
        _form[0].reset();
    });
</script>
@endsection