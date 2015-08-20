<html>
<head><title>Add New City</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
// http://www.tutorialspoint.com/php/mysql_insert_php.htm
if(isset($_POST['add']))
{
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'hunter2';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8', $conn);

if(! get_magic_quotes_gpc() )
{
   $nameen = addslashes ($_POST['nameen']);
   $namehe = addslashes ($_POST['namehe']);
}
else
{
   $nameen = $_POST['nameen'];
   $namehe = $_POST['namehe'];
}

$sql = "INSERT INTO cities ".
       "(city_id,city_nameen,city_namehe) ".
       "VALUES(NULL,'$nameen','$namehe')";
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
mysql_select_db('maindb');
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not enter data: ' . mysql_error());
}
echo "Entered data successfully\n";
mysql_close($conn);
}
else
{
?>
<form method="post" accept-charset="utf-8" action="<?php $_PHP_SELF ?>">
English name <input name="nameen" type="text" id="nameen">
<p>Hebrew name <input name="namehe" type="text" id="namehe">
<p><input name="add" type="submit" id="add" value="Add City">
</form>
<?php
}
?>
</body>
</html>
