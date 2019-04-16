<?php if (has_user_access('permission_inv')) : ?>
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/inv') }}">{{ trans('words.dashboard') }}</a>
        </li>

        <?php if (has_user_access('inv_category')) : ?>
            <li><a href="{{ url('/inv/category') }}">{{ trans('words.category') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('inv_product')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage_product"><i class="fa fa-cart-plus"></i> {{ trans('words.products') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage_product" class="collapse">
                    <li><a href="{{ url('/inv/product') }}">{{ trans('words.product_list') }}</a></li>
                    <li><a href="{{ url('/inv/product/stock') }}">{{ trans('words.product_stock') }}</a></li>
                    <li><a href="{{ url('/inv/product/ledger') }}">{{ trans('words.product_ledger') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('inv_purchase')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage_purchase"><i class="fa fa-cart-plus"></i> {{ trans('words.purchase') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage_purchase" class="collapse">
                    <li><a href="{{ url('/inv/purchase') }}">{{ trans('words.purchase_list') }}</a></li>
                    <li><a href="{{ url('/inv/purchase/cart') }}">{{ trans('words.purchase_cart') }}</a></li>
                    <li><a href="{{ url('/inv/purchase-return') }}">{{ trans('words.purchase_return') }}</a></li>
                    <li><a href="{{ url('/inv/purchase-return/cart') }}">{{ trans('words.purchase_return_cart') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('inv_sales')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage_sales"><i class="fa fa-cart-plus"></i> {{ trans('words.sales') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage_sales" class="collapse">
                    <li><a href="{{ url('inv/sale') }}">  {{ trans('words.sale_list') }}</a></li>
                    <li><a href="{{ url('/inv/sale/cart') }}">{{ trans('words.sale_cart') }}</a></li>
                    <li><a href="{{ url('/inv/sale-return') }}">{{ trans('words.sale_return') }}</a></li>
                    <li><a href="{{ url('/inv/sale-return/cart') }}">{{ trans('words.sale_return_cart') }}</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#manage_reporting"><i class="fa fa-book"></i> {{ trans('words.reporting') }} <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="manage_reporting" class="collapse">
                <li><a href="{{ url('/inv/category') }}">{{ trans('words.category_report') }}</a></li>
                <li><a href="{{ url('/inv/product/stock') }}">{{ trans('words.product_stock_report') }}</a></li>
                <li><a href="{{ url('/inv/product/ledger') }}">{{ trans('words.product_ledger_report') }}</a></li>
            </ul>
        </li>
    </ul>
<?php endif; ?>