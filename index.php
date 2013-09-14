<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Zussaweb</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	</head>
	<body>
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
			}else
				$upload_status="";			
			//get current status
			$phpvars = GetInfo ($host, $port, $user, $passwd);
		?>
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
				<div class="span8">
					<div class="contents">
						<div class="block" id="status"></div>
					</div>
				</div>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/jquery-1.10.2.min.js"><\/script>')</script>
		<script>			
			function refreshIt() {
				ajaxpage('status.php','status');
				setTimeout('refreshIt()',1000);
			}
			$(document).ready(function(){
				setTimeout('refreshIt()',0);
			});
		</script>
	</body>
</html>
