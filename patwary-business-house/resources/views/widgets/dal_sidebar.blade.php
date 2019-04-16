<?php if (has_user_access('permission_dal')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/dal') }}">{{ trans('words.dashboard') }}</a>
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
                <li><a href="{{ url('dal/rawcategory') }}">{{ trans('words.rawcategory') }}</a></li>
                <li><a href="{{ url('dal/rawproduct') }}">{{ trans('words.rawproduct') }}</a></li>
                <li><a href="{{ url('dal/finishcategory') }}">{{ trans('words.finishcategory') }}</a></li>
                <li><a href="{{ url('dal/finishproduct') }}">{{ trans('words.finishproduct') }}</a></li>
            </ul>
        </li>

        <?php if (has_user_access('dal_manage_purchase')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-order"><i class="fa fa-plus"></i> {{ trans('words.purchase') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-order" class="collapse">
                    <?php if (has_user_access('dal_purchase_challan')) : ?>
                        <li><a href="{{ url('dal/purchase-challan') }}">{{ trans('words.purchase_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('dal_manage_sales')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-sales"><i class="fa fa-cart-plus"></i> {{ trans('words.sales') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-sales" class="collapse">
                    <?php if (has_user_access('dal_sale_challan')) : ?>
                        <li><a href="{{ url('dal/sales-challan') }}">{{ trans('words.sales_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>  
        <?php if (has_user_access('dal_manage_production')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#production"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="production" class="collapse">
                    <?php if (has_user_access('dal_manage_production')) : ?>
                        <li><a href="{{ url('dal/production') }}"> {{ trans('words.production_order') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('dal_manage_production')) : ?>
                        <li><a href="{{ url('dal/production-list') }}"> {{ trans('words.production_order_list') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('dal_manage_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#rawStock"><i class="fa fa-folder-open"></i> {{ trans('words.raw_stock') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="rawStock" class="collapse">
                    <li><a href="{{ url('dal/rawstocks') }}"> {{ trans('words.raw_stock') }}</a></li>
                    <li><a href="{{ url('dal/rawstocks/details') }}"> {{ trans('words.raw_stock_details') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('dal_manage_finishgoods')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#finishgoods"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.finish_goods') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="finishgoods" class="collapse">
                    <?php if (has_user_access('dal_manage_finishgoods')) : ?>
                        <li><a href="{{ url('dal/finishgoods') }}"> {{ trans('words.finish_goods_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('dal_manage_finishgoods')) : ?>
                        <li><a href="{{ url('dal/finishgoods-list') }}"> {{ trans('words.finish_goods_ledger') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('dal_manage_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#finishStock"><i class="fa fa-folder-open"></i> {{ trans('words.finish_stock') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="finishStock" class="collapse">
                    <li><a href="{{ url('dal/finishstocks') }}"> {{ trans('words.finish_stock') }}</a></li>
                    <li><a href="{{ url('dal/finishstocks/details') }}"> {{ trans('words.finish_stock_details') }}</a></li>
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