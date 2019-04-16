<?php if (has_user_access('permission_rental')) : ?>        
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="{{ url('/rental') }}"><i class="fa fa-dashboard"></i> {{ trans('words.dashboard') }}</a>
        </li>
        <?php if (has_user_access('rental_building')) : ?>
            <li><a href="{{ url('/rental/building') }}"><i class="fa fa-home"></i> {{ trans('words.building') }}</a></li>
        <?php endif; ?>
        <?php if (has_user_access('rental_floor')) : ?>
            <li><a href="{{ url('/rental/floor') }}"><i class="fa fa-road"></i> {{ trans('words.floor') }}</a></li>
        <?php endif; ?>
        <?php if (has_user_access('rental_flat')) : ?>
            <li><a href="{{ url('/rental/flat') }}"><i class="fa fa-area-chart"></i> {{ trans('words.flat') }}</a></li>
        <?php endif; ?>
        <?php if (has_user_access('rental_party')) : ?>
            <li><a href="{{ url('/rental/party') }}"><i class="fa fa-users"></i> {{ trans('words.party') }}</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>