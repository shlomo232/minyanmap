function radToDeg(angleRad) { // Convert radian angle to degrees
        return 180.0 * angleRad / 3.1415926;
}

function degToRad(angleDeg) {// Convert degree angle to radians
        return 3.1415926 * angleDeg / 180.0;
}

function calcJD(yr, mn, dy) { // Calculate Julian day from calendar day
// year : 4-digit year. month: January=1. day: 1-31.
// Number is returned for start of day.  Fractional days should be added later.
/*
        if (mn <= 2) { //         yr = yr - 1;  mn = mn + 12;        
            A = Math.floor((yr-1) / 100, 1);
            B = 2 - A + Math.floor(A / 4, 1);
            return Math.floor(365.25 * ((yr-1) + 4716), 1) + Math.floor(30.6001 * ((mn+12) + 1), 1) + dy + B - 1524.5;
        } else {
            A = Math.floor(yr / 100, 1);
            B = 2 - A + Math.floor(A / 4, 1);
            return Math.floor(365.25 * (yr + 4716), 1) + Math.floor(30.6001 * (mn + 1), 1) + dy + B - 1524.5;
        }
*/
        if (mn <= 2) { //         yr = yr - 1;  mn = mn + 12;  
            return Math.floor(365.25 * ((yr-1) + 4716), 1) + Math.floor(30.6001 * ((mn+12) + 1), 1) + dy + 2 - Math.floor((yr-1) / 100, 1) + Math.floor(Math.floor((yr-1) / 100, 1) / 4, 1) - 1524.5;
        } else {
            return Math.floor(365.25 * (yr + 4716), 1) + Math.floor(30.6001 * (mn + 1), 1) + dy + 2 - Math.floor(yr / 100, 1) + Math.floor(Math.floor(yr / 100, 1) / 4, 1) - 1524.5;
        }

}

function calcTimeJulianCent(JD) { //Convert the Julian day to centuries since J2000.0
        return (JD - 2451545.0) / 36525.0;
}

function calcJDFromJulianCent(t) { // Convert centuries since J2000.0 to Julian day
        return  t * 36525.0 + 2451545.0;
}

Number.prototype.mod = function(n) {
        return ((this%n)+n)%n;
}

function calcGeomMeanLongSun(t) { // Calculate the Geometric Mean Longitude (in degrees) of the Sun
// t : number of Julian centuries since J2000.0
        l0 = 280.46646 + t * (36000.76983 + 0.0003032 * t);
/*        do {
           if ((l0 <= 360) && (l0 >= 0)) break;
           if (l0 > 360) l0 = l0 - 360;
           if (l0 < 0) l0 = l0 + 360;
        } while (1); */
        return l0.mod(360);
}

function calcGeomMeanAnomalySun(t) { // Calculate the Geometric Mean Anomaly (in degrees) of the Sun
//'*   t : number of Julian centuries since J2000.0
        return 357.52911 + t * (35999.05029 - 0.0001537 * t);
}

function calcEccentricityEarthOrbit(t) { // Calculate the (unitless) eccentricity of earth's orbit
// t : number of Julian centuries since J2000.0
        return 0.016708634 - t * (0.000042037 + 0.0000001267 * t);
}

function calcSunEqOfCenter(t) { // Calculate the equation of center for the sun
// t : number of Julian centuries since J2000.0
// Return value: in degrees
        mrad = degToRad(calcGeomMeanAnomalySun(t));
        sinm = Math.sin(mrad);
        sin2m = Math.sin(mrad*2);
        sin3m = Math.sin(mrad*3);
        return sinm * (1.914602 - t * (0.004817 + 0.000014 * t)) + sin2m * (0.019993 - 0.000101 * t) + sin3m * 0.000289;
}

function calcSunTrueLong(t) { // Calculate the true longitude (in degrees) of the sun
// t : number of Julian centuries since J2000.0
        return calcGeomMeanLongSun(t) + calcSunEqOfCenter(t);
}

