@extends('layouts.app')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('/en/site/clear_cache')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Create New Particular</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sub Head</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Particular Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'particular', 'id' => 'frm_head'  , 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ !empty($id) ? $id : '' }}">
            <div class="form-group">
                <label for="head" class="col-md-4 control-label">Sub Head Name</label>
                <div class="col-md-6">
                    <select id="subhead" class="form-control" name="subhead" required>
                        <option value="">Select Sub Head</option>
                        @foreach($subhead_set as $subhead)
                        <option value="{{$subhead->id}}">{{$subhead->name}}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('subhead') }}</small>
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
                <label for="commission" class="col-md-4 control-label">Broker Commission</label>
                <div class="col-md-6">
                    <input type="number" id="commission" class="form-control" name="commission" min="0" step="any">
                    <small class="text-danger">{{ $errors->first('commission') }}</small>
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
                    <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                    <input type="submit" class="btn btn-primary" name="btnSave" value="Save">
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!} 


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#head", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/subhead') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subhead");
                    $('#subhead').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

    });

    $("#reset_from").click(function () {
        var _form = $("#frm_agent");
        _form[0].reset();
    });

</script>
@endsection