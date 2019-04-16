<?php if (has_user_access('permission_flour')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/flour') }}">{{ trans('words.dashboard') }}</a>
        </li>
        <?php if (has_user_access('setting')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#setting"><i class="fa fa-fw fa-cogs"></i> {{ trans('words.settings') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="setting" class="collapse">
                    <?php if (has_user_access('flour_drawer_setting')) : ?>
                        <li><a href="{{ url('flour/drawers') }}">{{ trans('words.house_setting') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('flour_godown_setting')) : ?>
                        <li><a href="{{ url('flour/godowns') }}">{{ trans('words.godown_setting') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('flour_emptybag_setting')) : ?>
                        <li><a href="{{ url('flour/emptybag-setting') }}">{{ trans('words.emptybag_setting') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('flour_manage_product')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#product"><i class="fa fa-fw fa-shopping-cart"></i> {{ trans('words.products') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="product" class="collapse">
                    <?php if (has_user_access('flour_category')) : ?>
                        <li><a href="{{ url('/flour/category') }}">{{ trans('words.category') }}</a></li>
                    <?php endif; ?>

                    <?php if (has_user_access('flour_product')) : ?>
                        <li><a href="{{ url('/flour/product') }}">{{ trans('words.products') }}</a></li>
                    <?php endif; ?>

                    <?php if (has_user_access('flour_after_production')) : ?>
                        <li><a href="{{ url('/flour/after-production') }}">{{ trans('words.after_production') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (has_user_access('flour_manage_purchase')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-order"><i class="fa fa-plus"></i> {{ trans('words.purchase') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-order" class="collapse">
                    <?php /*
                      <?php if (has_user_access('flour_manage_purchase')) : ?>
                      <li><a href="{{ url('flour/purchases') }}">{{ trans('words.purchase_list') }}</a></li>
                      <?php endif; ?>
                      <?php if (has_user_access('flour_manage_purchase')) : ?>
                      <li><a href="{{ url('flour/purchase/ledger') }}">{{ trans('words.purchase_ledger') }}</a></li>
                      <?php endif; ?>
                      <?php if (has_user_access('flour_manage_purchase')) : ?>
                      <li><a href="{{ url('flour/purchase/stocks') }}">{{ trans('words.purchase_stocks') }}</a></li>
                      <?php endif; ?>
                     */ ?>
                    <?php if (has_user_access('flour_purchase_challan')) : ?>
                        <li><a href="{{ url('flour/purchase-challan') }}">{{ trans('words.purchase_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('flour_manage_sales')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#manage-sales"><i class="fa fa-cart-plus"></i> {{ trans('words.sales') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="manage-sales" class="collapse">
                    <?php /*
                      <?php if (has_user_access('flour_manage_sales')) : ?>
                      <li><a href="{{ url('flour/sales') }}">  {{ trans('words.sale_list') }}</a></li>
                      <?php endif; ?>
                      <?php if (has_user_access('flour_manage_sales')) : ?>
                      <li><a href="{{ url('flour/sale/ledger') }}">  {{ trans('words.sale_ledger') }}</a></li>
                      <?php endif; ?> */ ?>
                    <?php if (has_user_access('flour_sale_challan')) : ?>
                        <li><a href="{{ url('flour/sales-challan') }}">{{ trans('words.sales_challan') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php /*
          <?php if (has_user_access('flour_empty_bags')) : ?>
          <li><a href="{{ url('flour/emptybags') }}"><i class="fa fa-cart-plus"></i> {{ trans('words.empty_bags') }}</a></li>
          <?php endif; ?>
         * */ ?>  
        <?php if (has_user_access('flour_manage_production')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#production"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="production" class="collapse">
                    <?php if (has_user_access('flour_manage_production')) : ?>
                        <li><a href="{{ url('flour/production') }}"> {{ trans('words.production_order') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('flour_manage_production')) : ?>
                        <li><a href="{{ url('flour/production-list') }}"> {{ trans('words.production_order_list') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('flour_production_stocks')) : ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#productionStock"><i class="fa fa-fw fa-arrows-v"></i> {{ trans('words.production_stocks') }} <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="productionStock" class="collapse">
                    <?php if (has_user_access('flour_production_stocks')) : ?>
                        <li><a href="{{ url('flour/production-stocks/report') }}"> {{ trans('words.production_stocks') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('flour_production_stocks')) : ?>
                        <li><a href="{{ url('flour/production-stocks') }}"> {{ trans('words.production_stocks_list') }}</a></li>
                    <?php endif; ?>
                    <?php if (has_user_access('flour_production_stocks')) : ?>
                        <li><a href="{{ url('flour/production-stocks/details') }}"> {{ trans('words.production_stocks_details') }}</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (has_user_access('flour_manage_stocks')) : ?>
            <li>
                <a href="{{ url('flour/stocks') }}"><i class="fa fa-shopping-cart"></i> {{ trans('words.stocks') }}</a>
            </li>
            <?php /*
              <li>
              <a href="{{ url('flour/stock-register') }}"><i class="fa fa-shopping-cart"></i> {{ trans('words.stock_register') }}</a>
              </li>
             */ ?>
        <?php endif; ?>
        <?php if (has_user_access('manage_user')) : ?>
            <li>
                <a href="{{ url('/user') }}"><i class="fa fa-user"></i> {{ trans('words.user_list') }}</a>
            </li>
        <?php endif; ?>

    </ul>
<?php endif; ?>