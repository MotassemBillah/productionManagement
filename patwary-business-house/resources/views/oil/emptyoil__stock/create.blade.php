@extends('layouts.app')
@section('content')
<?php
if ($tp == 'd') {
    $pcls = "success";
    $pbg = "bg-success";
    $title = "Receive";
} elseif ($tp == 'c') {
    $pcls = "danger";
    $pbg = "bg-danger";
    $title = "Unloading";
} else {
    $pcls = "warning";
    $pbg = "bg-warning";
    $title = "Due";
}
?>
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">New Empty Bag ({{ $title }} Voucher)</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Bag</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Empty Bag Stock Information</div>
        <div class="panel-body {{$pbg}}">
            {!! Form::open(['method' => 'POST', 'url' => 'emptybag-stock', 'id' => 'frmEmptyBags'  , 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }}
            <input type="hidden" name="type" value="{{ $tp }}">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <label for="datepicker" class="col-md-3">Date</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" id="datepicker" class="form-control pickdate" name="date" placeholder="(dd-mm-yyyy)" value="<?= date('d-m-Y'); ?>" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <small class="text-danger">{{ $errors->first('date') }}</small>
                            </div>
                        </div>
                    </div>
                    @if( $tp == 'd' )
                    <div class="form-group">
                        <label class="col-md-3">Supplier</label>
                        <div class="col-md-8">
                            <select id="headDebit" class="form-control" name="frm_subhead" required>
                                <option value="">Select Head</option>
                                @foreach($heads as $head)
                                <option value="{{$head->id}}">{{$head->name}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('frm_subhead') }}</small>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="subheadDebit" class="col-md-3">Supplier Name</label>
                        <div class="col-md-8">
                            <select id="subheadDebit" class="form-control" name="frm_particular" disabled>
                                <option value="">Select Head First</option>
                            </select>
                        </div> 
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="challan_no" class="col-md-3">Challan No</label>
                        <div class="col-md-8">
                            <input type="text" id="challan_no" class="form-control" name="challan_no" required>
                            <small class="text-danger">{{ $errors->first('challan_no') }}</small>
                        </div>               
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-md-3">Description</label>
                        <div class="col-md-8">                    
                            <textarea id="description" class="form-control" name="description"></textarea>
                            <small class="text-danger">{{ $errors->first('description') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-md-3">Quantity</label>
                        <div class="col-md-8">
                            <input type="number" id="quantity" class="form-control bag_price" name="quantity" required>
                            <small class="text-danger">{{ $errors->first('quantity') }}</small>
                        </div>               
                    </div>
                    <div class="form-group">
                        <label for="size" class="col-md-3">Size</label>
                        <div class="col-md-8">
                            <select id="size" name="size" class="form-control">
                                <option value="">Select Size</option>
                                <?php foreach ($sizes as $key => $size) : ?>
                                    <option value="{{$size->name}}">{{$size->name}}</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger">{{ $errors->first('size') }}</small>
                        </div>               
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-md-3">Color</label>
                        <div class="col-md-8">
                            <select id="color" name="color" class="form-control">
                                <option value="">Select Color</option>
                                <?php foreach ($colors as $key => $color) : ?>
                                    <option value="{{$color->name}}">{{$color->name}}</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger">{{ $errors->first('color') }}</small>
                        </div>               
                    </div>
                    <div class="form-group">
                        <label for="bag_type" class="col-md-3">Type</label>
                        <div class="col-md-8">
                            <select id="bag_type" name="bag_type" class="form-control">
                                <option value="">Select Type</option>
                                <?php foreach ($types as $key => $type) : ?>
                                    <option value="{{$type->name}}">{{$type->name}}</option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger">{{ $errors->first('bag_type') }}</small>
                        </div>               
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="text-center">
                    <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                    <input type="submit" class="btn btn-primary" name="btnSave" value="Save">
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!} 


<script type="text/javascript">


    $(document).on("change", "#headDebit", function () {
        var id = $(this).val();
        $.ajax({
            url: "{{ URL::to('subhead/particular') }}",
            type: "post",
            data: {'head': id, '_token': '{{ csrf_token() }}'},
            success: function (data) {
                enable("#subheadDebit");
                $('#subheadDebit').html(data);
            },
            error: function (xhr, status) {
                alert('There is some error.Try after some time.');
            }
        });
    });


    $("#reset_from").click(function () {
        var _form = $("#frmEmptyBags");
        _form[0].reset();
    });

</script>
@endsection