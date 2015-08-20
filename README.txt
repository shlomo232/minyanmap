Needs mysql, php5
To add users, needs the php5-gd library (Currently, user management is not useful/active)
Set default_charset=utf8 for PHP
===============
TO IMPORT DB:
mysql -u root -p maindb < db.sql

TO EXPORT DB:
mysqldump -u root -p --skip-extended-insert maindb >db.sql
===============
Database structure:

cities:
	city_id
	city_nameen
	city_namehe

neighborhoods:
	neighborhood_id
	neighborhood_nameen
	neighborhood_namehe
	neighborhood_city *

shuls:
	shul_id
	shul_name
	shul_city *
	shul_neighborhood *
	shul_address
	shul_lat
	shul_lon
	shul_nusach
	shul_contactinfo

minyans:
	minyan_id
	minyan_shul *
	minyan_whichprayer
	minyan_time
	minyan_day


Pages:
	search.html - publicly visible.
	addcity.php, addneighborhood.php, addshul.php - add only, no editing. Administrator only. Editing will be with phpmyadmin.
	editshul.php - this is where you add OR edit minyans+info for the shul. Gabbaim or other such people will be able to edit a shul's page if they have permissions.

================
TODO [note: this is currently outdated and should be ignored]

SHORT RANGE TODO:
Adjust sidebar to only examine chosen city
Upon label click, move infowindow to label, and change its contents to shul's info
OSM tiles option

Potential improvements on tfilot:
Search by time range
Search by distance - maps
Accounts – 1) webmaster 2) regional 3) particular minyan

DATABASE WITH LAT/LON:
- Get info: http://tfilot.co.il/shulDetails.php?shulId=5640
- Parse
- For address, get lat/lon (geocoding) on google maps?
