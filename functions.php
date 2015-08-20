<?php
function sanitizeMinyanTime($mtime){
    // Time format:
    //   0-2359     Time
    //   2500+-60   Around Alot hashachar
    //   2700+-60   Around Hanetz
    //   2900+-60   Around Shkiah
    //   3100+-60   Around Tzet
    //   3300+-60   Around Shabbat in time
    //   3500+-60   Around Shabbat out time
    //   >10000     Continuous minyans (8 digits: BBBBEEEE for begin and end)
    if ($mtime<2400) return $mtime;
    if ($mtime>10000) return intval($mtime/10000) . "-". ($mtime%10000). " ברצף";
    if ($mtime>=2400 && $mtime<3600) {
        if      ($mtime>=2400 && $mtime<2600) { $reltime=$mtime-2500; $mtime="עלות"; }
        else if ($mtime>=2600 && $mtime<2800) { $reltime=$mtime-2700; $mtime="הנץ"; }
        else if ($mtime>=2800 && $mtime<3000) { $reltime=$mtime-2900; $mtime="שקיעה"; }
        else if ($mtime>=3000 && $mtime<3200) { $reltime=$mtime-3100; $mtime="צאת"; }
        else if ($mtime>=3200 && $mtime<3400) { $reltime=$mtime-3300; $mtime="Shabbat in";}
        else if ($mtime>=3200 && $mtime<3400) { $reltime=$mtime-3500; $mtime="Shabbat out";}
        if      ($reltime>0) {                     $mtime=$mtime."+".$reltime; }
        else if ($reltime<0) { $reltime=-$reltime-40; $mtime=$mtime."-".$reltime; }
        return $mtime;
    }
}

function isNameHebrew($city) {
    if(ord($city) == 215) return true;
    return false;
}

?>
