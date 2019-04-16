@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tr class="bg-info" id="r_checkAll">
            <th class="text-center" style="width:4%;">SL#</th>
            <th>Business Type</th>
            <th>Category Type</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
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
            <td class="text-center">{{ $counter }}</td>
            <td>{{ !empty($data->business_type) ? $data->business_type->business_type : "" }}</td>
            <td>{{ $data->type }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->unit }}</td>
            <td>{{ $data->description }}</td>
            <td class="text-center">
                <a class="btn btn-info btn-xs" href="category/{{$data->id}}/edit"><i class="fa fa-edit"></i> Edit</a>
            </td>
            <td class="text-center hip">
                <?php if (has_user_access('inv_category_delete')) : ?>
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