<?php

include '/var/www/html/linktraveler/scripts/linktraveler.php';

error_reporting(E_ALL ^ E_NOTICE);	
$replace = "http://www.hellsangelscostablanca.es/links.html"; 
echo $replace;
if(check_url_for_errors($replace))
	return 0;
else echo "good";
?>
	
