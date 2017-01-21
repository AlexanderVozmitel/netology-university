<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$continent = array(
		'Africa' => array(
			'Mammuthus columbi',
			'Gazella dorcas',
			'Felis margarita',
			'Trioceros jacksonii'
		),
		'Australia' => array(
			'Dromaius novaehollandiae',
			'Sarcophilus laniarius',
			'Thylacinus cynocephalus',
			'Cygnus atratus'
		)
	);
	
	foreach ($continent['Africa'] as $Value) {
		$__array = explode(' ', $Value);
		$array[0][] = $__array[0];
		$array[1][] = $__array[1];
	}
	foreach ($continent['Australia'] as $Value) {
		$__array = explode(' ', $Value);
		$array[0][] = $__array[0];
		$array[1][] = $__array[1];
	}
	
	$RANDOM = array();
	
	for ($i=0; $i<8; ++$i) {
		$rnd = mt_rand(0, 7 - count($RANDOM));
		foreach ($RANDOM as $v) if ($rnd >= $v) ++$rnd;
		$RANDOM[] = $rnd;
		sort($RANDOM);
		
	}
	
	$random[0] = $RANDOM;
	$random[1] = $RANDOM;
	shuffle($random[0]);
	shuffle($random[1]);
	
	
	foreach ($array[0] as $Key => $Value) {
		$result[] = $array[0][$random[0][$Key]];
	}
	
	foreach ($array[1] as $Key => $Value) {
		$result[$Key] .= ' '.$array[1][$random[1][$Key]];
	}
	
	foreach ($result as $Key => $Value) {
		if ($Key == 0) echo $Value;
		else echo '<br>'.$Value;
	} 
?>