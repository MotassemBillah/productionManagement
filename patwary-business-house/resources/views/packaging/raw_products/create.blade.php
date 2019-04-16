@extends('admin.layouts.column2')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Create New Product</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> New Product</span></li>
        </ul>                            
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Product Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'products', 'id' => 'frmProduct', 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }} 
            <div class="form-group">
                <label  class="col-md-4 control-label">Product Category</label>
                <div class="col-md-6">
                    <select name="product_category" id="inputProduct_category" class="form-control" required="required">
                        <option value="">Select Product Category</option>
                        @foreach($category->all() as $pcat)
                        <option value="{{ $pcat->id }}">{{ $pcat->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('product_category') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Product Name</label>
                <div class="col-md-6 input_fields_wrap">
                    <div><input type="text" class="form-control" name="product_name[]" required></div><button class="add_field_button form-control">Add More <i class="fa fa-plus" aria-hidden="true"></i></button> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="button" id="reset_from" class="btn btn-info">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!} 


<script type="text/javascript">

    $(document).ready(function () {
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="text-center"><input type="text" class="duplicate_field" name="product_name[]" required/>&nbsp;<a href="#" class="remove_field btn btn-danger btn-sm">Remove </a></div>'); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

    $("#reset_from").click(function () {
        var _form = $("#frmProduct");
        _form[0].reset();
    });

</script>

@endsection