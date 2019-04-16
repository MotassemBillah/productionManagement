@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Building Name</th>
                <th>Floor Name</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
                <?php if (has_user_access('rental_floor_delete')) : ?>
                    <th class="text-center">
                        <div class="checkbox">
                            <label><input type="checkbox" id="check_all"value="all"></label>
                        </div>
                    </th>
                <?php endif; ?>
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
                <td>{{ $data->buildingName($data->building_id) }}</td>
                <td>{{ $data->floor_name }}</td>
                <td>{{ $data->description }}</td>
                <td class="text-center">
                    <a class="btn btn-info btn-xs" href="floor/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <?php if (has_user_access('rental_floor_delete')) : ?>
                    <td class="text-center">
                        <div class="checkbox">
                            <label><input type="checkbox" name="data[]" value="{{ $data->id }}"></label>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="text-center hip">
    {{ $dataset->render() }}
</div>
@else
<div class="alert alert-info">No records found.</div>
@endif