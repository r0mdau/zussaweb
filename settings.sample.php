<?php

$host = 'localhost';
$port = 8760;
$user = 'hellanzb';
$passwd = 'changeme';

$disk = '/PATH/.hellanzb';
$download_nzb_path = '/PATH/.hellanzb/nzb/daemon.queue';

// Download settings
$download_max_filesize = 3000000;
$downloaded_allowed_types = array(
    "text/xml"                => ".nzb",
);

define("cancel_image", "<img src=styles/default/images/cancel.gif alt=\"remove nzb\" title=\"remove nzb\">");
define("up_image", "<img src=styles/default/images/up.gif alt=\"move nzb up\" title=\"move nzb up\">");
define("down_image", "<img src=styles/default/images/down.gif alt=\"move nzb down\" title=\"move nzb down\">");
define("first_image", "<img src=styles/default/images/first.gif alt=\"move nzb to first in queue\" title=\"move nzb to first in queue\">");
define("last_image", "<img src=styles/default/images/last.gif alt=\"move nzb to last in queue\" title=\"move nzb to last in queue\">");
define("pause_image", "<img src=styles/default/images/pause.gif alt=\"pause downloading\" title=\"pause downloading\">");
define("top_image", "<img src=styles/default/images/top.gif alt=\"download now\" title=\"download now\">");
define("now_image", "<img src=styles/default/images/now.gif alt=\"download now\" title=\"download now\">");
define("continue_image", "<img src=styles/default/images/resume.gif alt=\"resume downloading\" title= \"resume downloading\">");