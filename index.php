<form method="POST"> 
	<p>Указать путь к файлу:</p>
	<input name="inputUrl" type="text" id="url" value="";/>
	<input name="Submit" type="submit" value="LinkTraveler" />
</form>

<?php
set_time_limit(0);
if( isset( $_POST['Submit'] ) ) // Начало скрипта
    {				
	$url = $_POST['inputUrl'];
	exec('php /var/www/html/linktraveler/scripts/linktraveler.php '.$url);	
	echo "Скрипт завершил свою работую";
    }
?>
