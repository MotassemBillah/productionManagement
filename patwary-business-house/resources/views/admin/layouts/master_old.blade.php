@include('admin.layouts.header')

<?php if (is_Admin()) : ?>
    @include('admin.layouts.admin_sidebar')
<?php else: ?>
    @include('admin.layouts.institute_sidebar')
<?php endif; ?>

<div id="page-wrapper">
    <div class="container-fluid">
        <?php
        if (has_flash_message()):
            echo view_flash_message();
        endif;
        ?>
        <div class="alert" id="ajaxMessage" style="display:none;margin:0"></div>
        <div class="text-center btn-warning" id="loading_image"><img src="{{ asset('img/ajax-loader.gif') }}" alt="Loading...."> Loading... </div>
        @yield('content')
    </div>
</div>

@include('admin.layouts.footer')