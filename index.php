﻿<form method="POST"> 
	<p>Указать путь к файлу:</p>
	<input name="inputUrl" type="text" id="url" value="";/>
	<input name="Submit" type="submit" value="LinkTraveler" />
</form>

<?php
set_time_limit(0);
if( isset( $_POST['Submit'] ) ) // Начало скрипта
    {				
	    $url = $_POST['inputUrl'];
	    $log_path = "/var/www/html/linktraveler/database/log.txt";
	    set_time_limit(0);	// ����� ������ �� ������� ����� 30 ������
	    //$log_file = fopen($log_path, "w");
	    //fclose($log_file);
	    date_default_timezone_set('UTC');
	    $date = date("Y-m-d_H-i-s");
	    $line = "Script started at: ".$date." . Input links url: ".$url;
	    file_put_contents($log_path, PHP_EOL.$line, FILE_APPEND);
	    exec('php /var/www/html/linktraveler/scripts/linktraveler.php '.$url);	
	    echo "Скрипт завершил свою работую";
    }
?>
