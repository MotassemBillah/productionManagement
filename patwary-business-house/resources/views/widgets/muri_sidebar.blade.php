<?php if (has_user_access('permission_murimill')) : ?>        
    <ul class="nav navbar-nav side-nav"> 
        <li>
            <a href="{{ url('/muri') }}">{{ trans('words.dashboard') }}</a>
        </li>

        <?php if (has_user_access('muri_category')) : ?>
            <li><a href="{{ url('/muri/category') }}">{{ trans('words.category') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('muri_product')) : ?>
            <li><a href="{{ url('/muri/product') }}">{{ trans('words.products') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('muri_production')) : ?>
            <li><a href="{{ url('/muri/production') }}">{{ trans('words.production') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('purchase_list')) : ?>
            <li><a href="{{ url('/muri/purchase') }}">{{ trans('words.purchase') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('sale_list')) : ?>
            <li><a href="{{ url('/muri/sale') }}">{{ trans('words.sales') }}</a></li>
        <?php endif; ?>

        <?php if (has_user_access('muri_stocks')) : ?>
            <li><a href="{{ url('/muri/stock') }}">{{ trans('words.stocks') }}</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>