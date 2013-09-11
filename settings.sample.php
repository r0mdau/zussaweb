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
); # these are only a few examples, you can add as many as you like
?>
