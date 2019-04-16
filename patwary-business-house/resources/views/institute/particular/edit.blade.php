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
        <h3 class="panel-title">Update Particular Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'PUT', 'url' => 'particulars/'.$data->id, 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <label for="subhead_id" class="col-md-4 control-label">Sub Head Name</label>
            <div class="col-md-6">
                <select id="subhead_id" class="form-control" name="subhead_id">
                    <option value="">Select Sub Head</option>
                    @foreach($heads as $hs)
                    <?php $sel = ($hs->id == $data->subhead_id) ? 'selected="selected"' : ''; ?>
                    <option value="{{$hs->id}}" {{$sel}}>{{$hs->name }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('subhead_id') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{$data->name}}">
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="company_name" class="col-md-4 control-label">Company</label>
            <div class="col-md-6">
                <input id="company_name" type="text" class="form-control" name="company_name" value="{{$data->company_name}}">
                <small class="text-danger">{{ $errors->first('company_name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="col-md-4 control-label">Mobile No</label>
            <div class="col-md-6">
                <input type="text" id="mobile" class="form-control" name="mobile" value="{{$data->mobile}}">
                <small class="text-danger">{{ $errors->first('mobile') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="account_type" class="col-md-4 control-label">Account Type</label>
            <div class="col-md-6">
                <select name="account_type" id="account_type" class="form-control">
                    <option value="">Select Account Type</option>
                    <?php foreach (bank_account_type_list() as $type): ?>
                        <option value="{{ $type }}" @if($data->account_type == $type) {{ 'selected' }} @endif>{{ $type }}</option>
                    <?php endforeach ?>
                </select>
                <small class="text-danger">{{ $errors->first('account_type') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="cc_loan_amount" class="col-md-4 control-label">CC Loan Amount</label>
            <div class="col-md-6">
                <input type="number" id="cc_loan_amount" class="form-control" name="cc_loan_amount" value="{{ $data->cc_loan_amount }}">
                <small class="text-danger">{{ $errors->first('cc_loan_amount') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="col-md-4 control-label">Address</label>
            <div class="col-md-6">
                <textarea id="address" class="form-control" name="address">{{$data->address}}</textarea>
                <small class="text-danger">{{ $errors->first('address') }}</small>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="button" id="reset_from" class="btn btn-info xsw_50">Reset</button>
                <input type="submit" class="btn btn-primary xsw_50" name="btnSave" value="Update">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection