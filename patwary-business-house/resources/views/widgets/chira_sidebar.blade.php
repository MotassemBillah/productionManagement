<?php if (has_user_access('permission_chiramill')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/chira') }}">{{ trans('words.dashboard') }}</a>
        </li>

        <?php if (has_user_access('chira_category')) : ?>
            <li><a href="{{ url('/chira/category') }}">{{ trans('words.category') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('chira_product')) : ?>
            <li><a href="{{ url('/chira/product') }}">{{ trans('words.products') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('chira_production')) : ?>
            <li><a href="{{ url('/chira/production') }}">{{ trans('words.production') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('purchase_list')) : ?>
            <li><a href="{{ url('/chira/purchase') }}">{{ trans('words.purchase') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('sale_list')) : ?>
            <li><a href="{{ url('/chira/sale') }}">{{ trans('words.sales') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('chira_stocks')) : ?>
            <li><a href="{{ url('/chira/stock') }}">{{ trans('words.stocks') }}</a></li>
        <?php endif; ?>            
    </ul>
<?php endif; ?>