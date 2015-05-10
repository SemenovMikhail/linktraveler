<?php
// <input type=file name=file>
include '/var/www/html/linktraveler/lib/simple_html_dom.php';
include '/var/www/html/linktraveler/lib/http_build_url.inc';
require '/var/www/html/linktraveler/lib/vendor/autoload.php';
require '/var/www/html/linktraveler/lib/URL2.php';
use GuzzleHttp\Client;

$client = new Client();

function check_extension($path, $ext_array)
{
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	if (in_array($ext, $ext_array) || $ext === "")
	{
		return true;
	}
	else
	{
		//echo "<br><font style=\"background-color: Red\">File has wrong extension:</font> $path<br>";
		return false;
	}
}

function check_url_for_errors ($url)
{
	global $errors;
	$file_headers = @get_headers($url);
	if ($file_headers === false)
	{
		echo "<br>WRONG LINK<br>";
		return true;
	}
	if(in_array($file_headers[0], $errors))
	{
		echo "<br>ERROR: ".$file_headers[0]."<br>";
		return true;
	}
	else
	{
		return false;
	}
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
		if (in_array($local_parse[scheme], $correct_scheme))
		{
			$local_parse["path"] = normalizePath($local_parse["path"]);
			$normalized_href = http_build_url($local_parse);
			$normalized_href = str_replace('\\', '/', $normalized_href);
		}
	}
	else
	{
		$local_url = new Net_URL2($url);
		$normalized_href = $local_url->resolve($href);
	}
	return $normalized_href;
}

function find_all_elements($html, $needle, $tag)
{
	$find_result = array();
	if ($html !== false)
	{
		$haystack = $html->find($tag.'['.$needle.']');
		foreach($haystack as $element) 
		{
			$find_result[] = $element->$needle;
		}
		return $find_result;
	}
	else
	{
		echo "<br>Nothing find<br>";
		return array();
	}
}

function find_inner_text($html, $tag)
{
	$find_result = array();
	if ($html !== false)
	{
		$haystack = $html->find($tag);
		foreach($haystack as $element) 
		{
			$find_result[] = $element->innertext;
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
	global $external_links, $email_array, $email_link, $internal_links, $correct_extensions, $find_elements, $used_links, $new_used_links;  // Init
	
	if(strpos($f_url,"://")===false && substr($f_url,0,1)!="/") $f_url = "http://".$f_url;
	
	$parse = parse_url($f_url);
	
	echo "<font style=\"background-color: Yellow\">URL : $f_url</font><br>";
	
	if (!check_extension($parse[$path], $correct_extensions))
		return 0;
	
	$replace = str_replace (' ','%20',$f_url);
	
	if(check_url_for_errors($replace))
		return 0;
		
	$hostname = $parse[host];	
	$data = @file_get_html($replace);

	//$titles = find_inner_text($data, "title");
	//foreach ($titles as $title)
	//	echo "<br>TITLE IS: ".$title."<br>";
	
	$find_elements = find_all_elements($data, "href", "*");
	
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
					echo "<br><font style=\"background-color: Green\">Find email: $local_email</font><br>";
					array_push($email_array, $local_email);
					array_push($email_link, $f_url);
				}
			}
			continue;
		}
		$local_link = href_normalize($local_link, $f_url);
		$local_parse = parse_url($local_link);
		$local_hostname = $local_parse[host];

		if (preg_replace('/^www\./', '',  $local_hostname) == preg_replace('/^www\./', '',$hostname)) 	// Внутренняя ссылка
		{
			//$local_parse[scheme] = $parse[scheme];
			//$local_parse[host] = $hostname;
			//$local_link = http_build_url($local_parse);
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
			$ex_parse = parse_url($local_link);
			$ex_link = $ex_parse[scheme]."://".$ex_parse[host];
			if (!in_array($local_link, $external_links) && !in_array($ex_link, $used_links) && !in_array($ex_link, $new_used_links))
			{
				if (!check_extension($local_parse[path], $correct_extensions))
					continue;
				array_push($external_links, $local_link);
				echo "<br><font color=\"Red\">External link added. </font><br>Full url: $local_link<br>";
			}
		}
	}	
}

