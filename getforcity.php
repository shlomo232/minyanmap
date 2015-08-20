<?php
// Outputs Javascript commands relating to the city name we entered:
// 1) Add shul markers in the city 2) Resize map to shul bounding box

include 'functions.php';

$city=$_GET["city"];
$whichprayer=$_GET["prayer"];
$day=$_GET["day"];

// Select city (Get ID for first city in DB matching our name)
mysql_connect("localhost", "root", "hunter2") or die(mysql_error());
mysql_select_db("maindb") or die(mysql_error());
mysql_set_charset('utf8');
if (isNameHebrew($city)) {
    $result = mysql_query('SELECT * FROM `cities` where ( `city_namehe` = \''.$city.'\' )');
    $row = mysql_fetch_array( $result );
    $city=$row['city_id'];
} else {
    $result = mysql_query('SELECT * FROM `cities` where ( `city_nameen` = \''.$city.'\' )');
    $row = mysql_fetch_array( $result );
    $city=$row['city_id'];
}

// Remove existing markers (if any) from map
echo 'for (var i=0; markers.length>i; i++) {markers[i].setMap(null);} /*<br>*/';
echo 'markers=[];/*<br>*/';

// Read shuls in desired city, place markers
$shulquery = mysql_query('SELECT * FROM `shuls` where ( `shul_city` = \''.$city.'\' )');
$markercount=0;
$minyancount=0; // can have several minyans per marker
$legendarray=array();
while ($row = mysql_fetch_array( $shulquery )){
    // Get list of minyan times for this shul
    $minyanquery = mysql_query('SELECT * FROM `minyans` where ( `minyan_shul` = '.$row['shul_id'].' and `minyan_whichprayer` = "'.$whichprayer.'" and minyan_day LIKE \'%'. $day .'%\'  )');
    $thisshulminyantimes="";
    while ($minyanrow = mysql_fetch_array($minyanquery)){ // Put minyantimes into array 
        $legendarray[$minyancount]= array($minyanrow['minyan_time'],$row['shul_name']);
        $minyancount++;
        $thisshulminyantimes=$thisshulminyantimes.sanitizeMinyanTime($minyanrow['minyan_time']).', ';
    }
    $thisshulminyantimes=substr_replace($thisshulminyantimes,'',strlen($thisshulminyantimes)-2,2); //delete final comma
    mysql_free_result($minyanquery);
    if ($thisshulminyantimes != '') {// If this shul has minyan(s) for desired day and prayer
        // Add marker for this shul
        echo 'markers['.$markercount.'] = new BigLabel({ position:new google.maps.LatLng('.$row['shul_lat'].', '.$row['shul_lon'].'), map: map, text:"'.$thisshulminyantimes.'" },'.$row['shul_id']. ', "'.addslashes($row['shul_name']).'", this.infowindow); /*<br>*/';
        if ($markercount==0) { // Create new bounding box
            $maxlat=$row['shul_lat'];
            $minlat=$row['shul_lat'];
            $maxlon=$row['shul_lon'];
            $minlon=$row['shul_lon'];
        } else { // Expand bounding box
            if ($row['shul_lat']>$maxlat) { $maxlat=$row['shul_lat']; }
            if ($row['shul_lat']<$minlat) { $minlat=$row['shul_lat']; }
            if ($row['shul_lon']>$maxlon) { $maxlon=$row['shul_lon']; }
            if ($row['shul_lon']<$minlon) { $minlon=$row['shul_lon']; }
        }
        $markercount++;
    }
}

// Resize visible area
if ($markercount>0) {
//	    echo 'alert(markers[0].span_.innerHTML);';
    echo 'map.fitBounds(mybounds=new google.maps.LatLngBounds(new google.maps.LatLng('.$minlat.','.$minlon.'),new google.maps.LatLng('.$maxlat.','.$maxlon.')));/*<br>*/';
    echo 'map.setZoom(Math.min(16,map.getZoom()));/*<br>*/'; // Don't zoom in too far
}
// Shift map slightly to force makeLegend() to be called
// echo 'map.panBy(Math.random()*.000001,0);'
?>
