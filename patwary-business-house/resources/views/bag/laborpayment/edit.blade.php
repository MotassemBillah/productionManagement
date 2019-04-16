@extends('layouts.app')
@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('<?= url('view-clear') ?>')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Update Labor Payment</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i>  After Product</span></li>
        </ul>                            
    </div>
</div>
{!! Form::open(['method' => 'PUT', 'url' => 'laborpayment/'.$data->id, 'class' => 'form-horizontal']) !!} 
{{ csrf_field() }} 
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        <div class="mb_5 clearfix">
            <label class="col-md-5 text-right">Date:</label>
            <input type="text" class="col-md-7 pickdate" id="date" name="date" value="{{ date_dmy($data->date) }}" required readonly>
        </div>
        <div class="mb_5 clearfix">
            <label for="subhead" class="col-md-5 text-right">Labor Type :</label>
            <select class="col-md-7" id="subhead" name="subhead_id" required>
                <option value="">Select Head</option>
                @foreach( $subheads as $subhead )
                <option value="{{ $subhead->id }}" @if($subhead->id == $data->subhead_id) {{ ' selected' }} @endif>{{ $subhead->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb_5 clearfix">
            <label for="shift" class="col-md-5 text-right">Shift :</label>
            <select class="col-md-7" id="shift" name="shift" required>
                <option value="">Select Shift</option>
                @foreach(laborDutyPeriod() as $key=> $value)
                <option value="{{ $key }}" @if($key == $data->shift) {{ ' selected' }} @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<hr style="margin: 5px 0">
<div class="text-center"><strong>Labor Payment Information</strong></div>
<hr style="margin: 5px 0 10px">

<div id="laborList">
    <div class="table-responsive" style="width: 50%;margin: 0 auto;">
        <table class="table table-bordered tbl_thin" id="check">
            <thead>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;"><input type="checkbox" id="check_all" value="all" name="check" style="margin: 0;" checked></th>
                    <th>Name</th>
                    <th class="text-right">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl = 0; ?>
                @foreach ( $data->items as $item )
                <?php $sl++; ?>
                <tr>
                    <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="labor[]" value="{{ $item->id }}" checked></td>
                    <td>{{ $item->particularName($item->particular_id) }} <input type="hidden" value="{{ $item->particular_id }}" name="particular_id[{{ $item->id }}]" ></td>
                    <td>
                        <input type="number" step="any" id="net_price_{{ $item->id }}" name="net_price[{{ $item->id }}]" value="{{ $item->net_price }}" class="form-control" readonly>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12" style="margin-top: 20px;">
    <div class="form-group">
        <div class="text-center">
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnPurchase">Update</button>
        </div>
    </div>
</div>

{!! Form::close() !!} 

<script type="text/javascript">

    $(document).ready(function () {
        $(document).on("change", "#subhead", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('laborpayment/laborlist') }}",
                type: "post",
                data: {'id': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    $('#laborList').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });
    });


    $("#reset_from").click(function () {
        var _form = $("#frmLaborPayment");
        _form[0].reset();
    });

</script>


@endsection