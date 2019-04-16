<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category Name</th>
                    <th>Product Name</th>
                    <th class="text-center">Actions</th>
                    <?php if (has_user_access('product_delete')) : ?>
                        <th class="text-center"><input type="checkbox" id="check_all"value="all"></th>
                    <?php endif; ?>
                </tr>
                <?php $sl = 1; ?>
                @foreach ($dataset as $product)
                <tr>
                    <td class="text-center" style="width:5%;">{{ $sl }}</td>
                    <td>{{ $category->find($product->category_id)->name }} </td>
                    <td>{{ $product->name }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-xs" href="products/{{ $product->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <?php if (has_user_access('product_delete')) : ?>
                        <td class="text-center"><input type="checkbox" name="data[]" value="{{ $product->id }}"></td>
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