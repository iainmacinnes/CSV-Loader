<?php
require_once("../class/class.mysql.php");
$connection = new mysql_connection;
$sql = "select importfilename,date,total,newleads,originalfilename,source 
from crm.rsc_import where badimport != 1 order by date desc";
$result = $connection->query($sql,"crm");
$output = '
<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first" width="177">Import</th>
		<th>Date</th>
		<th># of Leads</th>
		<th># of New Leads</th>
	</tr>
';
$num=1;
while($row = mysql_fetch_assoc($result)){
	if($num % 2==0){
		$output .= '
	<tr class="bg">
	';
	}else{
		$output .= '
	<tr>
	';
	}
	$output .= '
		<td class="first style2">'.$row['source'].'</td>
		<td>'.date("Y-m-d", strtotime($row['date'])).'</td>
		<td>'.$row['total'].'</td>
		<td>'.$row['newleads'].'</td>
	</tr>
	';
	$num++;
}	
$output .= '
</table>
';
echo $output;