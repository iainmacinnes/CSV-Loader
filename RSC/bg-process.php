#!/usr/bin/php
<?php
# set the error handler
//ini_set('display_errors', 1);
error_reporting(E_ALL);
set_error_handler("myErrorHandler");

#Process File
set_time_limit(0);

$path = '/'

//$cmd = 'php bg-process.php ' . $original . ' ' . $leadsource . ' ' . $target;

$original = $argv[1];
$leadsource = $argv[2];
$target = $argv[3];

require($path."class/class.crm_v4.X.php");
$file = $path."RSC/CSV/".$target;
$handle = fopen($file, "r");
$row = 1;
$tot = 0;
$newlead = 0;
//$data = fgetcsv($handle);
//var_dump($data);

while (($data = fgetcsv($handle)) !== FALSE) {
	//var_dump($data);
	$crm = new crmContactTrip;
	$num = count($data);
	//echo "<p> $num fields in line $row: <br /></p>\n";
	if($row > 1 && $num > 1){
		include($path."RSC/MAP/rsc_import-".$leadsource.".php");
		//var_dump($contact);
		$crm->contact = array_merge($crm->contact,$contact);
		//var_dump($crm->contact);
		$return = $crm->ContactBus($crm->contact);
		//var_dump($return);
		$return = $crm->TripBus($crm->contact);
		//var_dump($return);
		if(isset($return['source'])){
			$fp = fopen($path.'RSC/CSV/rejects_'.$leadsource.'.csv', 'a');
			$crm->contact['Address'] = null;
			fputcsv($fp,$contact,',','"');
			fclose($fp);
		}
		#debug
		$fp = fopen($path.'RSC/debug_'.$leadsource.'.csv', 'a');
		$crm->contact['Address'] = null;
		fputcsv($fp,$crm->contact,',','"');
		fclose($fp);
		/**/
		unset($contact);
		$tot++;
		if($crm->newlead == True){
			$newlead++;
		}
	}
	$row++;
}

fclose($handle);

$connection = new mysql_connection;

$sql = "insert rsc_import (importfilename,date,total,newleads,originalfilename,source)  values ('".$target."', now(), ".$tot.", ".$newlead.", '".$original."', '".$leadsource."')";
$connection->query($sql,"crm");
//echo $sql;

//echo "<p>The ".$_REQUEST['leadsource']." file ".$_FILES['sourcefile']['name']. " has been imported</p>";
#End Process


// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
	
	$str = '';

    switch ($errno) {
    case E_USER_ERROR:
        $str.= "<b>My ERROR</b> [$errno] $errstr<br />\n";
        $str.= "  Fatal error on line $errline in file $errfile";
        $str.= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $str.= "Aborting...<br />\n";
        //exit(1);
        break;
	
    case E_USER_WARNING:
        $str.= "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        $str.= "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        $str.= "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }
	
	$handle = fopen("php_error_log", "a");
	fwrite($handle, $str); 
	fclose($handle);
	//exit(1);
    /* Don't execute PHP internal error handler */
    //return true;
}