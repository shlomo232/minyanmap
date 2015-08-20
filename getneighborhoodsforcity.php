<?php
ini_set('display_errors', 'On');
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'hunter2';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

if(! get_magic_quotes_gpc() ) {
	$city = addslashes ($_GET['city']);
} else {
	$city = $_GET['city'];
}
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('maindb');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);

$cityquery = mysql_query('SELECT * from `neighborhoods` WHERE (`neighborhood_city` = "'.$city.'" )') or die($cityquery."<br/><br/>".mysql_error());

echo "<select name=neighborhoodid id=neighborhoodid>";
while ($row = mysql_fetch_array( $cityquery )){
	echo "<option value=\"".$row['neighborhood_id']."\">".$row['neighborhood_nameen']." ".$row['neighborhood_namehe']."</option>";
}
echo "</select>";
?>
