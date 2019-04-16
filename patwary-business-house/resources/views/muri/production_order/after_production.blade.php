<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">After Completed Production List</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-6" style="margin-bottom:30px;">
            <div class="form-group">
                <label class="col-md-4 control-label">Date</label>
                <div class="col-md-6">
                    <input type="text" placeholder="(dd-mm-yyyy)" value="<?php echo date('d-m-Y'); ?>" class="form-control pickdate" name="date" readonly>
                    <small class="text-danger">{{ $errors->first('date') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="margin-bottom:30px;">
            <div class="form-group">
                <label class="col-md-4 control-label">Stocks No</label>
                <div class="col-md-6">
                    <input type="text" value="<?php echo App\ProductionStock::get_production_stocks_invoice(); ?>" class="form-control" name="production_stocks_no" readonly>
                    <small class="text-danger">{{ $errors->first('production_stocks_no') }}</small>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <tbody>
                <tr class="bg_gray">
                    <th>Product</th>
                    <th>Bag Weight(Kg)</th>
                    <th>Quantity(Bag)</th>
                    <th>Total Weight(Kg)</th>
                </tr> 
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}<input type="hidden" value="{{ $product->id }}" name="after_production_id[]" ></td> 
                    <td>{{ $product->weight }} <input type="hidden" class="form-control" id="bag_weight_{{ $product->id }}" name="per_qty_weight[{{ $product->id }}]"></td> 
                    <td><input type="number" min="0" class="form-control qty" id="quantity_{{ $product->id }}" data-weight ="{{ $product->weight }}" data-info="{{ $product->id }}" name="quantity[{{ $product->id }}]"></td>
                    <td><input type="number" class="form-control" id="net_weight_{{ $product->id }}" name="net_weight[{{ $product->id }}]" readonly></td> 
                </tr>   
                @endforeach                  
            </tbody>
        </table>
        <div class="text-center">
            <button class="btn btn-success">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}  
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.pickdate').datepicker({
            format: 'dd-mm-yyyy',
            //startDate: '-3d'
            autoclose: true,
            orientation: 'bottom'
        });
    });

    $(document).on("input", ".qty", function (e) {
        var id = $(this).attr('data-info');
        var qun = this.value;
        var total_weight = 0;
        var bag_weight = $(this).attr('data-weight');
        if (isNaN(bag_weight) || bag_weight == '') {
            bag_weight = 1;
        }
        total_weight = qun * bag_weight;
        document.getElementById("net_weight_" + id).value = total_weight;
        e.preventDefault();
    });


    // Check Measurement for Production Setting
    function check_measure_production(id) {
        var bag_weight = parseFloat(document.getElementById("bag_weight_" + id).value);
        var quantity = document.getElementById("quantity_" + id).value;

        if (isNaN(quantity))
        {
            quantity = 0;
        }
        if (isNaN(bag_weight))
        {
            bag_weight = 0;
        }

        var net_weight = quantity * bag_weight;
        if (isNaN(net_weight))
        {
            net_weight = 0;
        }
        document.getElementById("net_weight_" + id).value = net_weight;
    }

</script>