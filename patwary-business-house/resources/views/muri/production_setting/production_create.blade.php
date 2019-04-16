@extends('layouts.app')
@section('content')
<?php
use App\Category;
use App\Product;
$product_cat=Category::all();
$product_name=Product::all();
$after_products=DB::table('after_production')->get();
?>
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
  <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
    <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
    <button class="btn btn-info btn-xs" onclick="redirectTo('/en/site/clear_cache')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
    <h2 class="page-title">Create New Production Setting</h2>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
    <ul class="text-right no_mrgn">
      <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> New Pro Setting</span></li>
    </ul>
  </div>
</div>

<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">Production Setting Information</div>
    <div class="panel-body">
      {{ Form::open(['method' => 'POST', 'url' => 'create-new-production-settiing', 'class' => 'form-horizontal' ]) }}
      {{ csrf_field() }}
      <div class="form-group">
        <label class="col-md-4 control-label">Product Type</label>
        <div class="col-md-6">
          <select name="product_category" onchange="get_product_by_id(this.value)" id="inputProduct_category" class="form-control" required="required">
            <option value="">Select Product Category</option>
            @foreach($product_cat as $pcat)
            <option value="{{ $pcat->id }}">{{ $pcat->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">Product Name</label>
        <div class="col-md-6">
          <div id="show_product_list">
            <input type="text" class="form-control"  value="Please Select Product Type First" disabled>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">Product Number</label>
        <div class="col-md-6">
          <div id="show_product_number">
            <input type="text" class="form-control"  value="Please Select Product Name" disabled>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">Total Weight (Kg)</label>
        <div class="col-md-6">
          <input type="number" id="total_weight" step="any" class="form-control" name="total_weight">
          <small class="text-danger">{{ $errors->first('total_weight') }}</small>
        </div>
      </div>
      @foreach ($after_products as $after_product)
      <div class="form-group">
        <label class="col-md-4 control-label">{{ $after_product->name }}</label>
        <input type="hidden" name="after_production[]" value="{{ $after_product->id }}">
        <div class="col-md-6 form-inline">
          <div style="width:24%; display:none; padding: 3px;margin-bottom: 5px;" id="alt_{{ $after_product->id }}" class="alert alert-danger">
            <strong>Weight Exceed</strong>
          </div>
          Net Weight : <input type="number" style="width:16.5%;" step="any" id="net_weight_{{ $after_product->id }}" class="form-control total_weight_check" name="net_weight[]" onkeyup="show_percentage_ratio({{ $after_product->id }})">
          Bag Weight : <input type="number" style="width:16.5%;" step="any" class="form-control" name="bag_weight[]">
          Ratio ( % ) : <input type="number" style="width:16%;" step="any" id="ratio_{{ $after_product->id }}" class="form-control" name="ratio[]" readonly>
          <small class="text-danger">{{ $errors->first('totla_weight') }}</small>
          <small class="text-danger">{{ $errors->first('net_weight') }}</small>
          <small class="text-danger">{{ $errors->first('ratio') }}</small>
        </div>
      </div>
      @endforeach
      <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
          <button type="button" class="btn btn-info">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
//Function for Ajax req to get Product by ID
function get_product_by_id(id){
//alert (id);
// $('#state_id').html('Loading...');
var _url = "{{ URL::to('get-product') }}/" + id;
// alert (_url);
$.ajax({
url: _url,
type: "get",
// data: {'dist':dist_id,'_token': '{{ csrf_token() }}'},
success: function(data){
$('#show_product_list').html(data);
},
error: function (xhr, status) {
alert('There is some error.Try after some time.');
}
});
}
//Function for Ajax req to get Product by Category Id
function get_product_number_id(id){
//alert (id);
// $('#state_id').html('Loading...');
var _url = "{{ URL::to('get-product-number') }}/" + id;
// alert (_url);
$.ajax({
url: _url,
type: "get",
// data: {'dist':dist_id,'_token': '{{ csrf_token() }}'},
success: function(data){
$('#show_product_number').html(data);
},
error: function (xhr, status) {
alert('There is some error.Try after some time.');
}
});
}
</script>
@endsection