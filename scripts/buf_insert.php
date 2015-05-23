<?php
	date_default_timezone_set('Europe/Moscow');
	$date = date("Y-m-d_H-i-s");
	$newLinks_file = "/var/www/html/linktraveler/database/new/newLinks_".$date.".txt";
	$fp = fopen($newLinks_file, "w");
	fclose($fp);
	$array = argv[1];
	if(empty($array))
	{
		echo("Nothing is choosed");
	}
	else
	{
		foreach($array as $chosen_link)
		{
				file_put_contents($newLinks_file, PHP_EOL.$chosen_link, FILE_APPEND);
		}
		echo "<br>File is ready";
	}
?>
