<form method="POST">  
	<input name="inputUrl" type="text" id="url" value="";/>
    <input name="Submit" type="submit" value="LinkTraveler" />
</form>

<?php
include 'simple_html_dom.php';
include '/lib/http_build_url.inc';

function check_extension($path, $ext_array)
{
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	if (in_array($ext, $ext_array) || $ext === "")
	{
		return true;
	}
	else
	{
		echo "<br>File has wrong extension: $path<br>";
		return false;
	}
}

function ext_check_extension($path, $ext_array)
{
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	if (in_array($ext, $ext_array) || $ext === "")
	{
		return true;
	}
	else
	{
		echo "<br>File has wrong extension: $path<br>";
		return false;
	}
}

function check_url_for_errors ($url)
{
	global $errors;
	$file_headers = @get_headers($url);
	if(in_array($file_headers[0], $errors))
	{
		echo "<br>ERROR: ".$file_headers[0]."<br>";
		return true;
	}
	else
		return false;
}

function normalizePath($path)
{
    $parts = array();// Array to build a new path from the good parts
    $path = str_replace('\\', '/', $path);// Replace backslashes with forwardslashes
    $path = preg_replace('/\/+/', '/', $path);// Combine multiple slashes into a single slash
    $segments = explode('/', $path);// Collect path segments
    $test = '';// Initialize testing variable
    foreach($segments as $segment)
    {
        if($segment != '.')
        {
            $test = array_pop($parts);
            if(is_null($test))
                $parts[] = $segment;
            else if($segment == '..')
            {
                if($test == '..')
                    $parts[] = $test;

                if($test == '..' || $test == '')
                    $parts[] = $segment;
            }
            else
            {
                $parts[] = $test;
                $parts[] = $segment;
            }
        }
    }
    return implode('/', $parts);
}

function href_normalize($href, $url)
{
	$correct_scheme = array("http", "https", "ftp");
	$local_parse = parse_url($href);
	
	if ($local_parse["scheme"] !== null)
	{
		if (in_array($local_parse["scheme"], $correct_scheme))
		{
			$local_parse["path"] = normalizePath($local_parse["path"]);
			$normalized_href = http_build_url($local_parse);
			$normalized_href = str_replace('\\', '/', $normalized_href);
		}
	}
	else
	{
		$mystring = $local_parse["path"];
		$findme   = './';
		$pos = strpos($mystring, $findme);
		if ($pos !== false)
		{
			$path_parts = pathinfo($url);
			$local_parse["path"] = $path_parts['dirname']."/".$local_parse["path"];
			$local_parse["path"] = normalizePath($local_parse["path"]);
			$normalized_href = http_build_url($local_parse);
			$normalized_href = str_replace('\\', '/', $normalized_href);
			$normalized_href = str_replace(":/", "://", $normalized_href);
		}
		else
		{
			$url_parse = parse_url($url);
			$path_parts = pathinfo($url);
			$url_parse[path] = str_replace($path_parts[basename], "", $url_parse[path]);
			$local_parse[path] = $url_parse[path].$href;
			$normalized_href = http_build_url($local_parse);
			$normalized_href = str_replace('\\', '/', $normalized_href);
			$normalized_href = str_replace(":/", "://", $normalized_href);
		}
	}
	return $normalized_href;
}

function find_all_elements($html, $needle, $url)
{
	$find_result = array();
	if ($html !== false)
	{
		$haystack = $html->find('*['.$needle.']');
		foreach($haystack as $element) 
		{
			preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $element, $email_matches);								// Проверка на email
			if (count($email_matches) > 0)
			{
				foreach ($email_matches as $local_email)
				{
					if (strpos($local_email,'@') !== false ) 
					{
						array_push($find_result, $local_email);
					}
				}
				continue;
			}
			$find_result[] = href_normalize($element->$needle, $url);
		}
		return $find_result;
	}
	else
	{
		echo "<br>Nothing find<br>";
		return array();
	}
}

