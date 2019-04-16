@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered" id="check">
        <tbody>
            <tr class="bg_gray" id="r_checkAll">
                <th class="text-center" style="width:5%;">SL#</th>
                <th>Building</th>
                <th>Floor</th>
                <th>Flat</th>
                <th>Party</th>
                <th>Mobile</th>
                <th>Address</th>
                <th class="text-right">Rental Date</th>
                <th class="text-right">Monthly Rent</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
                <?php if (has_user_access('rental_party_delete')) : ?>
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
                <td>{{ $data->building->building_name }}</td>
                <td>{{ $data->floor->floor_name }}</td>
                <td>{{ $data->flat->flat_name }}</td>
                <td>{{ $data->party_name }}</td>
                <td>{{ $data->mobile_no }}</td>
                <td>{{ $data->address }}</td>
                <td class="text-right">{{ date_dmy($data->rental_date) }}</td>
                <td class="text-right">{{ $data->monthly_rent }}</td>
                <td>{{ $data->description }}</td>
                <td class="text-center">
                    <a class="btn btn-info btn-xs" href="party/{{ $data->id }}/edit"><i class="fa fa-edit"></i> Edit</a>
                </td>
                <?php if (has_user_access('rental_party_delete')) : ?>
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