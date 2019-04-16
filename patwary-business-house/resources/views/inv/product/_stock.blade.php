@if(!empty($dataset) && count($dataset) > 0)
<div class="table-responsive">
    <table class="table table-bordered tbl_thin" id="check">
        <tr class="bg-info" id="r_checkAll">
            <th class="text-center" style="width:4%;">SL#</th>
            <th>Business Type</th>
            <th>Category Name</th>
            <th>Product Type</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Size</th>
            <th class="text-center">Weight</th>
            <th class="text-center" style="width:80px;">O.Stock</th>
            <th class="text-center" style="width:80px;">Purchase</th>
            <th class="text-center" style="width:80px;">Sale</th>
            <th class="text-center" style="width:80px;">T.Stock</th>
        </tr>
        <?php
        $counter = 0;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $counter = ($_GET['page'] - 1) * $dataset->perPage();
        }
        ?>
        @foreach ($dataset as $data)
        <?php
        $counter++;
        $_ostock = $stockModel->opening_qty($data->id);
        $_pstock = $stockModel->purchase_qty($data->id);
        $_sstock = $stockModel->sale_qty($data->id);
        $_tstock = $stockModel->available_qty($data->id);
        ?>
        <tr onmouseover="change_color(this, true)" onmouseout="change_color(this, false)">
            <td class="text-center">{{ $counter }}</td>
            <td>{{ !empty($data->business_type) ? $data->business_type->business_type : "" }}</td>
            <td>{{ !empty($data->category) ? $data->category->name : "" }}</td>
            <td>{{ $data->type }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->unit }}</td>
            <td>{{ $data->size }}</td>
            <td class="text-center">{{ $data->weight }}</td>
            <td class="">{{$_ostock}} <span class="pull-right"><a class="ostock" href="javascript:void(0);" title="Click This Icon To Update Opening Stock" data-productid="<?= $data->id; ?>"><i class="fa fa-edit"></i></a></span></td>
            <td class="text-center">{{$_pstock}}</td>
            <td class="text-center">{{$_sstock}}</td>
            <td class="text-center">{{$_tstock}}</td>
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