function calcSunTrueAnomaly(t) { // Calculate the true anomaly (in degrees) of the sun
// t : number of Julian centuries since J2000.0
        return calcGeomMeanAnomalySun(t) + calcSunEqOfCenter(t);
}

function calcSunApparentLong(t) { // Calculate the apparent longitude (in degrees) of the sun
//'* Name:    calcSunApparentLong (not used by sunrise, solarnoon, sunset)
//'*   t : number of Julian centuries since J2000.0
        omega = 125.04 - 1934.136 * t;
        return calcSunTrueLong(t) - 0.00569 - 0.00478 * Math.sin(degToRad(omega));
}

function calcMeanObliquityOfEcliptic(t) { // Calculate the mean obliquity (in degrees) of the ecliptic
// t : number of Julian centuries since J2000.0
        seconds = 21.448 - t * (46.815 + t * (0.00059 - t * (0.001813)));
        return 23.0 + (26.0 + (seconds / 60.0)) / 60.0;
}

function calcObliquityCorrection(t) { // Calculate the corrected obliquity (in degrees) of the ecliptic
// t : number of Julian centuries since J2000.0
        e0 = calcMeanObliquityOfEcliptic(t);
        omega = 125.04 - 1934.136 * t;
        return e0 + 0.00256 * Math.cos(degToRad(omega));
}        

function calcSunDeclination(t) { // Calculate the declination (in degrees) of the sun
// t : number of Julian centuries since J2000.0
        eee = calcObliquityCorrection(t);
        lambda = calcSunApparentLong(t);
        sint = Math.sin(degToRad(eee)) * Math.sin(degToRad(lambda));
        return radToDeg(Math.asin(sint));
}

function calcEquationOfTime(t) {
// Calculate the difference (in minutes of time) between true solar time and mean solar time
// t : number of Julian centuries since J2000.0
        epsilon = calcObliquityCorrection(t);
        l0 = calcGeomMeanLongSun(t);
        eee = calcEccentricityEarthOrbit(t);
        m = calcGeomMeanAnomalySun(t);

        y = Math.tan(degToRad(epsilon) / 2.0);
        y = y * y;

        sin2l0 = Math.sin(2.0 * degToRad(l0));
        sinm = Math.sin(degToRad(m));
        cos2l0 = Math.cos(2.0 * degToRad(l0));
        sin4l0 = Math.sin(4.0 * degToRad(l0));
        sin2m = Math.sin(2.0 * degToRad(m));

        Etime = y * sin2l0 - 2.0 * eee * sinm + 4.0 * eee * y * sinm * cos2l0 
                - 0.5 * y * y * sin4l0 - 1.25 * eee * eee * sin2m;

        return radToDeg(Etime) * 4.0;
}    

function calcHourAngleDawn(lat, solarDec, solardepression) { //Calculate the hour angle of the sun at dawn
        latRad = degToRad(lat);
        sdRad = degToRad(solarDec);
        return (Math.acos(Math.cos(degToRad(90.0 + solardepression))
              / (Math.cos(latRad) * Math.cos(sdRad)) - Math.tan(latRad) * Math.tan(sdRad)));
}

function calcHourAngleSunrise(lat, solarDec) { // Calculate the hour angle of the sun at sunrise
// For sunrise and sunset, we assume 0.833° of atmospheric refraction
//'* For details about refraction see http://www.srrb.noaa.gov/highlights/sunrise/calcdetails.html
        return calcHourAngleDawn(lat, solarDec, 0.833);
}

function calcHourAngleSunset(lat, solarDec) { // Calculate the hour angle of the sun at sunset
        return -calcHourAngleSunrise(lat, solarDec);
}

function calcHourAngleDusk(lat, solarDec, solardepression) { // calculate the hour angle of the sun at dusk
        return -calcHourAngleDawn(lat, solarDec, solardepression);
}

