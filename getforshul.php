<?php
// Gets detailed minyan info for a shul, for use in shul editor
// Return format:
// Javascript commands for each 
// "addMinyanDisplay(prayer,time,days,editable);" for each minyan found

mysql_connect("localhost", "root", "hunter2") or die(mysql_error());
mysql_select_db("min") or die(mysql_error());
mysql_query("SET CHARACTER SET 'utf8'");

$shulquery = mysql_query('SELECT * FROM `shuls` where ( `shul_id` = '.$_GET["shulid"].' )');
$shulrow = mysql_fetch_array($shulquery);
echo 'document.getElementById("shul_name").value="'.$shulrow['shul_name'].'";';
//echo 'document.getElementById(shul_city).value="'.$shulrow['shul_name'].'";';
//echo 'document.getElementById(shul_neighborhood).value="'.$shulrow['shul_name'].'";';
echo 'document.getElementById("shul_address").value="'.$shulrow['shul_address'].'";';

$minyanquery = mysql_query('SELECT * FROM `minyans` where ( `minyan_shulid` = '.$_GET["shulid"].' )');
while ($minyanrow = mysql_fetch_array($minyanquery)){
    echo 'addMinyanDisplay("'.$minyanrow['minyan_whichprayer'].'",'.$minyanrow['minyan_time'].',"'.$minyanrow['minyan_day'].'",1); ';
}

//echo date_sunrise(time(),SUNFUNCS_RET_DOUBLE,32.79,35.02).' '.date_sunset(time(),SUNFUNCS_RET_DOUBLE,32.79,35.02);
?>


