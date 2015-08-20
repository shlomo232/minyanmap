#!/usr/bin/php
<?php
for ($i=1;$i<2;$i++) {
    echo 'http://tfilot.co.il/shulDetails.php?shulId='.$i;
//    $filetext = file_get_contents('http://tfilot.co.il/shulDetails.php?shulId='.$i);
  system('wget http://tfilot.co.il/shulDetails.php?shulId='.$i.' ~',$output);
    $filetext = strip_tags($filetext);
    echo $filetext; 
}
?>
