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
            <li><a href="{{ url('/inv/product') }}">Product</a> <i class="fa fa-angle-right"></i></li>
            <li>Form</li>
        </ul>                            
    </div>
</div>
@endsection

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Enter Product Information</h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['method' => 'POST', 'url' => 'inv/product', 'class' => 'form-horizontal']) !!} 
        {{ csrf_field() }}
        <div class="form-group">
            <label class="col-md-4 control-label" for="business_type_id">Business Type</label>
            <div class="col-md-6">
                <select class="form-control" id="business_type_id" name="business_type_id" required>
                    <option value="">Select</option>
                    @foreach ($business_types as $btype)
                    <option value="{{ $btype->id }}">{{ $btype->business_type }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('business_type_id') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="category_id">Category</label>
            <div class="col-md-6">
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Business Type First</option>                    
                </select>
                <small class="text-danger">{{ $errors->first('category_id') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="type">Product Type</label>
            <div class="col-md-6">
                <select class="form-control" id="type" name="type" required>
                    <option value="">Select</option>
                    @foreach ($types as $tkey => $tval)
                    <option value="{{ $tkey }}">{{ $tval }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('type') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Product Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" required>
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="unit">Unit</label>
            <div class="col-md-6">
                <select class="form-control" id="unit" name="unit" required>
                    <option value="">Select</option>
                    @foreach (unit_list() as $_ukey => $_uval)
                    <option value="{{ $_ukey }}">{{ $_uval }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('unit') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="size">Size</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="size" name="size" value="">
                <small class="text-danger">{{ $errors->first('size') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="weight">Weight</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="weight" name="weight" value="">
                <small class="text-danger">{{ $errors->first('weight') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="color">Color</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="color" name="color" value="">
                <small class="text-danger">{{ $errors->first('color') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="grade">Grade</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="grade" name="grade" value="">
                <small class="text-danger">{{ $errors->first('grade') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="printed">Printed</label>
            <div class="col-md-6">
                <select class="form-control" id="printed" name="printed">
                    <option value="">Select</option>
                    @foreach (printed_list() as $printed_key => $printed_val)
                    <option value="{{ $printed_key }}">{{ $printed_val }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('printed') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="laminated">Laminated</label>
            <div class="col-md-6">
                <select class="form-control" id="laminated" name="laminated">
                    <option value="">Select</option>
                    @foreach (yes_no_list() as $laminated_key => $laminated_val)
                    <option value="{{ $laminated_key }}">{{ $laminated_val }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('laminated') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="liner">Liner</label>
            <div class="col-md-6">
                <select class="form-control" id="liner" name="liner">
                    <option value="">Select</option>
                    @foreach (yes_no_list() as $liner_key => $liner_val)
                    <option value="{{ $liner_key }}">{{ $liner_val }}</option>
                    @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('liner') }}</small>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="buy_price">Buy Price</label>
            <div class="col-md-6">
                <input type="number" class="form-control" id="buy_price" name="buy_price" value="" min="0" step="any">
                <small class="text-danger">{{ $errors->first('buy_price') }}</small>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-4">
            <button type="button" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("change", "#business_type_id", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('inv/list_buisness_category') }}",
                type: "post",
                data: {'business_type': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#category_id').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });
    });
</script>
@endsection