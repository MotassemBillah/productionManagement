<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category Name</th>
                    <th>After Production Name</th>
                    <th>Bag Weight</th>
                    <th>Sale Price</th>
                    <th class="text-center">Actions</th>
                    <?php if (has_user_access('after_production_delete')) : ?>
                        <th class="text-center">
                            <div class="checkbox">
                                <label><input type="checkbox" id="check_all"value="all"></label>
                            </div>
                        </th>
                    <?php endif; ?>
                </tr>
                <?php $sl = 1; ?>
                @foreach ($dataset as $data)
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $category->find($data->category_id)->name }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->weight }}</td>
                    <td>{{ $data->sale_price }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="after-production/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <?php if (has_user_access('after_production_delete')) : ?>
                        <td class="text-center">
                            <div class="checkbox">
                                <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                            </div>
                        </td>
                    <?php endif;
                    $sl++; ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>