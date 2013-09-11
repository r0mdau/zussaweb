<?php
("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>

<script language="JavaScript"><!--
	function refreshIt() 
	{
		ajaxpage('status.php','status');
		setTimeout('refreshIt()',15000); // refresh every 15 secs
	}
//--></script>

<META http-equiv=Content-Type content="text/html; charset=utf-8"></HEAD>
<body onLoad=" setTimeout('refreshIt()',0)">

<?php
require_once "settings.php";
require_once "functions.php";

require_once "frontend.php";

require_once "styles.php";
require_once('java.php');

include("lib/xmlrpc.inc");
global $host, $port, $user, $passwd, $action, $id;

if (isset ($_REQUEST['rate'])) {
	//set max download option
	SetQueue ($host, $port, $user, $passwd, "maxrate", $_REQUEST['rate']); 
	}

if (isset ($_FILES['nzbfile'])) {
	$upload_status = upload_file($_FILES['nzbfile']);
	echo '<meta http-equiv="refresh" content="10">';
}

if (isset ($_REQUEST['newzbinid'])) {
	SetQueue ($host, $port, $user, $passwd, "enqueuenewzbin", trim($_REQUEST['newzbinid']));
}

else
	$upload_status="";

//get current status
$phpvars = GetInfo ($host, $port, $user, $passwd);
?>


<center>
<div class = "container"> 
<div class = "top">
	Hella Web Interface v0.3
</div>

<div class = "menu">
<?php
menu($phpvars);
?>

</div></div>
<div class = "contents">
	<div class = "block" id="status">

</div></div></div></center>
</BODY></HTML>
