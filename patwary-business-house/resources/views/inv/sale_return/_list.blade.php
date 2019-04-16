@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tr class="bg-info" id="r_checkAll">
            <th class="text-center" style="width:4%;">SL#</th>
            <th style="width:100px">Date</th>
            <th>Invoice No</th>
            <th style="width:22%">From</th>
            <th style="width:22%">To</th>
            <th class="text-center" style="width:5%;">Items</th>
            <th class="text-right" style="width:8%;">Amount</th>
            <th class="text-center hip" style="width:15%;">Actions</th>
            <th class="text-center hip" style="width:3%;"><input type="checkbox" id="check_all"value="all"></th>
        </tr>
        <?php
        $counter = 0;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $counter = ($_GET['page'] - 1) * $dataset->perPage();
        }
        ?>
        @foreach ($dataset as $data)
        <?php $counter++; ?>
        <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
            <td class="text-center">{{ change_lang($counter) }}</td>
            <td>{{ change_lang(date_dmy($data->invoice_date)) }}</td>
            <td>{{ change_lang($data->invoice_no) }}</td>
            <td>{{ $data->subhead_name($data->from_subhead_id) }} {{ !empty($data->from_particular_id) ? "-> " . $data->particular_name($data->from_particular_id) : "" }}</td>
            <td>{{ $data->subhead_name($data->to_subhead_id) }} {{ !empty($data->to_particular_id) ? "-> " . $data->particular_name($data->to_particular_id) : "" }}</td>
            <td class="text-center">{{ change_lang(count($data->items)) }}</td>
            <td class="text-right">{{ change_lang($data->total_amount) }}</td>
            <td class="text-center hip">
                @if ($data->process_status == ORDER_PENDING)
                <a class="btn btn-info btn-xs" href="sale-return/{{$data->_key}}/edit">Edit</a>
                <a class="btn btn-warning btn-xs btn_process" href="javascript:void(0)" data-info="{{$data->_key}}">Process</a>
                @endif
                <a class="btn btn-primary btn-xs" href="sale-return/detail/{{$data->_key}}">View</a>
            </td>
            <td class="text-center hip">
                <?php if (has_user_access('inv_sales_delete')) : ?>
                    <input type="checkbox" name="data[]" value="{{ $data->id }}">
                <?php endif; ?>
            </td>
        </tr>
        @endforeach
    </table>
</div>
<div class="mb_10 text-center hip" id="apaginate">
    {{ $dataset->render() }}
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif