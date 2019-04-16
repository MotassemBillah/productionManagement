@extends('admin.layouts.column1')
@section('content')

<div id="breadcrumbBar" class="breadcrumb site_nav_links no_bdr_rad clearfix">
    <div class="col-md-3 col-sm-3 col-xs-2 cxs_2 no_pad">
        <button class="btn btn-info btn-xs" type="button" onclick="history.back()" title="Go Back"><span class="visible-xs"><i class="fa fa-arrow-left"></i></span><span class="hidden-xs">Back</span></button>
        <button class="btn btn-info btn-xs" onclick="redirectTo('{{url('view - clear')}}')" title="Refresh" type="button"><span class="visible-xs"><i class="fa fa-refresh"></i></span><span class="hidden-xs">Refresh</span></button>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6 cxs_10 text-center">
        <h2 class="page-title">{{ $data->name }} Ledger Details</h2>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-4 cxs_12 no_pad">
        <ul class="text-right no_mrgn">
            <li><a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a> <span class="divider">/</span></li><li><span><i class="fa fa-file"></i> Ledger</span></li>
        </ul>                            
    </div>
</div>
<!-- Show List-->
<div id="ajax_content">
    <?php if (!empty($data) && count($data) > 0) : ?>
        <div class="table-responsive" id="print_area">
            {{ print_header("$data->name Ledger Details", true, true) }}
            <table class="table table-bordered tbl_thin" id="check">
                <tbody>
                    <tr class="bg_gray" id="r_checkAll">
                        <th class="text-center" style="width:5%;">SL#</th>
                        <th>Head Name</th>
                        <th class="text-right" style="width:120px;">Debit</th>
                        <th class="text-right" style="width:120px;">Credit</th>
                        <th class="text-right" style="width:120px;">Balance</th>
                    </tr>
                    <?php $counter = 0; ?>
                    <?php
                    $counter++;
                    $total_debit = 0;
                    $total_credit = 0;
                    $total_balance = 0;
                    $total_partdebit = 0;
                    $total_partcredit = 0;
                    $total_partbalance = 0;
                    ?>   
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td>{{ $data->name }}</td>
                        <td class="text-right">{{ $tmodel->headDebit($data->id) }}</td>
                        <td class="text-right">{{ $tmodel->headCredit($data->id) }}</td>
                        <td class="text-right">{{ $tmodel->sumHeadBalance($data->id) }}</td>                    
                    </tr>
                    <?php if (!empty($data->subhead)): ?> 
                        @foreach ($data->subhead as $item)
                        <?php
                        $total_debit += $_subdebit = $tmodel->sumSubDebit($item->id);
                        $total_credit += $_subcredit = $tmodel->sumSubCredit($item->id);
                        $total_balance += $_subbalance = $tmodel->sumSubBalance($item->id);
                        ?>
                        <tr>
                            <td></td>
                            <td title="View All Transaction" style="padding-left: 30px;">{{ $item->name }}</td>
                            <td class="text-right">{{ $_subdebit }}</td>
                            <td class="text-right">{{ $_subcredit }}</td>
                            <td class="text-right">{{ $_subbalance }}</td>
                        </tr>
                        <?php if (!empty($item->particular)): ?>                         
                            @foreach ($item->particular as $part)
                            <?php
                            $total_partdebit += $_subpartdebit = $tmodel->sumPartDebit($part->id);
                            $total_partcredit += $_subpartcredit = $tmodel->sumPartCredit($part->id);
                            $total_partbalance += $_subpartbalance = $tmodel->sumPartBalance($part->id);
                            ?>
                            <tr>
                                <td></td>
                                <td style="padding-left: 60px;">{{ $part->name }}, {{ $part->address }}, {{ $part->mobile }}</td>
                                <td class="text-right">{{ $_subpartdebit }}</td>
                                <td class="text-right">{{ $_subpartdebit }}</td>
                                <td class="text-right">{{ $_subpartdebit }}</td>
                            </tr>
                            @endforeach
                        <?php endif; ?> 
                        @endforeach
                        <tr class="bg_gray">
                            <th class="text-right" colspan="2">Sub Total:</th>
                            <th class="text-right">{{ $total_debit }}</th>
                            <th class="text-right">{{ $total_credit }}</th>
                            <th class="text-right">{{ $total_balance }}</th>
                        </tr>
                    <?php endif; ?> 
                </tbody>
            </table>
        </div>
        <div class="text-center" style="">
            <button class="btn btn-primary" onclick="printDiv('print_area')"><i class="fa fa-print"></i> Print</button>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No records found!</div>
    <?php endif; ?>
</div>
@endsection