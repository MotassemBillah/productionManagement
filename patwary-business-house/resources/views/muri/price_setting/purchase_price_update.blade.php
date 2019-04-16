@extends('layouts.app')

@section('content')
<?php 
     use App\Category;
     use App\Product;
    // // $product_cat=Category::all();
    // // $product_name=Product::all();
    $cat_id=!empty($purchase->category_id) ? Category::where('id','=',$purchase->category_id)->first() : '';
    $cat_name=!empty($cat_id) ?$cat_id->name : ''; 

    $product_id=!empty($purchase->product_id) ? Product::where('id','=',$purchase->product_id)->first() : '';
    $product_name=!empty($product_id) ?$product_id->name : '';

    $product_no_id=!empty($purchase->product_no_id) ? DB::table('product_items')->where('id','=',$purchase->product_no_id)->first() : '';
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
               {{ Form::open(['method' => 'POST', 'url' => 'update-purchase-price-settiing', 'class' => 'form-horizontal' ]) }}
 
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
                         <label class="col-md-4 control-label">Per Bag Weight</label>
                         <div class="col-md-6"> 
                              <input type="number" value="{{ $purchase->per_bag_weight }}" step="any" class="form-control" name="per_bag_weight">
                              <small class="text-danger">{{ $errors->first('per_bag_weight') }}</small> 
                         </div>
                     </div> 
                     <div class="form-group">
                         <label class="col-md-4 control-label">Per Bag Price</label>
                         <div class="col-md-6">
                              <input type="number" step="any" value="{{ $purchase->per_bag_price }}" class="form-control" name="per_bag_price">
                              <small class="text-danger">{{ $errors->first('per_bag_price') }}</small> 
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-md-4 control-label">Per Kg Price</label>
                         <div class="col-md-6">
                              <input type="number" step="any" value="{{ $purchase->per_kg_price }}" class="form-control" name="per_kg_price">
                              <small class="text-danger">{{ $errors->first('per_kg_price') }}</small>
                         </div>
                     </div> 
                    <div class="form-group">
                      <input type="hidden" name="hid" value="{{ $purchase->id }}">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="button" class="btn btn-info">Cancel</button>
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