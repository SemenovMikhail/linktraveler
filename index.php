<form method="POST"> 
	<p>РЈРєР°Р·Р°С‚СЊ РїСѓС‚СЊ Рє С„Р°Р№Р»Сѓ:</p>
	<input name="inputUrl" type="text" id="url" value="";/>
	<input name="Submit" type="submit" value="LinkTraveler" />
</form>

<?php
set_time_limit(0);
if( isset( $_POST['Submit'] ) ) // РќР°С‡Р°Р»Рѕ СЃРєСЂРёРїС‚Р°
    {				
	    $url = $_POST['inputUrl'];
	    $log_path = "/var/www/html/linktraveler/database/log.txt";
	    set_time_limit(0);	// Чтобы скрипт не зависал через 30 секунд
	    //$log_file = fopen($log_path, "w");
	    //fclose($log_file);
	    date_default_timezone_set('UTC');
	    $date = date("Y-m-d_H-i-s");
	    $line = "Script started at: ".$date." . Input links url: ".$url;
	    file_put_contents($log_path, PHP_EOL.$line, FILE_APPEND);
	    exec('php /var/www/html/linktraveler/scripts/linktraveler.php '.$url);	
	    echo "РЎРєСЂРёРїС‚ Р·Р°РІРµСЂС€РёР» СЃРІРѕСЋ СЂР°Р±РѕС‚СѓСЋ";
    }
?>
