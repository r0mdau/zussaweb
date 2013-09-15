<?php

function currently_processing ($phpvars){
	echo '<h4>Currently processing</h4>';
	foreach ($phpvars['currently_processing'] as $cur_proc) {
		echo 'processing: '.$cur_proc['nzbName'].' ';
		echo 'ID '.$cur_proc['id'].' <br>'."\n";
	}
}

function currently_downloading ($phpvars) {
	echo '<h4>Currently downloading</h4>';
	if (count($phpvars['currently_downloading']) > 0) {
		echo '<table><tr><td colspan="2"><td width=50%><strong>File</strong><td><strong>Left</strong><td><strong>Rate</strong><td><strong>Remaining</strong>';
        foreach ($phpvars['currently_downloading'] as $cur_down) {
            echo '<tr><td width="10"><a href="javascript:ajaxpage(\'status.php?action=cancel\', \'status\')">'.cancel_image.'</a>';
			if ($phpvars['is_paused'])
				echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=continue\', \'status\')">'.continue_image.'</a>';
			else
				echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=pause\', \'status\')">'.pause_image.'</a>';
            
			echo '<td>'.$cur_down['nzbName'];
			echo '<td>'.$phpvars['queued_mb'].'MB';
			
			if ($phpvars['is_paused'])
				echo '<td>paused';
			else
				echo '<td>'.round($phpvars['rate']).' KB/s';
			
			echo '<td>'.sec2hms($phpvars['eta']);
			echo '<tr><td><td><td colspan="3" class="progress">';
			echo 	'<div class="progress progress-striped'.($phpvars['is_paused'] ? '' : ' active').'">
						<div class="bar" style="width: '.$phpvars['percent_complete'].'%;"></div>
					</div>';
        	echo '<td>'.$phpvars['percent_complete'].'%';
			echo '</table></div>';
		}	
	} else {
		if ($phpvars['is_paused']) {
			echo '<table><tr>';
			echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=continue\', \'status\')">'.continue_image.'</a>';
			echo '<td>paused';
			echo '</table></div>';
		}
	}
    echo '</table>';
}

function queued ($phpvars) {
	echo '<h4>Queued</h4>';
	echo '<table>';
	foreach ($phpvars['queued'] as $cur_queued) {
		echo '<tr><td width="10"><a href="javascript:ajaxpage(\'status.php?action=dequeue&id='.$cur_queued['id'].'\', \'status\')">'.cancel_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=up&id='.$cur_queued['id'].'\', \'status\')">'.up_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=down&id='.$cur_queued['id'].'\', \'status\')">'.down_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=next&id='.$cur_queued['id'].'\', \'status\')">'.first_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=last&id='.$cur_queued['id'].'\', \'status\')">'.last_image.'</a>';
		echo '<td width="10"><a href="javascript:ajaxpage(\'status.php?action=force&id='.$cur_queued['id'].'\', \'status\')">'.now_image.'</a>';
		echo '<td>'.$cur_queued['nzbName'];
	}
	echo '</table>';
}

function logging ($phpvars) {
	echo '<h4>Logging</h4><small>';
	foreach ($phpvars['log_entries'] as $info) {
		echo $info['INFO']."<br>";
	}
	echo '</small><hr>';
}

function upload ($upload_status) {
        global $download_max_filesize;
        echo '<div class = "text-center well well-small">Upload NZB file<br>';
        echo '<form enctype="multipart/form-data" action="index.php" method="post">';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="' . $download_max_filesize . '" />';
        echo 'Choose a file to upload: <input class="input" name="nzbfile" type="file" /><br><br>';
        echo '<input class="submit" type="submit" value="Upload File" />';
        echo '</form><div class="block" id="upload_status">';
        echo '<p  class="text-center">upload status</p>';
        echo $upload_status;
        echo '</div></div>';
}

function maxrate ($phpvars) {
    echo "<div class=\"text-center well\">Max download rate<br><br>";
	if ($phpvars['maxrate']=="0")
		echo "current rate: unlimited";
	else
		echo "current rate: ".$phpvars['maxrate'];
	
	echo 	'<form>New rate:
				<select class="input" onChange="if(this.options[this.selectedIndex].value) top.location.href=(\'index.php?rate=\'+this.options[this.selectedIndex].value)"> 
					<option value="-">-</option>
					<option value="25">25Kb/Sec</option> 
					<option value="50">50Kb/Sec</option>
					<option value="100">100Kb/Sec</option>
					<option value="250">250Kb/Sec</option>
					<option value="0">No limit</option>
				</select>
			</form>';
	echo '</div>';
}

function inputnewzbinid() {
	echo '<div class="text-center well">Upload NewzbinID<br><br>';
	echo '<form>ID:';
	echo '	<input class="input" type="text" name="newzbinid" />';
	echo '  <br><br>';
	echo '	<input class="submit" type="submit" value="Submit Newzbin ID" />';
	echo '</form><br /></div>';
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