<form method="POST">  
	<input name="inputUrl" type="text" id="url" value="";/>
    <input name="Submit" type="submit" value="LinkTraveler" />
</form>

<?php
include 'simple_html_dom.php';

function url_replace($f_url)
{
	//$replace = str_replace ('../','',$f_url);
	$replace = str_replace (' ','%20',$f_url);
	return $replace;
}

function check_extension($path, $ext_array)
{
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	if (in_array($ext, $ext_array))
	{
		echo "<br>File has wrong extension<br>";
		return true;
	}
	else
		return false;
}

	global $internal_links, $external_links, $email_array, $wrong_extensions;

	$parse = parse_url($f_url);
	$hostname = $parse[host];
	echo "<br> Internal URL : $f_url<br>"; 
	
	if (check_extension($parse[path], $wrong_extensions))
		return 0;
	
	$replace = url_replace($f_url);
	echo "<br> $replace <br>";
	
	$file_headers = @get_headers($replace);
	if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
	{
		echo "<br> 404 Error <br>";
		return 0;
	}
	
	$data = @file_get_contents($replace);
		
	$doc = new DOMDocument();
	@$doc -> loadHTML ( $data );
	$searchNodes = $doc->getElementsByTagName( "a" ); // Получаем все ссылки
	
	foreach($searchNodes as $node)
	{
		$local_link = $node -> getAttribute( 'href' );
		if ($local_link == "")
			continue;
		preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $local_link, $email_matches);	// Проверка на email
		if (count($email_matches) > 0)
		{
			foreach ($email_matches as $local_email)
			{
				if (strpos($local_email,'@') !== false && !(in_array($local_email, $email_array))) 
				{
					echo "<br> Find email: $local_email<br>";
					array_push($email_array, $local_email);
				}
			}
			continue;
		}
		$local_parse = parse_url($local_link);
		$local_hostname = $local_parse[host];
		
		if ($local_hostname == "")					// Проверка ссылки
		{
			$local_hostname = $hostname;
		}

		if (preg_replace('/^www\./', '',  $local_hostname) == preg_replace('/^www\./', '',$hostname)) 	// Внутренняя ссылка
		{
			$local_link = "$parse[scheme]://$parse[host]/$local_parse[path]";
			if (!in_array($local_link, $internal_links))
			{
				array_push($internal_links, $local_link);
				echo "<br>Internal link added. <br>Full url: $local_link<br>";
			}
			else
			{
				continue;
			}
		}		
		else																							// Внешняя ссылка
		{
			if (!in_array($local_link, $external_links))
			{
				array_push($external_links, $local_link);
				
				echo "<br>External link added. <br>Full url: $local_link<br>";

			}
		}
	}
						
}
function LinkProceed ($f_url) 
{
	global $external_links, $email_array, $internal_links, $wrong_extensions;  // Init
	$internal_links = array();
	
	$parse = parse_url($f_url);
	$hostname = $parse[host];
	echo "<br> URL : $f_url<br>";
	
	if (check_extension($parse[path], $wrong_extensions))
		return 0;
	
	$replace = url_replace($f_url);
	echo "<br> $replace <br>";
	
	$file_headers = @get_headers($replace);
	if($file_headers[0] == 'HTTP/1.1 404 Not Found') 
	{
		echo "<br> 404 Error <br>";
		return 0;
	}
	
	$data = @file_get_contents($replace);
	
	$doc = new DOMDocument();
	@$doc -> loadHTML ( $data );
	$searchNodes = $doc->getElementsByTagName( "a" ); // Получаем все ссылки
	

	foreach($searchNodes as $node)
	{
		$local_link = $node -> getAttribute( 'href' );
		if ($local_link == "")
			continue;
		preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $local_link, $email_matches);	// Проверка на email
		if (count($email_matches) > 0)
		{
			foreach ($email_matches as $local_email)
			{
				if (strpos($local_email,'@') !== false && !(in_array($local_email, $email_array))) 
				{
					echo "<br> Find email: $local_email<br>";
					array_push($email_array, $local_email);
				}
			}
			continue;
		}
		$local_parse = parse_url($local_link);
		$local_hostname = $local_parse[host];
		
		if ($local_hostname == "")					// Проверка ссылки
		{
			$local_hostname = $hostname;
		}

		if (preg_replace('/^www\./', '',  $local_hostname) == preg_replace('/^www\./', '',$hostname)) 	// Внутренняя ссылка
		{
			$local_link = "$parse[scheme]://$parse[host]/$local_parse[path]";
			if (!in_array($local_link, $internal_links))
			{
				array_push($internal_links, $local_link);
				echo "<br>Internal link added. <br>Full url: $local_link<br>";
				
			}
			else
			{
				continue;
			}
		}		
		else																							// Внешняя ссылка
		{
			if (!in_array($local_link, $external_links))
			{
				array_push($external_links, $local_link);
				echo "<br>External link added. <br>Full url: $local_link<br>";
			}
		}
	}
									
	$internal_links_index = 0;								// Проход по внутренним ссылкам
	$internal_links_count = count($internal_links);
	$check = false;
	while (!$check)
	{
		LinkProceed($internal_links[$internal_links_index]);
		$internal_links_index++;
		$internal_links_count = count($internal_links);
		echo "<br> $internal_links_index <br> $internal_links_count <br>";
		if ($internal_links_index >= count($internal_links))
		{
			$check = true;
		}
	}
	echo "<br>Stop<br>External links:<br>";
	foreach ($external_links as $link)
		echo "$link <br>";
	echo "<br>Emails:<br>";
	foreach ($email_array as $email)
		echo "$email <br>";
	
}


if( isset( $_POST['Submit'] ) )
    {				
		$start = microtime(true); // Включение таймера
		set_time_limit(0);	// Чтобы скрипт не зависал через 30 секунд
		
		$external_links = array();	// Init
		$email_array = array();
		$internal_links = array();
		$links = array();
		$wrong_extensions = array("jpg", "gif", "png", "bmp", "wmv", "pdf", "wav", "mp3", "avi");	// Запрещенные расширения
	
		$links[0] = $_POST['inputUrl']; 				// Получаем URL и HOSTNAME сайта
		
		echo "Start!<br>";
		
		foreach ($links as $url)						// Проход по внешним ссылкам
		{
			LinkProceed($url);	
			$internal_links_index = 0	// Проход по внутренним ссылкам
			$internal_links_count = count($internal_links);
			$check = false;
			while (!$check)
			{
				LinkProceed($internal_links[$internal_links_index]);
				$internal_links_index++;
				$internal_links_count = count($internal_links);
				echo "<br> $internal_links_index <br> $internal_links_count <br>";
				if ($internal_links_index >= count($internal_links))
				{
					$check = true;
				}
			}
		}
		echo "<br>Stop<br>External links:<br>";
		foreach ($external_links as $link)
			echo "$link <br>";
		echo "<br>Emails:<br>";
		foreach ($email_array as $email)
			echo "$email <br>";
		$time = microtime(true) - $start; // Выключение таймера
		printf('Скрипт выполнялся %.4F сек.', $time);
    }
?>
