<?php if (has_user_access('permission_oven')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/oven') }}">{{ trans('words.dashboard') }}</a>
        </li>
        <?php if (has_user_access('setting')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#setting"><i class="fa fa-fw fa-cogs"></i> {{ trans('words.settings') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="setting" class="collapse">
                </ul>
            </li>
        <?php endif; ?>

        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#product"><i class="fa fa-fw fa-shopping-cart"></i> {{ trans('words.products') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="product" class="collapse">
                <li><a href="{{ url('oven/rawcategory') }}">{{ trans('words.rawcategory') }}</a></li>
                <li><a href="{{ url('oven/rawproduct') }}">{{ trans('words.rawproduct') }}</a></li>
                <li><a href="{{ url('oven/finishcategory') }}">{{ trans('words.finishcategory') }}</a></li>
                <li><a href="{{ url('oven/finishproduct') }}">{{ trans('words.finishproduct') }}</a></li>
            </ul>
        </li>

        <?php if (has_user_access('oven_manage_purchase')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-order"><i class="fa fa-plus"></i> {{ trans('words.purchase') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-order" class="collapse">
                    <?php if (has_user_access('oven_purchase_challan')) : ?>
                        <li><a href="{{ url('oven/purchase-challan') }}">{{ trans('words.purchase_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('oven_manage_sales')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-sales"><i class="fa fa-cart-plus"></i> {{ trans('words.sales') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-sales" class="collapse">
                    <?php if (has_user_access('oven_sale_challan')) : ?>
                        <li><a href="{{ url('oven/sales-challan') }}">{{ trans('words.sales_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>  
        <?php if (has_user_access('oven_manage_production')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#production"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="production" class="collapse">
                    <?php if (has_user_access('oven_manage_production')) : ?>
                        <li><a href="{{ url('oven/production') }}"> {{ trans('words.production_order') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('oven_manage_production')) : ?>
                        <li><a href="{{ url('oven/production-list') }}"> {{ trans('words.production_order_list') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('oven_manage_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#rawStock"><i class="fa fa-folder-open"></i> {{ trans('words.raw_stock') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="rawStock" class="collapse">
                    <li><a href="{{ url('oven/rawstocks') }}"> {{ trans('words.raw_stock') }}</a></li>
                    <li><a href="{{ url('oven/rawstocks/details') }}"> {{ trans('words.raw_stock_details') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('oven_manage_finishgoods')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#finishgoods"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.finish_goods') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="finishgoods" class="collapse">
                    <?php if (has_user_access('oven_manage_finishgoods')) : ?>
                        <li><a href="{{ url('oven/finishgoods') }}"> {{ trans('words.finish_goods_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('oven_manage_finishgoods')) : ?>
                        <li><a href="{{ url('oven/finishgoods-list') }}"> {{ trans('words.finish_goods_ledger') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('oven_manage_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#finishStock"><i class="fa fa-folder-open"></i> {{ trans('words.finish_stock') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="finishStock" class="collapse">
                    <li><a href="{{ url('oven/finishstocks') }}"> {{ trans('words.finish_stock') }}</a></li>
                    <li><a href="{{ url('oven/finishstocks/details') }}"> {{ trans('words.finish_stock_details') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('manage_user')) : ?>
            <li>
                <a href="{{ url('/user') }}"><i class="fa fa-user"></i> {{ trans('words.user_list') }}</a>
            </li>
        <?php endif; ?>

    </ul>
<?php endif; ?>