function LinkProceed ($f_url) 
{
	global $external_links, $email_array, $email_link, $internal_links, $correct_extensions, $find_elements;  // Init
	$parse = parse_url($f_url);
	
	echo "URL : $f_url<br>";
	
	if (!check_extension($parse[path], $correct_extensions))
		continue;
	
	$replace = str_replace (' ','%20',$f_url);
	
	
	if(check_url_for_errors($replace))
		return 0;
		
	
	$hostname = $parse[host];	
	$data = @file_get_html($replace);
	
	$find_elements = find_all_elements($data, "href", $f_url);
	
	foreach($find_elements as $local_link)
	{
		if ($local_link == "")
			continue;
		preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $local_link, $email_matches);								// Проверка на email
		if (count($email_matches) > 0)
		{
			foreach ($email_matches as $local_email)
			{
				if (strpos($local_email,'@') !== false && !(in_array($local_email, $email_array))) 
				{
					echo "<br> Find email: $local_email<br>";
					array_push($email_array, $local_email);
					array_push($email_link, $f_url);
				}
			}
			continue;
		}
		$local_parse = parse_url($local_link);
		$local_hostname = $local_parse[host];	// Проверка ссылки
		
		if ($local_hostname == "")					
		{
			$local_hostname = $hostname;
		}

		if (preg_replace('/^www\./', '',  $local_hostname) == preg_replace('/^www\./', '',$hostname)) 	// Внутренняя ссылка
		{
			$local_parse[scheme] = $parse[scheme];
			$local_parse[host] = $hostname;
			$local_link = http_build_url($local_parse);
			if (!in_array($local_link, $internal_links))
			{
				if (!check_extension($local_parse[path], $correct_extensions))
					continue;
				array_push($internal_links, $local_link);
				echo "<br><font color=\"Blue\">Internal link added. </font><br>Full url: $local_link <br>";
			}
			else
			{
				continue;
			}
		}		
		else																	// Внешняя ссылка
		{
			if (!in_array($local_link, $external_links))
			{
				if (!ext_check_extension($local_parse[path], $correct_extensions))
					continue;
				array_push($external_links, $local_link);
				echo "<br><font color=\"Red\">External link added. </font><br>Full url: $local_link<br>";
			}
		}
	}	
}

if( isset( $_POST['Submit'] ) ) // Начало скрипта
    {				
	
		$start = microtime(true); // Включение таймера
		set_time_limit(0);	// Чтобы скрипт не зависал через 30 секунд
		$external_links = array();	// Init
		$email_array = array();
		$email_link = array();
		$internal_links = array();
		$links = array();
		$find_elements = array();
		$correct_extensions = array("htm", "html", "php", "htmls");
		$errors = array("HTTP/1.1 400 Bad Request", "HTTP/1.1 403 Forbidden", "HTTP/1.1 404 Not Found",
		"HTTP/1.1 405 Method Not Allowed", "HTTP/1.1 408 Request Timeout", "HTTP/1.1 500 Internal Server Error",
		"HTTP/1.1 502 Bad Gateway", "HTTP/1.1 504 Gateway Timeout");
		
		if (!check_extension($parse[path], $correct_extensions))
			echo "FAIL";
			
		$links[0] = $_POST['inputUrl']; 				// Получаем URL и HOSTNAME сайта
		
		foreach ($links as $url)						// Проход по внешним ссылкам
		{
			$internal_links = array();
			LinkProceed($url);	
			
			$internal_links_index = 0;					// Проход по внутренним ссылкам
			$internal_links_count = count($internal_links);
			$check = false;
			while (!$check)
			{
				$start_internal = microtime(true);
				echo "<br>".($internal_links_index+1).") ";
				LinkProceed($internal_links[$internal_links_index]);
				$internal_links_index++;
				$internal_links_count = count($internal_links);
				$internal_links_remain = $internal_links_count-$internal_links_index;
				echo "<br> Internal links remain: $internal_links_remain<br>";
				if ($internal_links_index >= count($internal_links))
				{
					$check = true;
				}
				$time = microtime(true) - $start_internal; // Выключение таймера
				printf('<br>Link was in process for %.4F sec.<br>', $time);
			}
		}
		echo "<br>External links: ".count($external_links)."<br>";
		foreach ($external_links as $link)
		{
			if(check_url_for_errors($link))
			{
				echo "$link is <font color=\"Red\">not valid</font><br>";
			}
			else
			{
				$ext_parse = parse_url($link);
				$ext_host = preg_replace('/^www\./', '',  $ext_parse[host]);
				$db_search = "http://seo.sed.de/links/main/create/date_red-desc/".$ext_host."/all/all/20/page/";
				$data = @file_get_html($db_search);
				$find_elements = find_all_elements($data, "href", $f_url);
				
				{
					$find_result = array();
					if ($html !== false)
					{
						$haystack = $html->find('*['.$needle.']');
						foreach($haystack as $element) 
						{
							preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $element, $email_matches);								// Проверка на email
							if (count($email_matches) > 0)
							{
								foreach ($email_matches as $local_email)
								{
									if (strpos($local_email,'@') !== false ) 
									{
										array_push($find_result, $local_email);
									}
								}
								continue;
							}
							$find_result[] = href_normalize($element->$needle, $url);
						}
						return $find_result;
					}
					else
					{
						echo "<br>Nothing find<br>";
						return array();
					}
				}
				
				
				echo "$link is <font background=\"Green\">valid</font><br>";
						
			}
		}
		$email_count = count($email_array);
		echo "<br>Emails: ".$email_count."<br>";
		//foreach ($email_array as $email)
		for ($i = 0; $i < $email_count; $i++)
		{
			echo $email_array[$i]." : ".$email_link[$i]."<br>";
		}
		$time = microtime(true) - $start; // Выключение таймера
		printf('<br>Script was in process for %.4F sec.', $time);
    }
?>
