@extends('admin.layouts.column1')

@section('breadcrumbs')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 hidden-xs text-center">
        <h2 class="page-title">Company Information</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-10 no_pad">
        <ul class="text-right no_mrgn no_pad">
            <li><a href="{{ url('/home') }}">Dashboard</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="{{ url('/institute') }}">Company</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="clearfix">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Company Information</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'institute', 'id' => 'frm_institute'  , 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                <label for="business_type" class="col-md-4 control-label">Business Type</label>
                <div class="col-md-6">
                    <select name="business_type" id="input" class="form-control" required>
                        <option value="">Select Business Type</option>
                        @foreach($business_type as $bs)
                        <option value="{{ $bs->id }}">{{ $bs->business_type }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('business_type') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Company Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name">
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 text-right">Address</label>
                <div class="col-md-6">
                    <textarea class="form-control" name="address"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-4 control-label">Phone No</label>
                <div class="col-md-6">
                    <input  type="text" class="form-control" name="phone">
                </div>
            </div>
            <div class="form-group">
                <label for="mobile" class="col-md-4 control-label">Mobile No</label>
                <div class="col-md-6">
                    <input  type="number" class="form-control" name="mobile">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-4 control-label">Email Address</label>
                <div class="col-md-6">
                    <input  type="email" class="form-control" name="email" required>
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="post" class="col-md-4 control-label">Website</label>
                <div class="col-md-6">
                    <input  type="text" class="form-control" name="website">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" id="reset_from" class="btn btn-info xsw_50">Reset</button>
                    <button type="submit" class="btn btn-primary xsw_50">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#reset_from").click(function () {
        var _form = $("#frm_institute");
        _form[0].reset();
    });
</script>
@endsection