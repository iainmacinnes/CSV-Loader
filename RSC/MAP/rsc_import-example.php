<?php
//fgetcsv  ( resource $handle  [, int $length  [, string $delimiter  [, string $enclosure  [, string $escape  ]]]] )
/*
0.First_Name
1.Last_Name
2.Contact_Title
3.Company
4.Address
5.City
6.State
7.Zip
8.Country
9.Email_Address
10.Telephone
11.Fax
12.Issue_Title
13.Description
14.Date_of_Inquiry
15.Lead_Type
16.RSN
17.Type
18.Category
19.PageNumber
20.Lead_Source
*/
$contact['firstname'] = $data[0];
$contact['lastname'] = $data[1];
$contact['Address']['AddressLine1'] = $data[4];
$contact['Address']['AddressLine2'] = '';
$contact['Address']['City'] = $data[5];
$contact['Address']['ProvinceState'] = $data[6];
$contact['Address']['PostalZip'] = $data[7];
$contact['Address']['Country'] = $data[8];
if($contact['Address']['Country'] == 'United States' || $contact['Address']['Country'] == 'USA'){
	$contact['Address']['Country'] = 'US';
}
if($contact['Address']['Country'] == 'Canada' || $contact['Address']['Country'] == 'CAN'){
	$contact['Address']['Country'] = 'CA';
}
$contact['Email'] = $data[9];
$contact['Phone'] = $data[10]; 
if($contact['Email'] == '' && $contact['Phone'] != ''){
	$contact['phonelookup'] = 'Y';
}
if($contact['Email'] != ''){
	$contact['mailinglist'] = 'Y';
}else{
	$contact['mailinglist'] = '';
}
$badphone = array("+", "(", ")", ".", "-", " ");
$contact['Phone'] = str_replace($badphone, "", $contact['Phone']);
$contact['SOURCE_CODE'] = 'audubon';
$datetime = new DateTime($data[14]);
$contact['DATE'] = $datetime->format('m/d/Y');
$contact['Language'] = "English";
$contact['trip'] = 'Y';
$contact['PLANNING'] = 'Follow Up for Booking';
//$contact['validateAddress'] = 'Y';	
$contact['materials']='Y';
$contact['source'] = 'RSC';
$contact['fromurl'] = $file;
$contact['LEAD_SOURCE'] = '';
$contact['INFO'] = '';
$contact['visitbefore'] = '';
