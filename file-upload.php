<?php
require_once('settings.php');

$nzb_file = $_FILES['file'];
if(move_uploaded_file($nzb_file['tmp_name'], $download_nzb_path.'/'.$nzb_file['name']))
    exec('chmod '.$download_nzb_path . "/" . $nzb_file['name'].' 0777', $out, $ret);
