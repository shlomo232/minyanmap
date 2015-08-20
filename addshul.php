<html>
<head><title>Add New Shul</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link rel="stylesheet" href="css/leaflet.css" />
 <link rel="stylesheet" href="css/main.css" />
 <script src="scripts/leaflet.js"></script>

<script type="text/javascript">
var map;

function onMapMove (e) {
	document.getElementById('lat').value=map.getCenter().lat;
	document.getElementById('lon').value=map.getCenter().lng;
}

function initialize() {
	map = L.map('map').setView([31.7857, 35.2204], 11);
	L.tileLayer('http://b.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	    maxZoom: 18,
	}).addTo(map);
	map.on('moveend', onMapMove);

	var crosshairIcon = L.icon({
		iconUrl: 'images/crosshair.png',
		iconSize:     [20, 20], // size of the icon
		iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
	});
	crosshair = new L.marker(map.getCenter(), {icon: crosshairIcon, clickable:false});
	crosshair.addTo(map);

	// Move the crosshair to the center of the map when the user pans
	map.on('move', function(e) {
		crosshair.setLatLng(map.getCenter());
	});

	getNeighborhoodList();
}

// Generate dropdown list of neighborhoods
function getNeighborhoodList() {
	citylist = document.getElementById('cityid');
	cityid=1;
	cityid = citylist[citylist.selectedIndex].value;

	if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }// modern browsers
	else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }// IE 5,6
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById('neighborhoodlist').innerHTML=xmlhttp.responseText; 
	} }
	xmlhttp.open("GET","getneighborhoodsforcity.php?city="+cityid,true);
	xmlhttp.send();
}

</script>
</head>
<body onLoad="javascript:initialize()">
<?php
ini_set('display_errors', 'On');
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'hunter2';

/////////////////////
// Adding data
/////////////////////
if(isset($_POST['add'])) // http://www.tutorialspoint.com/php/mysql_insert_php.htm
{
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8', $conn);

if(! get_magic_quotes_gpc() ) {
	$name = addslashes ($_POST['name']);
	$address = addslashes ($_POST['address']);
	$lat = addslashes ($_POST['lat']);
	$lon = addslashes ($_POST['lon']);
	$nusach = addslashes ($_POST['nusach']);
	$contactinfo = addslashes ($_POST['contactinfo']);
} else {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	$nusach = $_POST['nusach'];
	$contactinfo = $_POST['contactinfo'];
}
$city=$_POST['cityid'];
$neighborhood=$_POST['neighborhoodid'];

$sql = "INSERT INTO shuls ".
	"(shul_id, shul_name, shul_city, shul_neighborhood, shul_address, shul_lat, shul_lon, shul_nusach, shul_contactinfo) ".
	"VALUES(NULL,'$name', '$city', '$neighborhood', '$address', '$lat', '$lon', '$nusach', '$contactinfo')";
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
mysql_select_db('maindb');
$retval = mysql_query( $sql, $conn );
if(! $retval ) {
	die('Could not enter data: ' . mysql_error());
}
echo "Entered data successfully\n";
mysql_close($conn);

/////////////////////
// Input form
/////////////////////
} else {
?>
<form method="post" accept-charset="utf-8" action="<?php $_PHP_SELF ?>">
<p>City: 
<?php
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('maindb');
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
$cityquery = mysql_query('SELECT * FROM `cities`') or die($cityquery."<br/><br/>".mysql_error());
echo "<select name=cityid id=cityid onchange=getNeighborhoodList()>";
while ($row = mysql_fetch_array( $cityquery )){
	echo "<option value=\"".$row['city_id']."\">".$row['city_nameen']." ".$row['city_namehe']."</option>";
}
echo "</select>";

?>
<p>Neighborhood: <div id=neighborhoodlist></div>
<p>Shul name <input name="name" type="text" id="name">
<p>Shul address <input name="address" type="text" id="address">
<p>Shul latitude <input name="lat" type="text" id="lat">
<p>Shul longitude <input name="lon" type="text" id="lon">
 <div id="map"></div>

<p>Shul nusach <input name="nusach" type="text" id="nusach">
<p>Shul contactinfo <input name="contactinfo" type="text" id="contactinfo">

<p><input name="add" type="submit" id="add" value="Add Shul">
</form>
<?php
}
?>
</body>
</html>
