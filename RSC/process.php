<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
sleep(15);
ob_start();

//var_dump($_FILES);
//var_dump($_REQUEST);

### Load csv file
### Preset the drop down to match fields etc include map file

$original = escapeshellarg($_FILES['sourcefile']['name']);
$leadsource = escapeshellarg($_REQUEST['leadsource']);
$target = $leadsource.date("YmdHis").".csv";

#A Source needs to be identified
if ($_REQUEST['leadsource'] == ''){
	echo "Please choose the RSC source file.  This specifies how the file is imported and attributes a campaign name to a contact.<br>";
	exit;
}

#This is our size condition
if ($_FILES['sourcefile']['size'] > 500000){
	echo "Your file is too large.  Try splitting it into smaller amounts but remember to keep the title row.<br>";
	exit;
}

#This is our limit file type condition
if ($_FILES['sourcefile']['type'] == "text/x-csv" || $_FILES['sourcefile']['type'] == "application/csv" || $_FILES['sourcefile']['type'] == "text/comma-separated-values" || $_FILES['sourcefile']['type'] == "text/x-comma-separated-values" || $_FILES['sourcefile']['type'] == "application/vnd.ms-excel" || $_FILES['sourcefile']['type'] == "text/plain" ){
}else{
	echo $_FILES['sourcefile']['type'];
	echo "<br>CSV files only.  Please save your document as a comma separated list of values.<br>";
	exit;
}

if(move_uploaded_file($_FILES['sourcefile']['tmp_name'], "CSV/".$target)){
	echo "<p>The ".$_REQUEST['leadsource']." file ".$_FILES['sourcefile']['name']. " has been uploaded</p>";
	//ob_flush();
}else{
	echo "Sorry, there was a problem uploading your file.";
	exit;
}

# Attempt to stop the file from uploading multiple times.
# Start processing in background

function run_in_background($Command, $Priority = 0){
   if($Priority)
	   $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
	   //echo "1 - nohup nice -n $Priority $Command 2> /dev/null & echo $!";
   else
	   $PID = shell_exec("nohup $Command 1>nohup.out 2>&1 & echo $!");
	   //$PID = shell_exec("nohup $Command 1>nohup.out 2>&1 &");
	   //echo "2 - nohup $Command 1>nohup.out 2>&1 & echo $!"; 	
   return($PID);
}
$filename = preg_replace("/\s/","-",$original);
$filename = preg_replace("/[^a-zA-Z0-9\._-]/","",$filename);

$cmd = 'php bg-process.php ' . $filename . ' ' . $leadsource . ' ' . $target;
//echo $cmd;
$ps = run_in_background($cmd);
echo $ps;
exit;


