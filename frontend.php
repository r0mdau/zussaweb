<?php
require_once "settings.php";
require_once "functions.php";
require_once "styles.php";
require_once('java.php');

function currently_processing ($phpvars){
	echo "<div class = \"block\">Currently processing";
	foreach ($phpvars['currently_processing'] as $cur_proc) {
		echo "processing: ".$cur_proc['nzbName']." ";
		echo "ID ".$cur_proc['id']." <br>\n";
	}
	echo "</div>";
}

function currently_downloading ($phpvars) {
	echo '<div class = "block">Currently downloading<br>';
	if (count($phpvars['currently_downloading']) > 0) {
		//Download in progress, display info
		echo '<table class="table"><tr><td colspan="2"><td width=50%>name<td>MB left<td>download rate<td>time remaining';
        foreach ($phpvars['currently_downloading'] as $cur_down) {
            echo '<tr><td width="10"><a href="javascript:ajaxpage(\'status.php?action=cancel\', \'status\')">'.cancel_image.'</a>';
			if ($phpvars['is_paused'])
				echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=continue\', \'status\')">'.continue_image.'</a>';
			else
				echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=pause\', \'status\')">'.pause_image.'</a>';
            
			echo "<td>".$cur_down['nzbName'];
			echo "<td>".$phpvars['queued_mb']."MB";
			
			if ($phpvars['is_paused'])
				echo "<td>paused";
			else
				echo "<td>".round($phpvars['rate'])." KB/s";
			
			echo "<td>".sec2hms($phpvars['eta']);
			echo '<tr><td><td><td colspan="3" class="progress">';
			echo '<IMG src=styles/default/images/pbar.gif height=12 width='.$phpvars['percent_complete'].'%>'; 
        	echo "<td>".$phpvars['percent_complete']."%";
			echo "</table></div>";
		}	
	} else {
		if ($phpvars['is_paused']) {
			//No downloads, but still paused, so display an unpause button
			echo '<table class="table"><tr>';
			echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=continue\', \'status\')">'.continue_image.'</a>';
			echo '<td>paused';
			echo "</table></div>";
		}
	}
    echo "</table></div>";
}

function queued ($phpvars) {
	echo '<div class = "block">Queued<br>';
	echo '<table>';
	foreach ($phpvars['queued'] as $cur_queued) {
		echo '<tr><td width="10"><a href="javascript:ajaxpage(\'status.php?action=dequeue&id='.$cur_queued['id'].'\', \'status\')">'.cancel_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=up&id='.$cur_queued['id'].'\', \'status\')">'.up_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=down&id='.$cur_queued['id'].'\', \'status\')">'.down_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=next&id='.$cur_queued['id'].'\', \'status\')">'.first_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=last&id='.$cur_queued['id'].'\', \'status\')">'.last_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=force&id='.$cur_queued['id'].'\', \'status\')">'.now_image.'</a>';
		echo "<td>".$cur_queued['nzbName'];
	}
	echo "</table></div>";
}

function logging ($phpvars) {
	echo '<div class = "block">Logging<br>';
	foreach ($phpvars['log_entries'] as $info) {
		echo $info['INFO']."<br>";
	}
	echo "</div>";
}

function upload ($upload_status) {
        global $download_max_filesize;
        echo '<div class = "block"><center>Upload NZB file</center><br>';
        echo '<form enctype="multipart/form-data" action="index.php" method="post">';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . $download_max_filesize . '" />';
        echo 'Choose a file to upload: <input class="input" name="nzbfile" type="file" /><br><br>';
        echo '<input class="submit" type="submit" value="Upload File" />';
        echo '</form><div class="block" id="upload_status">';
        echo '<center>upload status</center>';
        echo $upload_status;
        echo '</div></div>';
}

function maxrate ($phpvars) {
    echo "<div class=\"block\"><center>Max download rate</center><br><br>";
	if ($phpvars['maxrate']=="0")
		echo "current rate: unlimited";
	else
		echo "current rate: ".$phpvars['maxrate'];

	?>
	<form>New rate: <select class="input" onChange="if(this.options[this.selectedIndex].value) top.location.href=('index.php?rate='+this.options[this.selectedIndex].value)"> 
	<option value="-">-</option>
	<option value="25">25Kb/Sec</option> 
	<option value="50">50Kb/Sec</option>
	<option value="100">100Kb/Sec</option>
	<option value="250">250Kb/Sec</option>
	<option value="0">No limit</option>
	D</select></form><br></div> 
	<?php
}

function inputnewzbinid() {
	echo "<div class=\"block\"><center>Upload NewzbinID</center><br><br>";
	echo "<form>ID:";
	echo "	<input class=\"input\" type=\"text\" name=\"newzbinid\" />";
	echo "  <br><br>";
	echo "	<input class=\"submit\" type=\"submit\" value=\"Submit Newzbin ID\" />";
	echo "</form><br /></div>";
}

function menu ($phpvars) {
 	global $upload_status;
	$html = '<div class = "block">';
	$html .= upload($upload_status);
	$html .= '<br /><br />';
	$html .= maxrate($phpvars);
	$html .= '<br /><br />';
	$html .= inputnewzbinid();
	$html .= '</div>';
	return $html;
}	

function footer () {
	echo '<a href="javascript:ajaxpage(\'status.php\', \'status\')">'."refresh".'</a>';
}