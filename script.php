<?php
	//ob_start();
	//echo "Hello, world!";
	//$content = ob_get_contents();
	//$f = fopen("1.txt", "w");
	//fwrite($f, $content);
	//fclose($f);
	//file_put_contents("1.txt.", "end", FILE_APPEND);

		$url = $argv[1];
		$f = fopen($url, "r");
		while(!feof($f)) 
		{ 
			$line = fgets($f);
			echo $line."<br>";
			if ($line !== PHP_EOL)
			{
				file_put_contents("1.txt", $line, FILE_APPEND);
			}
		}
		fclose($f);
?>
