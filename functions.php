<?php

function freediskspace() {
	$space = disk_free_space(__DIR__);
	$space =(int)($space / 1000000000);
	return $space.'G';
}

function sec2hms ($sec, $padHours = false) 
  {
    $hms = "";
    $hours = intval(intval($sec) / 3600); 
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
          : $hours. ':';
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
  }

function GetInfo ($host, $port, $user, $passwd) {
	 $f=new xmlrpcmsg("status","");
    	 //echo "<PRE>Sending the following request:<BR>" . htmlentities($f->serialize()) . "</PRE>\n";
         $c=new xmlrpc_client("", $host, $port);
         $c->setCredentials($user,$passwd);
         $c->setDebug(0);
         $r=$c->send($f);
         if(!$r->faultCode())
         	//Got a valid result, decode into php variables
                return php_xmlrpc_decode($r->value());
         else {
                //Got an error, print description
                echo "Fault: ";
                echo "Code: " . htmlspecialchars($r->faultCode())
                	. " Reason '" . htmlspecialchars($r->faultString()) . "'<BR>";
		exit();
         }
}


function SetQueue ($host, $port, $user, $passwd, $action, $id) {
	 //$f=new xmlrpcmsg($action, $id);
	 if ($id <> '')
	 	$f=new xmlrpcmsg($action, array(new xmlrpcval($id, "string")));
	 else
		$f=new xmlrpcmsg($action, "");
         $c=new xmlrpc_client("", $host, $port);
         $c->setCredentials($user,$passwd);
         $c->setDebug(0);
         $r=$c->send($f);
         if(!$r->faultCode())
         	//Got a valid result, decode into php variables
                return php_xmlrpc_decode($r->value());
         else {
                //Got an error, print description
                echo "Fault: ";
                echo "Code: " . htmlspecialchars($r->faultCode())
                	. " Reason '" . htmlspecialchars($r->faultString()) . "'<BR>";
		exit();
         }
}

// ************************************************
// ********* Upload file functions ****************
// ************************************************


function upload_file ($nzb_file) {

global $download_nzb_path;
    $error = validate_upload($nzb_file);
    if ($error) {
        //print ($error);
    } else { # cool, we can continue
	# move just changes the INODE, copy may fail because hellanzb checks (and rejects) the file while copy in still in progress (Marius Karthaus, www.budgetdedicated.com)	
	exec('mv '.escapeshellarg($nzb_file['tmp_name']).' '.escapeshellarg($download_nzb_path).'/'.escapeshellarg($nzb_file['name']),$res,$ret);
	chmod($download_nzb_path . "/" . $nzb_file['name'], 0777);
	if ($ret>0){
            $error = "Check the permissions for the upload directory";
        } else {
            $error = "<br><br><b><font color=\"#00FF00\">File upload OK </font></b><br>
			Filename: " . $nzb_file['name'] ."<br>
			Filesize: " . $nzb_file['size'] ." <br>";
        }
    }
	return ($error);
} # END upload


function validate_upload($nzb_file) {
	global $download_max_filesize,$download_allowed_types,$registered_types;
	$start_error = "<br><br><b><font color=\"#00FF00\">Error:</font></b>\n";
	if ($nzb_file['error'] <> 0) {
    		if ($nzb_file['error'] == 4) { # do we even have a file?
        		$error = "\n<br>You did not upload anything!\n";
    		}
    		if ($nzb_file['error'] == 2) { # Think the file is to big
        		$error = "\n<br>Filesize is bigger then allowed!\n";
		}
    	} else { # check size and file type
		$ext = explode(".", $nzb_file['name']);
		$nr    = count($ext);
        	$ext  = $ext[$nr-1];
        	if ($ext <> 'nzb') {
            		$error = "<br><p>The file " .$nzb_file['name']. " is no NZB file! </p>\n";
        	}
	        if ($nzb_file['size'] > $download_max_filesize) {
        		$error = "<p>The file <b>" .$nzb_file['name']. "</b> is bigger than " .$download_max_filesize. " bytes!</p>\n";
        	}
    	}
    	if (isset ($error))    
    		if ($error) {
			$error = $start_error . $error . "\n</ul>";
			return $error;
    		} else {
			return $error;
    		}
} # END validate_upload

?>

