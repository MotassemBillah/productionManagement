<?php
$_fullUri = full_url();
$_uriArr = explode('/', $_fullUri);
$_route_prefix = ['bag', 'chira', 'dal', 'flour', 'oven', 'packaging', 'inv', 'muri', 'oil', 'rice'];
$_bd_class = body_class();
?>
@include('admin.layouts.header')

<?php if ($_bd_class == "column1"): ?>
    @include('admin.layouts.notification')
<?php endif; ?>

<div id="body_panel" style="">
    <div class="clearfix">
        <div class="clearfix" id="sidebar_area">
            <?php foreach ($_route_prefix as $_rpk => $_rpv): ?>
                <?php if (array_search($_rpv, $_uriArr)): ?>
                    <?php $_sidebar_file = "widgets.{$_rpv}_sidebar"; ?>
                    @include($_sidebar_file)
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="" id="content_area">
            <?php if ($_bd_class == "column2"): ?>
                <div class="row clearfix">
                    @include('admin.layouts.notification')
                </div>
            <?php endif; ?>

            @yield('content')
        </div>
    </div>
</div>

@include('admin.layouts.footer')