function calcDawnUTC(JD, latitude, longitude, solardepression) { // Calculate the Universal Coordinated Time (UTC) of dawn
        t = calcTimeJulianCent(JD);
// *** First pass to approximate sunrise
        eqtime = calcEquationOfTime(t);
        solarDec = calcSunDeclination(t);
        hourangle = calcHourAngleSunrise(latitude, solarDec);
        delta = longitude - radToDeg(hourangle);
        timeDiff = 4 * delta;
        timeUTC = 720 + timeDiff - eqtime;
//' *** Second pass includes fractional jday in gamma calc
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + timeUTC / 1440.0);
        eqtime = calcEquationOfTime(newt);
        solarDec = calcSunDeclination(newt);
        hourangle = calcHourAngleDawn(latitude, solarDec, solardepression);
        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        return 720.0 + timeDiff - eqtime;// in minutes
}

function calcSunriseUTC(JD, latitude, longitude) { // Calculate the Universal Coordinated Time (UTC) of sunrise for the given Julian day
        t = calcTimeJulianCent(JD);
// *** First pass to approximate sunrise
        eqtime = calcEquationOfTime(t);
        solarDec = calcSunDeclination(t);
        hourangle = calcHourAngleSunrise(latitude, solarDec);
        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        timeUTC = 720.0 + timeDiff - eqtime;
//' *** Second pass includes fractional jday in gamma calc
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + timeUTC / 1440.0)
        eqtime = calcEquationOfTime(newt);
        solarDec = calcSunDeclination(newt);
        hourangle = calcHourAngleSunrise(latitude, solarDec);

        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        timeUTC = 720.0 + timeDiff - eqtime;
        return timeUTC;
}

function calcSolNoonUTC(t, longitude) { //Calculate the Universal Coordinated Time (UTC) of solar noon for the given day
//   t : number of Julian centuries since J2000.0
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + 0.5 + longitude / 360.0);
        eqtime = calcEquationOfTime(newt);
        solarNoonDec = calcSunDeclination(newt);
        solNoonUTC = 720.0 + (longitude * 4.0) - eqtime;
        return solNoonUTC;
}

function calcSunsetUTC(JD, latitude, longitude) { // Calculate the UTC of sunset for the given Julian day
        t = calcTimeJulianCent(JD);
        // First calculates sunrise and approx length of day
        eqtime = calcEquationOfTime(t);
        solarDec = calcSunDeclination(t);
        hourangle = calcHourAngleSunset(latitude, solarDec);
        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        timeUTC = 720.0 + timeDiff - eqtime;
        // first pass used to include fractional day in gamma calc
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + timeUTC / 1440.0);
        eqtime = calcEquationOfTime(newt);
        solarDec = calcSunDeclination(newt);
        hourangle = calcHourAngleSunset(latitude, solarDec);

        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        timeUTC = 720.0 + timeDiff - eqtime;
        return timeUTC;
}

function calcDuskUTC(JD, latitude, longitude, solardepression) {
        t = calcTimeJulianCent(JD);
        // First calculates sunrise and approx length of day
        eqtime = calcEquationOfTime(t);
        solarDec = calcSunDeclination(t);
        hourangle = calcHourAngleSunset(latitude, solarDec);
        delta = longitude - radToDeg(hourangle);
        timeDiff = 4 * delta;
        timeUTC = 720 + timeDiff - eqtime;
        // first pass used to include fractional day in gamma calc
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + timeUTC / 1440.0);
        eqtime = calcEquationOfTime(newt);
        solarDec = calcSunDeclination(newt);
        hourangle = calcHourAngleDusk(latitude, solarDec, solardepression);

        delta = longitude - radToDeg(hourangle);
        timeDiff = 4.0 * delta;
        timeUTC = 720.0 + timeDiff - eqtime;
        return timeUTC;
}

