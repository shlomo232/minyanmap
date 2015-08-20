<?php
include 'functions.php';

/*
planned algorithm (do for shacharit,musaf,mincha,maariv in order):

1) retrieve minyans in array:
        while ($minyanrow = mysql_fetch_array($minyanquery)){
            array_push($minyanarray,array($row['minyan_day'],$minyanrow['minyan_time']));
        }

2) make minyan_day descriptive:

shacharit:
123456 - beymei chol
7 - beshabbat
other - beyemei bet,hei

min/mus:
12345 - beymei chol
6 - beerev shabbat
7 - beshabbat
other - beymei alef,sh

mar:
12345 - bechol
6 - beerev shabbat
7 - bemotzaei shabbat
other - beymei alef,sh

3) sort by minyan_day

    function compare_shacharitday($a, $b) { // returns positive -> $b should come first in list
    }
    usort($shacharitarray, 'compare_shacharitday');

4) combine all with same minyan_day into list of times. "time" is a string that could include words like shkia, retzef

*/

$shulid=$_GET["shulid"];

mysql_connect("localhost", "root", "hunter2") or die(mysql_error());
mysql_select_db("min") or die(mysql_error());
mysql_set_charset('utf8');
$shulquery = mysql_query('SELECT * FROM `shuls` where ( `shul_id` = \''.$shulid.'\' )');
$row = mysql_fetch_array( $shulquery );

$shacharitquery = mysql_query('SELECT * FROM `minyans` where ( `minyan_shulid` = \''.$shulid. '\' and `minyan_whichprayer` = \'shacharit\' )');
$shacharittimes="";
while ($minyanrow = mysql_fetch_array($shacharitquery)){
    $shacharittimes=$shacharittimes.sanitizeMinyanTime($minyanrow['minyan_time']).', ';
}
$minchaquery = mysql_query('SELECT * FROM `minyans` where ( `minyan_shulid` = \''.$shulid. '\' and `minyan_whichprayer` = \'mincha\' )');
$minchatimes="";
while ($minyanrow = mysql_fetch_array($minchaquery)){
    $minchatimes=$minchatimes.sanitizeMinyanTime($minyanrow['minyan_time']).', ';
}
$maarivquery = mysql_query('SELECT * FROM `minyans` where ( `minyan_shulid` = \''.$shulid. '\' and `minyan_whichprayer` = \'maariv\' )');
$maarivtimes="";
while ($minyanrow = mysql_fetch_array($maarivquery)){
    $maarivtimes=$maarivtimes.sanitizeMinyanTime($minyanrow['minyan_time']).', ';
}

echo 'infowindow.setContent("<b>' . mysql_real_escape_string($row['shul_name'])
    . '</b><br><br><b>כתובת: </b>' . mysql_real_escape_string($row['shul_address']) 
    . ', ' . $row['shul_neighborhood'] . ', ' . $row['shul_city']
    . '<br>נוסח: ' . $row['shul_nusach']
    . '<br>פרטי קשר: ' . $row['shul_contactinfo']. '<br>';
if (strlen($shacharittimes)>0) { echo  '<br>שחרית בחול: ' . trim($shacharittimes,", "); }
if (strlen($minchatimes)>0) { echo '<br>מנחה בחול: ' . trim($minchatimes,", "); }
if (strlen($maarivtimes)>0) { echo '<br>מעריב בחול: ' . trim($maarivtimes,", "); }
echo ' ");';


?>
