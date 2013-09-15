<?php
require_once('settings.php');
require_once('core/functions.php');
require_once('core/frontend.php');
require_once('lib/xmlrpc.inc');

global $host, $port, $user, $passwd, $action, $id;

if (isset ($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	if (isset ($_REQUEST['id']))
		$id = $_REQUEST['id'];
	$set = SetQueue ($host, $port, $user, $passwd, $action ,$id);
    $phpvars = GetInfo ($host, $port, $user, $passwd);
}
else {
    $phpvars = GetInfo ($host, $port, $user, $passwd);
}

if (isset($phpvars)) {
	echo "HellaNZB version ".$phpvars['version'].", ";
	echo "uptime ".$phpvars['uptime']."<br>";
	echo "total downloaded: ".$phpvars['total_dl_mb']."MB, ";
	echo "total downloaded nzbs: ".$phpvars['total_dl_nzbs'].", ";
	echo "free disk space: ".freediskspace($disk)."<hr>";
	currently_downloading($phpvars);
	echo "<hr>";
	queued ($phpvars);
	echo "<hr>";
	currently_processing($phpvars);
	echo "<hr>";
	logging ($phpvars);
}