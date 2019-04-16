@extends('admin.layouts.master')
@section('content')
    <?php 
        use App\Models\Institute;
        $access_items = institute_access_items();
        $active_access_items= Institute::get_institute_permission_by_id($data->id);
        $active_access_item_list= !empty($active_access_items) ? $active_access_items : [];
     ?>

    <div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
        <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
            <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
            <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
            <h2 class="page-title">Update Institute Permissions</h2>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
            <ul class="text-right no_mrgn">
                <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Institute Update</span></li>
            </ul>                            
        </div>
    </div>
    <div class="customer_info">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Institute Access List for <strong><u>{{ $data->name }}</u></strong></h4></div>
                <div class="panel-body">
                     {!! Form::open(['method' => 'POST', 'url' => 'institute/acess/update', 'class' => 'form-horizontal']) !!} 
                        {{ csrf_field() }}
                        <div class="user_access">
                            <input type="hidden" name="institute_id" value="{{ $data->id }}">
                            <div class="access_item_list" id="check">
                                <ul id="access_list" class="list-group">
                                    @foreach ( $access_items as $key => $item)
                                    <li class="list-group-item access_item <?php if( array_key_exists($key, $active_access_item_list) ) { echo "active_access_item"; } ?> ">
                                        <label>
                                            <input type="checkbox" name="access[{{ $key }}]" value="{{ $item }}" <?php if( array_key_exists($key, $active_access_item_list) ) { echo "checked"; } ?> > {{ $item }}              
                                        </label>
                                    </li>
                                    @endforeach  
                                </ul>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <div class="checkbox" style="display:inline-block; margin-right:1%;">
                                        <label>
                                            <input type="checkbox" id="check_all" value="">
                                            Check All
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            if( $("#access_list input[type='checkbox']:checked").length>0 ){
                $("#check_all").prop('checked',true);
            }

            $(document).on("change", "#check input[type='checkbox']", function(){
                if(this.checked){
                    $(this).closest("li").not("#r_checkAll").addClass("active_access_item");
                }else {
                    $(this).closest("li").removeClass("active_access_item");
                }
            });

            $(document).on("change", "#check_all", function(){
                if($(this).is(":checked")){
                    $("#check li").not("#r_checkAll").addClass("active_access_item");
                } 
                else {
                    $("#check li").removeClass("active_access_item");
                }
            });

        });
    </script>
@endsection