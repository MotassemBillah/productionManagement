<?php if (has_user_access('permission_rice')) : ?>
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/rice') }}"><i class="fa fa-dashboard"></i> {{ trans('words.dashboard') }}</a>
        </li>

        <?php if (has_user_access('setting')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#setting"><i class="fa fa-fw fa-cogs"></i> {{ trans('words.settings') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="setting" class="collapse">
                    <?php if (has_user_access('rice_drawer_setting')) : ?>
                        <li><a href="{{ url('rice/drawers') }}">{{ trans('words.drawer_setting') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_godown_setting')) : ?>
                        <li><a href="{{ url('rice/godowns') }}">{{ trans('words.godown_setting') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_emptybag_setting')) : ?>
                        <li><a href="{{ url('rice/emptybag-setting') }}">{{ trans('words.emptybag_setting') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('rice_manage_product')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#product"><i class="fa fa-fw fa-shopping-cart"></i> {{ trans('words.products') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="product" class="collapse">
                    <?php if (has_user_access('rice_category')) : ?>
                        <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                    <?php endif; ?>

                    <?php if (has_user_access('rice_product')) : ?>
                        <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                    <?php endif; ?>

                    <?php if (has_user_access('rice_after_production')) : ?>
                        <li><a href="{{ url('/rice/after-production') }}">{{ trans('words.after_production') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('rice_manage_purchase')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-order"><i class="fa fa-plus"></i> {{ trans('words.purchase') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-order" class="collapse">
                    <?php /* if (has_user_access('rice_manage_purchase')) : ?>
                        <li><a href="{{ url('rice/purchases') }}">{{ trans('words.purchase_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_manage_purchase')) : ?>
                        <li><a href="{{ url('rice/purchase/ledger') }}">{{ trans('words.purchase_ledger') }}</a></li>
                    <?php endif; */ ?>
                    <?php if (has_user_access('rice_purchase_challan')) : ?>
                        <li><a href="{{ url('rice/purchase-challan') }}">{{ trans('words.purchase_challan') }}</a></li>
                    <?php endif; ?>
                    <?php /* if (has_user_access('rice_manage_purchase')) : ?>
                        <li><a href="{{ url('rice/purchase/stocks') }}">{{ trans('words.purchase_stocks') }}</a></li>
                    <?php endif; */ ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('rice_manage_sales')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-sales"><i class="fa fa-cart-plus"></i> {{ trans('words.sales') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-sales" class="collapse">
                    <?php /* if (has_user_access('rice_manage_sales')) : ?>
                        <li><a href="{{ url('rice/sales') }}">  {{ trans('words.sale_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_manage_sales')) : ?>
                        <li><a href="{{ url('rice/sale/ledger') }}">  {{ trans('words.sale_ledger') }}</a></li>
                    <?php endif; */ ?>
                    <?php if (has_user_access('rice_sale_challan')) : ?>
                        <li><a href="{{ url('rice/sales-challan') }}">{{ trans('words.sales_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php /* if (has_user_access('rice_empty_bags')) : ?>
            <li><a href="{{ url('rice/emptybags') }}"><i class="fa fa-cart-plus"></i> {{ trans('words.empty_bags') }}</a></li>
        <?php endif; */ ?>    
        <?php if (has_user_access('rice_manage_production')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#production"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="production" class="collapse">
                    <?php if (has_user_access('rice_manage_production')) : ?>
                        <li><a href="{{ url('rice/production') }}"> {{ trans('words.production_order') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_manage_production')) : ?>
                        <li><a href="{{ url('rice/production-list') }}"> {{ trans('words.production_order_list') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('rice_production_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#productionStock"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production_stocks') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="productionStock" class="collapse">
                    <?php if (has_user_access('rice_production_stocks')) : ?>
                        <li><a href="{{ url('rice/production-stocks/report') }}"> {{ trans('words.production_stocks') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_production_stocks')) : ?>
                        <li><a href="{{ url('rice/production-stocks') }}"> {{ trans('words.production_stocks_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('rice_production_stocks')) : ?>
                        <li><a href="{{ url('rice/production-stocks/details') }}"> {{ trans('words.production_stocks_details') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('rice_manage_stocks')) : ?>
            <li>
                <a href="{{ url('rice/stocks') }}"><i class="fa fa-shopping-cart"></i> {{ trans('words.stocks') }}</a>
            </li>
<!--            <li>
                <a href="{{ url('rice/stock-register') }}"><i class="fa fa-shopping-cart"></i> {{ trans('words.stock_register') }}</a>
            </li>-->
        <?php endif; ?>
        <?php if (has_user_access('manage_user')) : ?>
            <li>
                <a href="{{ url('/user') }}"><i class="fa fa-user"></i> {{ trans('words.user_list') }}</a>
            </li>
        <?php endif; ?>

    </ul>
<?php endif; ?>