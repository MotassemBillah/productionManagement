@extends('layouts.app')

@section('content')
<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('/')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">Create New Supplier Transaction</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Transaction</span></li>
        </ul>                            
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">Transaction Information</div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'url' => 'supplier-transaction', 'id' => 'frmCustomerTransaction', 'class' => 'form-horizontal']) !!} 
            {{ csrf_field() }} 

            <div class="form-group">
                <label for="datepicker" class="col-md-4 control-label">Pay Date</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="datepicker" class="form-control pickdate" name="pay_date" placeholder="(dd-mm-yyyy)" value="<?= date('d-m-Y'); ?>" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <small class="text-danger">{{ $errors->first('pay_date') }}</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="supplier" class="col-md-4 control-label">Supplier</label>
                <div class="col-md-6">
                    <select id="CustomerTransaction_customer_id" class="form-control" name="supplier_id">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{$supplier->id}}">{{ $supplier->agent_name }} ({{ $supplier->agent_code }}) </option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('supplier_id') }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Payment Type</label>
                <div class="col-md-6">
                    <label class="txt_np" for="advance"><input value="advance" id="advance" class="chk_no_mvam btn_pay_type" type="radio" name="transaction_type" checked="checked">&nbsp;Advance</label>
                    <label class="txt_np" for="due_paid"><input value="due paid" id="due_paid" class="chk_no_mvam btn_pay_type" type="radio" name="transaction_type">&nbsp;Due Pay</label>
                    <label class="txt_np" for="previous_due"><input value="previous due" id="previous_due" class="chk_no_mvam btn_pay_type" type="radio" name="transaction_type">&nbsp;Add Previous Due</label>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">Payment Method</label>
                <div class="col-md-6">
                    <label for="CustomerTransaction_payment_method_cash" style="font-weight: normal"><input type="radio" class="chk_no_mvam pay_mode" id="CustomerTransaction_payment_method_cash" name="payment_method" value="Cash Payment" checked>&nbsp;Cash Payment</label>
                    <label for="CustomerTransaction_payment_method_cheque" style="font-weight: normal"><input type="radio" class="chk_no_mvam pay_mode" id="CustomerTransaction_payment_method_cheque" name="payment_method" value="Bank Payment">&nbsp;Bank Payment</label>
                    <label for="CustomerTransaction_payment_method_no" style="font-weight: normal"><input type="radio" class="chk_no_mvam pay_mode" id="CustomerTransaction_payment_method_no" name="payment_method" value="No Payment">&nbsp;No Payment</label>
                </div>
            </div>
            <div id="bankOption" style="display: none;">
                <div class="form-group">
                    <label for="bank" class="col-md-4 control-label">Bank Name</label>
                    <div class="col-md-6">
                        <select id="bank" class="form-control" name="bank">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="check_no" class="col-md-4 control-label">Cheque No</label>
                    <div class="col-md-6">
                        <input type="text" id="check_no" class="form-control" name="check_no">
                    </div>
                </div>
            </div>
            <div class="form-group" id="due_info">
                <label for="invoice_due" class="col-md-4 control-label">Due Amount</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" id="CustomerTransaction_invoice_due" class="form-control" name="invoice_due" readonly>
                        <span class="input-group-addon">Tk</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="invoice_advance" class="col-md-4 control-label">Amount</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="number" id="invoice_advance" class="form-control" name="amount" min="0">
                        <span class="input-group-addon">Tk</span>
                    </div>
                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" id="reset_from" class="btn btn-info">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!} 

<script type="text/javascript">
    $(document).ready(function () {

        $("#reset_from").click(function () {
            var _form = $("#frmCompany");
            _form[0].reset();
        });

        $(document).on("change", ".btn_pay_type", function () {
            if ($(this).val() == "previous due") {
                disable(".pay_mode");
                enable("#CustomerTransaction_payment_method_no");
                $("#CustomerTransaction_payment_method_no").prop("checked", true);
                $("#bankOption").slideUp(200);
                var _bank = document.getElementById('CustomerTransaction_bank_setting_id');
                _bank.selectedIndex = 0;
                $("#CustomerTransaction_check_no").val("");
            } else {
                enable(".pay_mode");
                $("#CustomerTransaction_payment_method_cash").prop("checked", true);
            }
        });

        $(document).on("change", ".pay_mode", function () {
            if ($(this).val() == "Bank Payment") {
                $("#bankOption").slideDown(200);
            } else {
                $("#bankOption").slideUp(200);
                var _bank = document.getElementById('CustomerTransaction_bank_setting_id');
                _bank.selectedIndex = 0;
                $("#CustomerTransaction_check_no").val("");
            }
        });

        $(document).on("change", "#CustomerTransaction_customer_id, .btn_pay_type", function (e) {
            var _cusID = $("#CustomerTransaction_customer_id").val();
            var _type = $(".btn_pay_type:checked").val();
            var _url = "{{ url('supplier-transaction/get_info')}}";

            if (_type == "due paid") {
                $.post(_url, {cusID: _cusID, tp: _type, ajax: true, _token: "{{ csrf_token() }}"}, function (res) {
                    if (res.success === true) {
                        $("#CustomerTransaction_invoice_due").val(res.due);
                    } else {
                        $("#CustomerTransaction_invoice_due").val('');
                    }
                }, "json");
            } else {
                $("#CustomerTransaction_invoice_due").val('');
            }

            e.preventDefault();
            return false;
        });
    });

</script>
@endsection