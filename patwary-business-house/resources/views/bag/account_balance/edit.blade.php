@extends('layouts.app')

@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Bank Account</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Bank</span></li>
        </ul>                            
    </div>
</div>


<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Bank Account Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'bank-account/'.$data->id, 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <div class="form-group">
                <label for="bank_id" class="col-md-4 control-label">Bank Name</label>
                <div class="col-md-6">
                    <select id="bank_id" class="form-control" name="bank_id" required>
                        <option value="">Select Bank</option>                  
                        @foreach($banks as $bank)
                        <option value="{{$bank->id}}" @if($bank->id == $data->bank_id) {{ 'selected' }} @endif>{{$bank->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('bank_id') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="manager_no" class="col-md-4 control-label">Manager Mobile</label>
                <div class="col-md-6">
                    <input id="manager_no" type="number" class="form-control" name="manager_no" value="{{ $data->manager_mobile }}">
                    <small class="text-danger">{{ $errors->first('manager_no') }}</small>
                </div>
            </div> 
            <div class="form-group">
                <label for="account_name" class="col-md-4 control-label">Account Name</label>
                <div class="col-md-6">
                    <input id="account_name" type="text" class="form-control" name="account_name" value="{{ $data->account_name }}" required>
                    <small class="text-danger">{{ $errors->first('account_name') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="account_no" class="col-md-4 control-label">Account No</label>
                <div class="col-md-6">
                    <input id="account_no" type="number" class="form-control" name="account_no" value="{{ $data->account_number }}" required>
                    <small class="text-danger">{{ $errors->first('account_no') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="account_type" class="col-md-4 control-label">Account Type</label>
                <div class="col-md-6">
                    <select id="account_type" class="form-control" name="account_type" required>
                        <option value="">Select Account Type</option>                  
                        @foreach($batypes as $key => $batype)
                        <option value="{{$key}}" @if($key == $data->account_type) {{ 'selected' }} @endif>{{ $batype }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('account_type') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-4 control-label">Address</label>
                <div class="col-md-6">
                    <input id="address" type="text" class="form-control" name="address" value="{{ $data->address }}">
                    <small class="text-danger">{{ $errors->first('address') }}</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                    <input type="submit" class="btn btn-primary" name="btnSave" value="Update">
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!} 

@endsection