ob_start();
error_reporting(E_ALL ^ E_NOTICE);	
set_time_limit(0);	// Чтобы скрипт не зависал через 30 секунд
$start = microtime(true); // Включение таймера для скрипта
$external_links = array();	// Init
$email_array = array();
$email_link = array();
$internal_links = array();
$links = array();
$find_elements = array();
$used_links = array();
$new_used_links = array();
$correct_extensions = array("htm", "html", "php", "htmls", "aspx", "asp");
$errors = array("HTTP/1.1 400 Bad Request", "HTTP/1.1 403 Forbidden", "HTTP/1.1 404 Not Found",
"HTTP/1.1 405 Method Not Allowed", "HTTP/1.1 408 Request Timeout", "HTTP/1.1 500 Internal Server Error",
"HTTP/1.1 502 Bad Gateway", "HTTP/1.1 504 Gateway Timeout");
$internal_links_limit = 150;
$time_limit = 15;

$myFile = $argv[1];
$f = fopen($myFile, "r");
while(!feof($f)) 
{ 
	$line = fgets($f);
	if ($line !== PHP_EOL)
	{
		$links[] = $line;
	}
}
fclose($f);

date_default_timezone_set('UTC');
$date = date("Y-m-d_H-i-s");
$newLinks_file = "/var/www/html/linktraveler/database/new/newLinks_".$date.".txt";
$fp = fopen($newLinks_file, "w");
fclose($fp);

$emails_file = "/var/www/html/linktraveler/database/emails/emails_".$date.".txt";
$fp = fopen($emails_file, "w");
fclose($fp);

$f = fopen("/var/www/html/linktraveler/database/old/oldLinks.txt", "r");
while(!feof($f)) 
{ 
	$line = fgets($f);
	if ($line !== PHP_EOL)
		$used_links[] = str_replace(PHP_EOL, "", $line);
}
fclose($f);

$result = "/var/www/html/linktraveler/database/result/result_".$date.".html";
$fp = fopen($result, "w");
fclose($fp);

foreach ($links as $url)						// Проход по внешним ссылкам
{
	$start_link = microtime(true); // Включение таймера для ссылки
	if (in_array($url, $used_links) || in_array($url, $new_used_links))
		continue;
	$internal_links = array();
	$average_time = 0;
	
	echo "EXTERNAL ";
	LinkProceed($url);
	
	$used_parse = parse_url($url);
	$new_used_links[] = $used_parse[scheme]."://".$used_parse[host];
	
	$internal_links_index = 0;					// Проход по внутренним ссылкам
	$internal_links_count = count($internal_links);
	$check = false;
	while (!$check && $internal_links_index < $internal_links_limit && $average_time < $time_limit)
	{
		$start_internal = microtime(true);
		echo "<br>".($internal_links_index+1).") INTERNAL ";
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
		printf('Link was in process for %.4F sec.<br>', $time);
		$time = microtime(true) - $start_link;
		$average_time = ($time / $internal_links_index);
		printf('Average time:  %.4F sec.<br>', $average_time);
	}
}

$email_count = count($email_array);
echo "<br>Emails: ".$email_count."<br>";
for ($i = 0; $i < $email_count; $i++)
{
	echo $email_array[$i]." : ".$email_link[$i]."<br>";
	file_put_contents($emails_file, PHP_EOL.$email_array[$i], FILE_APPEND);
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
		$ex_link = $ext_parse[scheme]."://".$ext_parse[host];
		if (in_array($ex_link, $used_links) || in_array($ex_link, $new_used_links))
			continue;
		$ext_host = preg_replace('/^www\./', '',  $ext_parse[host]);
		$response = $client->post('http://seo.sed.de/links/start/search', [
				'body' => [
					'search' => $ext_host,
				]
			]);
		$body = $response->getBody(true);
		$body = $body->__toString();
		$findme   = 'Link is found';
		$in_database_check = strpos($body, $findme);

		if ($in_database_check !== false)
			echo "$link is in <font style=\"background-color: Red\">database</font><br>";
		else
		{
			file_put_contents($newLinks_file, PHP_EOL.$link, FILE_APPEND);
			$ip = gethostbyname($ext_parse[host]);
			$country = "not ready";
			//$country_url = "http://ipgeobase.ru/?address=".$ip."&search=%C8%F1%EA%E0%F2%FC";
			//$country_data = @file_get_html($country_url);
			//$country_array = find_inner_text($country_data, 'b');
			//$country = $country_array[0];
			echo "$link is <font style=\"background-color: Green\">valid</font> country: $country<br>";
		}				
	}
}

foreach ($new_used_links as $u_link)
	file_put_contents("/var/www/html/linktraveler/database/old/oldLinks.txt", PHP_EOL.$u_link, FILE_APPEND);
$time = microtime(true) - $start; // Выключение таймера
printf('<br>Script was in process for %.4F sec.', $time);
$content = ob_get_contents();
$f = fopen($result, "w");
fwrite($f, $content);
fclose($f); 

?>
