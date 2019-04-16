@extends('admin.layouts.column1')
<?php

use App\Models\Institute;

$_companies = Institute::get();
?>
@section('content')
<div class="row clearfix">
    <?php
    foreach ($_companies as $key => $val):
        $_icon = "img/dashicon/{$val->businessPrefix($val->business_type_id)}" . ".jpg";
        ?>
    <?php if (has_user_access("permission_" . "{$val->businessPrefix($val->business_type_id)}")): ?>
            <div class="col-md-3 col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><a href="<?= $val->businessPrefix($val->business_type_id) ?>"><?= $val->name; ?></a></h3>
                    </div>
                    <div class="panel-body">
                        <a href="<?= $val->businessPrefix($val->business_type_id) ?>">
                            <img alt="" class="img-responsive" src="{{asset($_icon)}}" style="height:165px;width:100%">
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php endforeach; ?>
</div>
@endsection