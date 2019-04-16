@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Particular Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <span class="fa fa-angle-right"></span></li>
            <li><a href="{{ url('/particulars') }}">Particular</a> <span class="fa fa-angle-right"></span></li>
            <li>Form</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Enter Particular Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'POST', 'url' => 'particulars', 'id' => 'frm_subhead'  , 'class' => 'form-horizontal']) !!}
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
            <label for="head" class="col-md-4 control-label">Sub Head Name</label>
            <div class="col-md-6">
                <select id="head" class="form-control" name="subhead_id" required>
                    @if ( !is_Admin() )
                    <option value="">Select Sub Head</option>
                    @foreach($subheads as $subhead)
                    <option value="{{$subhead->id}}">{{$subhead->name}}</option>
                    @endforeach
                    @else
                    <option value="">Select Sub Head</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required>
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="company_name" class="col-md-4 control-label">Company</label>
            <div class="col-md-6">
                <input id="company_name" type="text" class="form-control" name="company_name">
                <small class="text-danger">{{ $errors->first('company_name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="col-md-4 control-label">Mobile No</label>
            <div class="col-md-6">
                <input type="text" id="mobile" class="form-control" name="mobile">
                <small class="text-danger">{{ $errors->first('mobile') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="account_type" class="col-md-4 control-label">Account Type</label>
            <div class="col-md-6">
                <select name="account_type" id="account_type" class="form-control">
                    <option value="">Select Account Type</option>
                    <?php foreach (bank_account_type_list() as $type): ?>
                        <option value="{{ $type }}">{{ $type }}</option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">{{ $errors->first('account_type') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="cc_loan_amount" class="col-md-4 control-label">CC Loan Amount</label>
            <div class="col-md-6">
                <input type="number" id="cc_loan_amount" class="form-control" name="cc_loan_amount">
                <small class="text-danger">{{ $errors->first('cc_loan_amount') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="col-md-4 control-label">Address</label>
            <div class="col-md-6">
                <textarea id="address" class="form-control" name="address"></textarea>
                <small class="text-danger">{{ $errors->first('address') }}</small>
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
                url: "{{ URL::to('institute/subhead') }}",
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