<?php if (has_user_access('permission_bag')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/bag') }}">{{ trans('words.dashboard') }}</a>
        </li>

        <?php if (has_user_access('bag_category')) : ?>
            <li><a href="{{ url('/bag/category') }}">{{ trans('words.category') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('bag_product')) : ?>
            <li><a href="{{ url('/bag/product') }}">{{ trans('words.products') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('bag_production')) : ?>
            <li><a href="{{ url('/bag/production') }}">{{ trans('words.production') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('purchase_list')) : ?>
            <li><a href="{{ url('/bag/purchase') }}">{{ trans('words.purchase') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('sale_list')) : ?>
            <li><a href="{{ url('/bag/sale') }}">{{ trans('words.sales') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('bag_stocks')) : ?>
            <li><a href="{{ url('/bag/stock') }}">{{ trans('words.stocks') }}</a></li>
        <?php endif; ?>                    
    </ul>
<?php endif; ?>