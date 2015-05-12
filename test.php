<?php

include '/var/www/html/linktraveler/lib/simple_html_dom.php';
echo "123";
$d = @file_get_html("http://google.com");
	echo($d);
?>
	
