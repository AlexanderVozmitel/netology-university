<?php 
$range = array(0, 7); 
$amount = 8; 

$r = array(); 

for ($i=0; $i<$amount; ++$i) { 
    $rnd = mt_rand($range[0], $range[1] - count($r)); 
	foreach ($r as $v) if ($rnd >= $v) ++$rnd;
    $r[] = $rnd; 
    sort($r); 
} 
shuffle($r); 
 
var_dump($r); 
?>