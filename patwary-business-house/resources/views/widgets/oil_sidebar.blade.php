<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<ul class="nav navbar-nav side-nav">
    <li>
        <a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> {{ trans('words.admin_sidebar') }}</a>
    </li>

    <?php if (has_user_access('setting')) : ?>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#setting"><i class="fa fa-fw fa-wrench"></i> {{ trans('words.settings') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="setting" class="collapse">
                <?php if (has_user_access('generel_setting')) : ?>
                    <li><a href="{{ url('/general-setting') }}">{{ trans('words.general_setting') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <li>
        <a href="{{ url('/institute') }}"><i class="fa fa-fw fa-bar-chart-o"></i> {{ trans('words.institute_list') }}</a>
    </li>

    <?php if (has_user_access('manage_account')) : ?>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#manage-accounts"><i class="fa fa-book"></i> {{ trans('words.accounts') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="manage-accounts" class="collapse">
                <li><a href="{{ url('/dailyreport') }}">{{ trans('words.daily_report') }}</a></li>
                <li><a href="{{ url('/ledger/dailysheet') }}">{{ trans('words.daily_sheet') }}</a></li>
                <li><a href="{{ url('/financial-statement') }}">{{ trans('words.financial_statement') }}</a></li>
                <li><a href="{{ url('/head') }}">{{ trans('words.account_head') }}</a></li>
                <li><a href="{{ url('/subhead') }}">{{ trans('words.subhead') }}</a></li>
                <li><a href="{{ url('/particulars') }}">{{ trans('words.particular') }}</a></li>
                <li><a href="{{ url('/ledger') }}">{{ trans('words.ledger') }}</a></li>
                <li><a href="{{ url('/transactions') }}">{{ trans('words.all_transactions') }}</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('manage_user')) : ?>
        <li>
            <a href="{{ url('/user') }}"><i class="fa fa-fw fa-bar-chart-o"></i> {{ trans('words.user_list') }}</a>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_ricemill')) : ?>        
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#ricemill"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.ricemill') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="ricemill" class="collapse">
                <?php if (has_user_access('rice_category')) : ?>
                    <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_product')) : ?>
                    <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_production')) : ?>
                    <li><a href="{{ url('/rice/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('purchase_list')) : ?>
                    <li><a href="{{ url('/rice/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('sale_list')) : ?>
                    <li><a href="{{ url('/rice/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_stocks')) : ?>
                    <li><a href="{{ url('/rice/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_flourmill')) : ?>        
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#flourmill"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.flourmill') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="flourmill" class="collapse">
                <?php if (has_user_access('rice_category')) : ?>
                    <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_product')) : ?>
                    <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_production')) : ?>
                    <li><a href="{{ url('/rice/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('purchase_list')) : ?>
                    <li><a href="{{ url('/rice/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('sale_list')) : ?>
                    <li><a href="{{ url('/rice/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_stocks')) : ?>
                    <li><a href="{{ url('/rice/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_chiramill')) : ?>        
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#chiramill"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.chiramill') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="chiramill" class="collapse">
                <?php if (has_user_access('rice_category')) : ?>
                    <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_product')) : ?>
                    <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_production')) : ?>
                    <li><a href="{{ url('/rice/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('purchase_list')) : ?>
                    <li><a href="{{ url('/rice/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('sale_list')) : ?>
                    <li><a href="{{ url('/rice/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_stocks')) : ?>
                    <li><a href="{{ url('/rice/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_murimill')) : ?>        
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#murimill"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.murimill') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="murimill" class="collapse">
                <?php if (has_user_access('rice_category')) : ?>
                    <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_product')) : ?>
                    <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_production')) : ?>
                    <li><a href="{{ url('/rice/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('purchase_list')) : ?>
                    <li><a href="{{ url('/rice/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('sale_list')) : ?>
                    <li><a href="{{ url('/rice/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_stocks')) : ?>
                    <li><a href="{{ url('/rice/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_inventory')) : ?>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#inventory"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.inventory') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="inventory" class="collapse">
                <?php if (has_user_access('inv_category')) : ?>
                    <li><a href="{{ url('/inv/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('inv_product')) : ?>
                    <li><a href="{{ url('/inv/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('inv_production')) : ?>
                    <li><a href="{{ url('/inv/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('inv_purchase')) : ?>
                    <li><a href="{{ url('/inv/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('inv_sales')) : ?>
                    <li><a href="{{ url('/inv/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('inv_stocks')) : ?>
                    <li><a href="{{ url('/inv/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (has_user_access('permission_bag')) : ?>        
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#bag_production"><i class="fa fa-fw fa-cart-plus"></i> {{ trans('words.bag_production') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="bag_production" class="collapse">
                <?php if (has_user_access('rice_category')) : ?>
                    <li><a href="{{ url('/rice/category') }}">{{ trans('words.category') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_product')) : ?>
                    <li><a href="{{ url('/rice/product') }}">{{ trans('words.products') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_production')) : ?>
                    <li><a href="{{ url('/rice/production') }}">{{ trans('words.production') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('purchase_list')) : ?>
                    <li><a href="{{ url('/rice/purchase') }}">{{ trans('words.purchase') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('sale_list')) : ?>
                    <li><a href="{{ url('/rice/sale') }}">{{ trans('words.sales') }}</a></li>
                <?php endif; ?>
                <?php if (has_user_access('rice_stocks')) : ?>
                    <li><a href="{{ url('/rice/stock') }}">{{ trans('words.stocks') }}</a></li>
                <?php endif; ?>
            </ul>
        </li>
    <?php endif; ?>
</ul>