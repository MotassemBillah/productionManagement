<?php if (!empty($dataset) && count($dataset) > 0) : ?>
<div class="table-responsive" style="width: 50%;margin: 0 auto;">
        <table class="table table-bordered tbl_thin" id="check">
            <thead>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;"><input type="checkbox" id="check_all" value="all" name="check" style="margin: 0;"></th>
                    <th>Name</th>
                    <th class="text-right">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl = 0; ?>
                @foreach ( $dataset as $data )
                <?php $sl++; ?>
                <tr>
                    <td class="text-center" style="width:5%;"><input type="checkbox" class="single_check" name="labor[]" value="{{ $data->id }}"></td>
                    <td>{{ $data->name }} <input type="hidden" value="{{ $data->id }}" name="particular_id[{{ $data->id }}]" ></td>
                    <td>
                        <input type="number" step="any" id="net_price_{{ $data->id }}" name="net_price[{{ $data->id }}]" value="{{ $data->commission }}" class="form-control" readonly>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>