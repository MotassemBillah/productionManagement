<?php

use App\Models\GeneralSetting;

$setting = GeneralSetting::get_setting();
$copyright = !empty($setting) ? $setting->copyright : '';
?>
<div id="footerPanel">
    <div id="footerBottom">
        <div class="container-fluid">
            <div class="text-center">
                <p>Developed and Maintenance By <a href="https://legendsoftbd.com" target="_blank" style="color:#FFEE58">Legend Soft</a> &copy; {{ date('Y') }}</p>
                <?php if (Config::get('app.env') == "local"): ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-info text-center no_bdr_rad" id="notificationMessage" style=""></div>
<div id="mask"></div>
</body>
</html>