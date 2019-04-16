@extends('layouts.app')

@section('content')
<?php 
     use App\Category;
     use App\Product;
    // // $product_cat=Category::all();
    // // $product_name=Product::all();
    $cat_id=!empty($production->category_id) ? Category::where('id','=',$production->category_id)->first() : '';
    $cat_name=!empty($cat_id) ?$cat_id->name : '';   

    $after_products=!empty($production->after_production_id) ? DB::table('after_production')->where('id','=',$production->after_production_id)->first() : '';
    $after_pro_name=!empty($after_products) ? $after_products->name : ''; 

    $product_id=!empty($production->product_id) ? Product::where('id','=',$production->product_id)->first() : '';
    $product_name=!empty($product_id) ?$product_id->name : '';

    $product_no_id=!empty($production->product_no_id) ? DB::table('product_items')->where('id','=',$production->product_no_id)->first() : '';
    $product_number=!empty($product_no_id) ?$product_no_id->name : '';
 ?>
    <div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
        <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
            <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
            <button class="btn btn-info btn-xs" onclick="redirectTo('/en/site/clear_cache')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
            <h2 class="page-title">Update Purchase Price Setting</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
            <ul class="text-right no_mrgn">
                <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> New Product</span></li>
            </ul>                            
        </div>
    </div>
       
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Purchase Price Setting Information</div>
            <div class="panel-body">
               {{ Form::open(['method' => 'POST', 'url' => 'update-production-settiing', 'class' => 'form-horizontal' ]) }}
 
                      <div class="form-group">
                         <label class="col-md-4 control-label">Product Category</label>
                         <div class="col-md-6">
                             <input type="text" class="form-control"  value="{{ $cat_name }}" readonly>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-md-4 control-label">Product Name</label>
                         <div class="col-md-6">
                             <input type="text" class="form-control"  value="{{ $product_name }}" readonly>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-md-4 control-label">Product Number</label>
                         <div class="col-md-6">
                             <input type="text" class="form-control"  value="{{ $product_number }}" readonly>
                         </div>
                     </div>   
                     <div class="form-group">
                         <label class="col-md-4 control-label">After Production Name</label>
                         <div class="col-md-6"> 
                              <input type="text" value="{{ $after_pro_name }}" class="form-control"  readonly>
                         </div>
                     </div> 
                     <div class="form-group">
                         <label class="col-md-4 control-label">Total Weight</label>
                         <div class="col-md-6">
                              <input type="number" step="any" id="total_weight" value="{{ $production->total_weight }}" class="form-control" name="total_weight">
                              <small class="text-danger">{{ $errors->first('total_weight') }}</small> 
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-md-4 control-label">Net Weight</label>
                         <div class="col-md-6">
                              <div style="width:24%; display:none; padding: 3px;margin-bottom: 5px;" id="alt_{{ $production->after_production_id }}" class="alert alert-danger">
                                <strong>Weight Exceed</strong>
                              </div>
                              <input type="number" step="any" id="net_weight_{{ $production->after_production_id }}" value="{{ $production->net_weight }}" class="form-control total_weight_check" name="net_weight" onkeyup="show_percentage_ratio({{ $production->after_production_id }})">
                              <small class="text-danger">{{ $errors->first('net_weight') }}</small>
                         </div>
                     </div> 
                     <div class="form-group">
                         <label class="col-md-4 control-label">Bag Weight</label>
                         <div class="col-md-6">
                              <input type="number" step="any" value="{{ $production->bag_weight }}" class="form-control" name="bag_weight">
                              <small class="text-danger">{{ $errors->first('bag_weight') }}</small>
                         </div>
                     </div> 
                     <div class="form-group">
                         <label class="col-md-4 control-label">Ratio ( % )</label>
                         <div class="col-md-6"> 
                              <input type="number" step="any" id="ratio_{{ $production->after_production_id }}" value="{{ $production->production_ratio }}" class="form-control" name="ratio" readonly> 
                              <small class="text-danger">{{ $errors->first('ratio') }}</small>
                         </div>
                     </div> 
                    <div class="form-group">
                      <input type="hidden" name="hid" value="{{ $production->id }}">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="button" onclick="history.back();" class="btn btn-info">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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