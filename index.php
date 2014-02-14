<?php
	require_once('settings.php');
	require_once('core/frontend.php');
	require_once('core/functions.php');
	require_once('lib/xmlrpc.inc');
	
	/*
	global $host, $port, $user, $passwd, $action, $id;
	$upload_status = '';
	if (isset ($_GET['rate']))
		SetQueue ($host, $port, $user, $passwd, "maxrate", $_GET['rate']);
	else if (isset ($_FILES['nzbfile']))
		$upload_status = upload_file($_FILES['nzbfile']);
	else if (isset ($_REQUEST['newzbinid']))
		SetQueue ($host, $port, $user, $passwd, "enqueuenewzbin", trim($_REQUEST['newzbinid']));
	
	$phpvars = GetInfo ($host, $port, $user, $passwd);
	*/
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Zussaweb</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<style>
			.dropzone{
				width: 100%;
				height: 50px;
				border: 3px dashed #BBBBBB;
				line-height:50px;
				text-align: center;
			}
		</style>
		<?php
			// Mysterious refresh, remove it to see the problem after uploading a file
			if(isset ($_FILES['nzbfile']))
				echo '<meta http-equiv="refresh" content="0">';
		?>
	</head>
	<body>
		<div class="container container-fluid">
			<div class="row-fluid">
				<div class="span4">
					<div class="top">
						Zussaweb &copy; <a href="https://github.com/r0mdau">r0mdau</a>
					</div>
					<div class="menu">
						<?=menu($phpvars)?>
					</div>
				</div>
				<div class="span8 well">
					<div class="contents">
						<div id="status">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.10.2.min.js"><\/script>')</script>
		<script src="assets/js/ajaxpage.js"></script>
		<script src="assets/js/dropzone.js"></script>
		<script>			
			function refreshIt() {
				ajaxpage('status.php','status');
				setTimeout(refreshIt, 1000);
			}
			$(document).ready(function(){
				refreshIt();
			});
		</script>
	</body>
</html>
