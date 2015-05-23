<?php

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

class ipcountry
{
    public $struct_ip;
    public $struct_country;
}

function check_country($ip_local)
{
	$country_url = "http://ipgeobase.ru/?address=".$ip_local."&search=%C8%F1%EA%E0%F2%FC";
	$country_data = file_get_html($country_url);
	$country_array = find_inner_text($country_data, 'b');
	return $country_array[0];
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
	$data = file_get_html($replace);

	//$titles = find_inner_text($data, "title");
	//foreach ($titles as $title)
	//	echo "<br>TITLE IS: ".$title."<br>";
	
	$find_elements = find_all_elements($data, "href", "*");
	
	foreach($find_elements as $local_link)
	{
		if ($local_link == "")
			continue;
		preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i", $local_link, $email_matches);								// Check email
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

		if (preg_replace('/^www\./', '',  $local_hostname) == preg_replace('/^www\./', '',$hostname)) 	// Internal link
		{
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
		else																	// External link
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


if( isset( $_POST['buf_submit'] ) )
{
	$array = $_POST['buf_link'];

	date_default_timezone_set('Europe/Moscow');
	$date = date("Y-m-d_H-i-s");
	$newLinks_file = "/var/www/html/linktraveler/database/new/newLinks_".$date.".txt";
		$fp = fopen($newLinks_file, "w");
		fclose($fp);
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
	return 0;
}


ob_start();
error_reporting(E_ALL ^ E_NOTICE);	
set_time_limit(0);	// 
$start = microtime(true);
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
$ipcountry_array = array();
$local_used_links = array();
$internal_links_limit = 150;
$time_limit = 15;
$log_path = "/var/www/html/linktraveler/database/log.txt";

//$myFile ="http://linktraveler.ru/linktraveler/database/new/test2.txt";
$myFile = $argv[1];
$f = fopen($myFile, "r");
while(!feof($f)) 
{ 
	$line = fgets($f);
	if ($line !== PHP_EOL)
	{
		$links[] = str_replace(PHP_EOL, "", $line);
	}
}
fclose($f);

date_default_timezone_set('Europe/Moscow');
$date = date("Y-m-d_H-i-s");


$f = fopen("/var/www/html/linktraveler/database/old/oldLinks.txt", "r");
while(!feof($f)) 
{ 
	$line = fgets($f);
	if ($line !== PHP_EOL)
		$used_links[] = str_replace(PHP_EOL, "", $line);
}
fclose($f);

$result = "/var/www/html/linktraveler/database/result/result_".$date.".html";
$result_url = "http://linktraveler.ru/linktraveler/database/result/result_".$date.".html";
$fp = fopen($result, "w");
fclose($fp);

$external_links_count = count($links);
$external_links_index = 0;

foreach ($links as $url)						// External links cicle
{
	$start_link = microtime(true);
	$used_parse = parse_url($url);
	$used_link = $used_parse[scheme]."://".$used_parse[host];
	if (in_array($used_link, $used_links) || in_array($used_link, $new_used_links))
	{
		$external_links_index++;
		$date_log = date("Y-m-d_H-i-s");
		$line = "$date_log : $external_links_index / $external_links_count links was proceed";
		file_put_contents($log_path, PHP_EOL.$line, FILE_APPEND);
		continue;
	}
	$internal_links = array();
	$average_time = 0;
	
	echo "EXTERNAL ";
	LinkProceed($url);
	
	$new_used_links[] = $used_link;
	
	$internal_links_index = 0;					// Internal links cicle
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
		$time = microtime(true) - $start_internal;
		printf('Link was in process for %.4F sec.<br>', $time);
		$time = microtime(true) - $start_link;
		$average_time = ($time / $internal_links_index);
		printf('Average time:  %.4F sec.<br>', $average_time);
	}
	$external_links_index++;
	$date_log = date("Y-m-d_H-i-s");
	$line = "$date_log : $external_links_index / $external_links_count links was proceed";
	file_put_contents($log_path, PHP_EOL.$line, FILE_APPEND);
}

$date_log = date("Y-m-d_H-i-s");
$line = "$date_log: links in post-processing";
file_put_contents($log_path, PHP_EOL.$line, FILE_APPEND);
$email_count = count($email_array);
echo "<br>Emails: ".$email_count."<br>";
if ($email_count > 0)
{
	
	$emails_file = "/var/www/html/linktraveler/database/emails/emails_".$date.".txt";
	$fp = fopen($emails_file, "w");
	fclose($fp);
	for ($i = 0; $i < $email_count; $i++)
	{
		echo $email_array[$i]." : ".$email_link[$i]."<br>";
		file_put_contents($emails_file, PHP_EOL.$email_array[$i], FILE_APPEND);
	}
}

echo "<br>External links: ".count($external_links)."<br>";
echo '<form method="POST">
	<table width="100%" cellspacing="0" cellpadding="4" border="1">
	<tr>
	<td width="5%">ID</td>
	<td width="10%">Valid</td>
	<td width="35%">Host</td>
	<td width="20%">IP</td>
	<td width="10%">In Seosed</td>
	<td width="10%">Country</td>
	<td width="10%">Add</td>
	</tr>';
$id_count = 0;
foreach ($external_links as $link)
{
	$id_count++;
	echo '<tr>';
	if(check_url_for_errors($link))
	{
		echo '<td>'.$id_count.'</td><td style="background-color: Red">false</td><td><a href="'.$link.'">'.$link.'.</a></td><td>null</td><td>null</td><td>null</td><td></td>';
	//	echo "<a href='$link'>$link</a> is <font color=\"Red\">not valid</font><br>";
	}
	else
	{
		$ext_parse = parse_url($link);
		$ex_link = $ext_parse[scheme]."://".$ext_parse[host];
		$ip = gethostbyname($ext_parse[host]);
		if (in_array($ex_link, $local_used_links) || in_array($ex_link, $used_links) || in_array($ex_link, $new_used_links))
			continue;
		echo '<td>'.$id_count.'</td><td style="background-color: Green">true</td><td><a href="'.$ex_link.'">'.$ex_link.'</a></td><td>'.$ip.'</td>';
		$local_used_links[] = $ex_link;
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
			echo '<td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="'.$ex_link.'"/></td>';
			//echo "<a href='$link'>$link</a> is in <font style=\"background-color: Red\">database</font><br>";
		else
		{
			//file_put_contents($newLinks_file, PHP_EOL.$link, FILE_APPEND);
			$country = null;
			foreach($ipcountry_array as $struct) 
			{
				if ($ip == $struct->struct_ip) 
				{
					$country = $struct->struct_country;
					break;
				}
			}
			if ($country == null)
			{
				$country = check_country($ip);
				$new_ipcountry = new ipcountry();
				$new_ipcountry->struct_ip = $ip;
				$new_ipcountry->struct_country = $country;
				$ipcountry_array[] = $new_ipcountry;
			}
			echo '<td style="background-color: Green">valid</td><td>'.$country.'</td><td><input name="buf_link[]" type="checkbox" value="'.$ex_link.'"/></td>';
			//echo "<a href='$link'>$link</a> is <font style=\"background-color: Green\">valid</font> country: $country<br>";
		}				
	}
	echo '</tr>';
}
echo '</table>
	<input type="submit" name="buf_submit" value="Form new links file" />
	</form> ';
foreach ($new_used_links as $u_link)
	file_put_contents("/var/www/html/linktraveler/database/old/oldLinks.txt", PHP_EOL.$u_link, FILE_APPEND);
$time = microtime(true) - $start;
printf('<br>Script was in process for %.4F sec.', $time);
$content = ob_get_contents();
$f = fopen($result, "w");
fwrite($f, $content);
fclose($f); 
$log_path = "/var/www/html/linktraveler/database/log.txt";
$date = date("Y-m-d_H-i-s");
$line = "$date : Script finished. Result url: ".$result_url;
file_put_contents($log_path, PHP_EOL.$line.PHP_EOL, FILE_APPEND);
?>
