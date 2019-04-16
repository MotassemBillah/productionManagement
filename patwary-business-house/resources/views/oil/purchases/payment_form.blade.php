<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close"><span aria-hidden="true">x</span></button>
            <div class="modal-title">
                <strong>Supplier :</strong> <?= !empty($model->particular_id) ? $model->particularName($model->particular_id) : ""; ?>
                <strong style="margin-left: 15px;">Invoice No :</strong>  <?= $model->invoice_no; ?>
            </div>
            <div id="ajaxModalMessage" class="alert" style="display: none"></div>
        </div>
        {!! Form::open(['method' => 'POST', 'url' => '', 'id'=>'frmPayment', 'class' => 'form-horizontal']) !!}
        <input type="hidden" name="purchase_id" value="<?= $model->id; ?>">
        <div class="modal-body" style="max-height:440px;overflow-y:auto;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="datepicker" class="col-md-3">Date</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" id="datepicker" class="form-control pickdate" name="transaction_date" placeholder="(dd-mm-yyyy)" value="<?= !empty($payment->pay_date) ? date_dmy($payment->pay_date) : date('d-m-Y'); ?>" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                  
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-md-3">Description</label>
                        <div class="col-md-8">                    
                            <textarea id="description" class="form-control" name="description">{{ $payment->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="by_whom" class="col-md-3">By Whom</label>
                        <div class="col-md-8">
                            <input type="text" id="by_whom" class="form-control" name="by_whom" value="{{ $payment->by_whom }}">
                        </div>               
                    </div>
                    <div class="form-group">
                        <label style="margin-top: 20px;" for="debit_amount" class="col-md-3">Amount</label>
                        <div class="col-md-8">
                            <span style="font-style:italic;">( Max Amount is: <?= $model->invoice_amount; ?> )</span>
                            <div class="input-group">                
                                <input type="number" id="debit_amount" class="form-control" name="amount" min="0" max="<?= $model->invoice_amount; ?>" value="{{ $payment->amount }}" required>
                                <span class="input-group-addon">Tk</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-3 control-label">From</label>
                        <div class="col-md-8">
                            <select id="headDebit" class="form-control" name="frm_subhead" required>
                                <option value="">Select Head</option>
                                @foreach($subhead->all() as $head)
                                <option value="{{$head->id}}" @if($payment->cr_subhead_id == $head->id) {{ 'selected' }}@endif>{{$head->name}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('frm_subhead') }}</small>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="subheadDebit" class="col-md-3"></label>
                        <div class="col-md-8">
                            <select id="subheadDebit" class="form-control" name="frm_particular">
                                <option value="">Select Sub Head</option>
                                @foreach($particular->where('subhead_id',$payment->cr_subhead_id)->get() as $pt)
                                <option value="{{$pt->id}}" @if($payment->cr_particular_id == $pt->id) {{ 'selected' }} @endif>{{$pt->name}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">To</label>
                        <div class="col-md-8">
                            <select id="headCredit" class="form-control" name="to_subhead" required>
                                <option value="">Select Head</option>
                                @foreach($subhead->all() as $head)
                                <option value="{{$head->id}}" @if($model->subhead_id == $head->id) {{ 'selected' }}@endif>{{$head->name}}</option>
                                @endforeach
                            </select>
                            <small class="text-danger">{{ $errors->first('to_subhead') }}</small>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="subheadCredit" class="col-md-3"></label>
                        <div class="col-md-8">
                            <select id="subheadCredit" class="form-control" name="to_particular">
                                <option value="">Select Sub Head</option>
                                @foreach($particular->where('subhead_id',$model->subhead_id)->get() as $pt)
                                <option value="{{$pt->id}}" @if($model->particular_id == $pt->id) {{ 'selected' }} @endif>{{$pt->name}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
        <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-info" data-dismiss="modal" aria-label="Close" title="Close">Cancel</button>
            <button type="button" class="btn btn-primary" id="savePayment">Save</button>
        </div>
        {!! Form::close() !!} 
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#datepicker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $(document).on("change", "#headDebit", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subheadDebit");
                    $('#subheadDebit').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("change", "#headCredit", function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ URL::to('subhead/particular') }}",
                type: "post",
                data: {'head': id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
                    enable("#subheadCredit");
                    $('#subheadCredit').html(data);
                },
                error: function (xhr, status) {
                    alert('There is some error.Try after some time.');
                }
            });
        });

        $(document).on("click", "#savePayment", function (e) {
            e.preventDefault();
            var _form = $("#frmPayment");
            var _url = "{{ URL::to('purchase/payment/update') }}";

            $.post(_url, _form.serialize(), function (response) {
                if (response.success === true) {                    
                    $('#ajaxModalMessage').showAjaxMessage({html: response.message, type: 'success'});
                    location.reload();
                } else {
                    $('#ajaxModalMessage').showAjaxMessage({html: response.message, type: 'error'});
                }
            },"json");
            e.preventDefault();
            return false;
            
        });
    });
</script>