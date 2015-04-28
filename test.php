<?php
include '/lib/http_build_url.inc';
require '/lib/URL2.php';
	
		ob_start();
		echo "1234";
		$result = "database/result/result.html";
		$fp = fopen($result, "w");
		fclose($fp);
			
		$content = ob_get_contents();	
		
		var_dump($content);
			
			
				
			
	
?>