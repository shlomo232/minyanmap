<html>
<head><title>Add New Neighborhood</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
ini_set('display_errors', 'On');
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'hunter2';

// Adding data
if(isset($_POST['add'])) // http://www.tutorialspoint.com/php/mysql_insert_php.htm
{
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8', $conn);

if(! get_magic_quotes_gpc() ) {
	$nameen = addslashes ($_POST['nameen']);
	$namehe = addslashes ($_POST['namehe']);
} else {
	$nameen = $_POST['nameen'];
	$namehe = $_POST['namehe'];
}
$cityid=$_POST['cityid'];

$sql = "INSERT INTO neighborhoods ".
	"(neighborhood_id,neighborhood_nameen,neighborhood_namehe,neighborhood_city) ".
	"VALUES(NULL,'$nameen','$namehe','$cityid')";
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
mysql_select_db('maindb');
$retval = mysql_query( $sql, $conn );
if(! $retval ) {
	die('Could not enter data: ' . mysql_error());
}
echo "Entered data successfully\n";
mysql_close($conn);

// Input form
} else {
?>
<form method="post" accept-charset="utf-8" action="<?php $_PHP_SELF ?>">
English neighborhood name <input name="nameen" type="text" id="nameen">
<p>Hebrew neighborhood name <input name="namehe" type="text" id="namehe">
<p>City: 
<?php
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('maindb');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
$cityquery = mysql_query('SELECT * FROM `cities`') or die($cityquery."<br/><br/>".mysql_error());
echo "<select name=cityid>";
while ($row = mysql_fetch_array( $cityquery )){
	echo "<option value=\"".$row['city_id']."\">".$row['city_nameen']." ".$row['city_namehe']."</option>";
}
echo "</select>";
?>

<p><input name="add" type="submit" id="add" value="Add Neighborhood">
</form>
<?php
}
?>
</body>
</html>
