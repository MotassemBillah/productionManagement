<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th class="text-right">Buy Price</th>
                    <th class="text-center">Actions</th>
                    <?php if (has_user_access('product_delete')) : ?>
                        <th class="text-center"><input type="checkbox" id="check_all"value="all"></th>
                    <?php endif; ?>
                </tr>
                <?php $sl = 1; ?>
                @foreach ($dataset as $data)
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $data->categoryName($data->raw_category_id) }} </td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ $data->size }}</td>
                    <td class="text-right">{{ $data->buy_price }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="rawproduct/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <?php if (has_user_access('product_delete')) : ?>
                        <td class="text-center"><input type="checkbox" name="data[]" value="{{ $data->id }}"></td>
                        <?php
                    endif;
                    $sl++;
                    ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>