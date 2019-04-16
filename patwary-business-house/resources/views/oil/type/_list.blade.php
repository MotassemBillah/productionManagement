<?php if (!empty($dataset) && count($dataset) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-bordered tbl_thin" id="check">
            <tbody>
                <tr class="bg_gray" id="r_checkAll">
                    <th class="text-center" style="width:5%;">SL#</th>
                    <th>Name</th>
                    <th class="text-center hip" style="width:12%;">Actions</th>
                    <th class="text-center hip" style="width:4%;"><input type="checkbox" id="check_all"value="all"></th>
                </tr>
                <?php $counter = 0; ?>
                @foreach ($dataset as $data)
                <?php
                $counter++;
                ?>   
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $data->name }}</td>
                    <td class="text-center hip">
                        <a class="btn btn-info btn-xs" href="bagtype/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                    </td>
                    <td class="text-center hip"><input type="checkbox" name="data[]" value="{{ $data->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">No records found!</div>
<?php endif; ?>