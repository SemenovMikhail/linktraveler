<?php
if(isset($_POST['formWheelchair']) &&
   $_POST['formWheelchair'] == 'Yes')
{
    echo "Требуется доступ.";
}
else
{
    echo "Доступ не нужен.";
}
?>     