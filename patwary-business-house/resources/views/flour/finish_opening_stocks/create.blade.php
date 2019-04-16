@extends('admin.layouts.column2')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">After Production Opening Stocks</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Production Stock</span></li>
        </ul>                            
    </div>
</div>
{!! Form::open(['method' => 'POST', 'url' => '',   'class' => 'search-form', 'id'=>'frmStock','name'=>'frmStock']) !!} 
{{ csrf_field() }}

<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-6">
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
    </div>
</div> 
<div class="table-responsive">
    <table class="table table-bordered" id="check">
        <thead>
            <tr class="bg_gray" id="r_checkAll">
                <th>Category</th>
                <th>Product</th>
                <th>Quantity (Bag)</th>
                <th>Net Weight (Kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataset as $data)
            <tr>
                <td>{{ $category->find($data->category_id)->name }}<input type="hidden" value="{{ $data->category_id }}" name="category_id[]"> <input type="hidden" class="form-control" id="bag_weight_{{ $data->id }}"></td>
                <td>{{ $data->name }} <input type="hidden" value="{{ $data->id }}" name="product_id[]" ></td>
                <td><input type="number" min="0" class="form-control qty" id="quantity_{{ $data->id }}" data-weight ="{{ $data->weight }}" data-info="{{ $data->id }}" name="quantity[]"></td>
                <td><input type="number" class="form-control" id="net_weight_{{ $data->id }}" name="net_weight[]" readonly></td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnPurchase">Save</button>
        </div>
    </div>
</div>

{!! Form::close() !!}


<script type="text/javascript">
    $(document).ready(function () { 

        $(document).on("submit", "#frmStock", function (e) {
            var _form = $(this);
            var _url = "{{ URL::to ('flour/finish-opening-stocks') }}";
            $.post(_url, _form.serialize(), function (res) {
                if (res.success === true) {
                    _form[0].reset();
                    redirectTo(res.url);
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'success'});
                } else {
                    $("#ajaxMessage").showAjaxMessage({html: res.message, type: 'error'});
                }
            }, "json");
            e.preventDefault();
            return false;
        });

    });

    $(document).on("input", ".qty", function (e) {
        var id = $(this).attr('data-info');
        var qun = this.value;
        var total_weight = 0;
        var bag_weight = $(this).attr('data-weight');
        if (isNaN(bag_weight) || bag_weight == '') {
            bag_weight = 1;
        }
        total_weight = qun * bag_weight;
        document.getElementById("net_weight_" + id).value = total_weight;
        e.preventDefault();
    });
</script>

@endsection