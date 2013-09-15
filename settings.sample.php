<?php

$host = 'localhost';
$port = 8760;
$user = 'hellanzb';
$passwd = 'changeme';

$disk = '/PATH/.hellanzb';
$download_nzb_path = '/PATH/.hellanzb/nzb/daemon.queue';

$download_max_filesize = 3000000;
$downloaded_allowed_types = array(
    'text/xml' => '.nzb'
);

define('cancel_image', '<i class="icon-remove"></i>');
define('up_image', '<i class="icon-arrow-up"></i>');
define('down_image', '<i class="icon-arrow-down"></i>');
define('first_image', '<i class="icon-upload"></i>');
define('last_image', '<i class="icon-download"></i>');
define('pause_image', '<i class="icon-pause"></i>');
define('now_image', '<i class="icon-step-forward"></i>');
define('top_image', '<i class="icon-circle-arrow-up"></i>');
define('continue_image', '<i class="icon-play"></i>');