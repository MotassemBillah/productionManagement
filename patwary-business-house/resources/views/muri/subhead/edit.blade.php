@extends('layouts.app')

@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view-clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Sub Head </h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sub Head</span></li>
        </ul>                            
    </div>
</div>


<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Sub Head Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'PUT', 'url' => 'subhead/'.$data->id, 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Head Name</label>
                <div class="col-md-6">
                    <select id="ledger_head_id" class="form-control" name="head_id">
                        <option value="">Select Head</option>                  
                        @foreach($head_set as $hs)
                        <?php $sel = ($hs->id == $data->head_id) ? 'selected="selected"' : ''; ?>
                        <option value="{{$hs->id}}" {{$sel}}>{{$hs->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('ledger_head_id') }}</small>
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
    //Function for Ajax req to get Thana by Dist Id
    function get_thana(dist_id) {
        //alert (dist_id);
        // $('#state_id').html('Loading...');
        $.ajax({
            url: "{{ URL::to('get-thana') }}", //Full path of your action
            // alert (url);
            type: "post",
            data: {'dist': dist_id, '_token': '{{ csrf_token() }}'},
            success: function (data) {
                $('#show_thana_list').html(data);
            },
            error: function (xhr, status) {
                alert('There is some error.Try after some time.');
            }
        });
    }
</script>
@endsection