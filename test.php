<?php

include '/var/www/html/linktraveler/scripts/linktraveler.php';

$struct_1 = new ipcountry();
$struct_1->struct_ip = "1.1.1.1";
$struct_1->struct_country = "RU";
var_dump($struct_1);
$ipcountry_array = array();
$ipcountry_array[] = $struct_1;
var_dump($ipcountry_array);
$ip = ("1.1.1.1");
$country = null;
foreach($ipcountry_array as $struct) 						if ($ip == $struct->struct_ip)
{
	$country = $struct->struct_country;
	echo "FIND $country";
	break;	
}
if ($country = null)
{
	echo "null";
}
?>
	
