<div class="container-fluid">
    <?php
    if (has_flash_message()):
        echo view_flash_message();
    endif;
    ?>
    <div class="alert" id="ajaxMessage" style="display:none;margin:0"></div>
    <div class="text-center btn-warning" id="loading_image"><img src="{{ asset('img/ajax-loader.gif') }}" alt="Loading...."> Loading... </div>
</div>