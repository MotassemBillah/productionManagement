@extends('layouts.app')
@section('content')
<?php 
    use App\Category;
    use App\Product;
    use App\PriceSetting;

    $price_setting=PriceSetting::where('type','=','sale_price')->get();
 ?>
    <div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
        <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
            <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
            <button class="btn btn-info btn-xs" onclick="redirectTo('/en/site/clear_cache')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
            <h2 class="page-title">Sale Price Setting List</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
            <ul class="text-right no_mrgn">
                <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Sale Price</span></li>
            </ul>                            
        </div>
    </div>

    <div class="well">
        <table width="100%">
            <tbody>
                <tr>
                    <td class="wmd_70">
                       {!! Form::open(['method' => 'POST',  'class' => 'search-form', 'id'=>'frmSearch','name'=>'frmSearch']) !!} 
                          {{ csrf_field() }}
                            <div class="input-group">
                                <div class="input-group-btn clearfix">
                                    <select id="itemCount" class="form-control" name="item_count" style="width:58px;">
                                        <option value="5">5</option>
                                        <option value="10" selected="selected">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                        <option value="70">70</option>
                                        <option value="80">80</option>
                                        <option value="90">90</option>
                                        <option value="100">100</option>                         
                                    </select>
                                    <div class="col-md-2 col-sm-3 no_pad">
                                        <select id="sortBy" class="form-control" name="sort_by">
                                            <option value="product_id">Sort By</option>
                                            <option value="product_id" style="text-transform:capitalize">Product Name</option>
                                            <option value="product_label" style="text-transform:capitalize">Product Number</option>                              
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-3 no_pad">
                                        <select id="sortType" class="form-control" name="sort_type">
                                            <option value="ASC">Ascending</option>
                                            <option value="DESC">Descending</option>
                                        </select>
                                    </div>
                                    <input type="text" name="search" id="q" class="form-control" placeholder="search product number" size="30"/>
                                    <button type="button" id="search" class="btn btn-info">Search</button>
                                    <button type="button" id="clear_from" class="btn btn-primary" data-info="/agent">Clear</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </td>
                    <td class="text-right wmd_30" style="">
                        <a href="{{ url ('/new-sale-price-setting') }}"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="ajax_content"> 
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Category Name</th>
                        <th>Product Name</th>
                        <th>Product Number</th>
                        <th>Per Bag Weight</th>
                        <th>Per Bag Price</th>
                        <th>Per Kg Price</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php $sl=1; ?>
                    @foreach ($price_setting as $product)
                   <?php  
                        $pro_cat_id=$product->category_id;
                        $pro_id=$product->product_id;
                        $pro_no_id=$product->product_no_id;
                        $category_name=Category::where('id', $pro_cat_id)->first();
                        $product_name=Product::where('id', $pro_id)->first();
                        $product_number=DB::table('product_items')->where('id', $pro_no_id)->first();
                   ?> 
                    <tr>
                        <td class="text-center" style="width:5%;">{{ $sl }}</td>
                        <td>{{ !empty($category_name) ? $category_name->name : '' }} </td>
                        <td>{{ !empty($product_name) ? $product_name->name : '' }} </td>
                        <td>{{ !empty($product_number) ? $product_number->name : '' }} </td>
                        <td>{{ $product->per_bag_weight }}</td>
                        <td>{{ $product->per_bag_price }}</td>
                        <td>{{ $product->per_kg_price }}</td>

                        <td class="text-center">
                            <a class="btn btn-info btn-xs" href="edit-sale-price-settiing/{{ $product->id }}"><i class="fa fa-edit"></i> Edit</a>
                            <a class="btn btn-danger btn-xs" href="sale-price/delete/{{$product->id }}" onClick="return confirm('Are you sure about this action? This cannot be undone!');"><i class="fa fa-trash-o"></i> Delete</a>
                        </td>
                        <?php $sl++;  ?>
                    </tr>
                                
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

     <script type="text/javascript">
        // $(document).ready(function(){
        //     $("#search").click(function(){
        //        var _url="{{ URL::to('get-product-number-list') }}";
        //        var _form=$("#frmSearch");
        
        //     $.ajax({
        //       url: _url, //Full path of your action
        //      // alert (url);
        //       type: "post",   
        //       data: _form.serialize(),
        //       success: function(data){
        //         $('#ajax_content').html(data);
        //       },
        //       error: function (xhr, status) {              
        //             alert('There is some error.Try after some time.'); 
        //           }
        //     });

        //     })
        // });
    </script>

@endsection