<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Category Name</th>
                    <th>After Production Name</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Weight</th>
                </tr>
                <?php
                $counter = 0;
                if (isset($_GET['page']) && $_GET['page'] > 1) {
                    $counter = ($_GET['page'] - 1) * $dataset->perPage();
                }
                ?>
                @foreach ($dataset as $data)
                <?php $counter++; ?>
                <tr>
                    <td class="text-center" style="width:5%;">{{ $counter }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ $data->size }}</td>
                    <td>{{ $data->weight }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>