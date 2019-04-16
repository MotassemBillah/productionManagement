@extends('admin.layouts.column1')
@section('content')
<?php
$_companies = [
    ["permission_name" => "permission_ricemill", "name" => "Rice Mill", "url" => "rice", "icon" => "rice.jpg"],
    ["permission_name" => "permission_flourmill", "name" => "Flour Mill", "url" => "flour", "icon" => "flour.jpg"],
    ["permission_name" => "permission_murimill", "name" => "Muri Mill", "url" => "muri", "icon" => "muri.jpg"],
    ["permission_name" => "permission_inventory", "name" => "Inventory", "url" => "inv", "icon" => "inventory.jpg"],
    ["permission_name" => "permission_bag", "name" => "Bag Production", "url" => "bag", "icon" => "bag.jpg"],
];
?>
<div class="row clearfix">
    <?php
    foreach ($_companies as $key => $val):
        $_icon = "img/dashicon/{$val['icon']}";
        ?>
        <?php if (has_user_access("{$val['permission_name']}")): ?>
            <div class="col-md-2 col-sm-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><a href="<?= $val['url']; ?>"><?= $val['name']; ?></a></h3>
                    </div>
                    <div class="panel-body">
                        <a href="<?= $val['url']; ?>">
                            <img alt="" class="img-responsive" src="{{asset($_icon)}}" style="height:165px;width:100%">
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
@endsection