function dawn(lat, lon, year, month, day, timeZone, dlsTime, solardepression) {
// change sign convention for longitude from negative to positive in western hemisphere
            latitude = lat;
            if (latitude > 89.8) latitude = 89.8;
            if (latitude < -89.8) latitude = -89.8;
            JD = calcJD(year, month, day);
            riseTimeGMT = calcDawnUTC(JD, latitude, -lon, solardepression);
            return (riseTimeGMT + (60.0 * timeZone) + (dlsTime * 60.0)) / 1440.0;
}

function sunrise(latitude, lon, year, month, day, timeZone, dlsTime) {
//change sign convention for longitude from negative to positive in western hemisphere
            longitude = lon * -1;
            if (latitude > 89.8) latitude = 89.8;
            if (latitude < -89.8) latitude = -89.8;

            JD = calcJD(year, month, day);
            riseTimeGMT = calcSunriseUTC(JD, latitude, longitude);
            riseTimeLST = riseTimeGMT + (60 * timeZone) + (dlsTime * 60);
            return riseTimeLST / 1440;
}

function sunset(latitude, lon, year, month, day, timeZone, dlsTime) {
//' change sign convention for longitude from negative to positive in western hemisphere
            longitude = lon * -1;
            if (latitude > 89.8) latitude = 89.8;
            if (latitude < -89.8) latitude = -89.8;
            
            JD = calcJD(year, month, day);
            setTimeGMT = calcSunsetUTC(JD, latitude, longitude);
            setTimeLST = setTimeGMT + (60 * timeZone) + (dlsTime * 60);
            return setTimeLST / 1440.0;             //  convert to days
}

function dusk(latitude, lon, year, month, day, timeZone, dlsTime, solardepression) {
//' change sign convention for longitude from negative to positive in western hemisphere
            longitude = lon * -1;
            if (latitude > 89.8) latitude = 89.8;
            if (latitude < -89.8) latitude = -89.8;
            
            JD = calcJD(year, month, day);
            setTimeGMT = calcDuskUTC(JD, latitude, longitude, solardepression);           
            return (setTimeGMT + (60 * timeZone) + (dlsTime * 60))/1440.0;
}

function solarnoon(latitude, lon, year, month, day, timeZone, dlsTime) {
// change sign convention for longitude from negative to positive in western hemisphere
        longitude = lon * -1;
        if (latitude > 89.8)  latitude = 89.8;
        if (latitude < -89.8) latitude = -89.8;
        
        JD = calcJD(year, month, day);
        t = calcTimeJulianCent(JD);
        
        newt = calcTimeJulianCent(calcJDFromJulianCent(t) + 0.5 + longitude / 360.0);

        eqtime = calcEquationOfTime(newt);
        solarNoonDec = calcSunDeclination(newt);
        solNoonUTC = 720.0 + (longitude * 4.0) - eqtime;
        solarnoon = solNoonUTC + (60 * timeZone) + (dlsTime * 60);
        return solarnoon / 1440.0;
}

function localRadius(lat) {
    A = 6378137.0;
    B = 6356752.3;
    return Math.sqrt((((A ^ 2 * Math.cos(lat)) ^ 2) + ((B ^ 2 * Math.sin(lat)) ^ 2)) / (((A * Math.cos(lat)) ^ 2) + ((B * Math.sin(lat)) ^ 2)));
}

function local_sunrise(theDate, latitude, longitude, altitude, timeZone, dlsTime) {
    earthRadius = localRadius(latitude);
    return dawn(latitude, longitude, year(theDate), month(theDate), day(theDate), timeZone, dlsTime, 0.833 + Math.acos(earthRadius / (earthRadius + altitude)) * 180 / 3.141592654);
}

function local_sunset(theDate, latitude, longitude, altitude, timeZone, dlsTime) {
    earthRadius = localRadius(latitude);
    return dusk(latitude, longitude, year(theDate), month(theDate), day(theDate), timeZone, dlsTime, 0.833 + Math.acos(earthRadius / (earthRadius + altitude)) * 180.0 / 3.141592654);
}
