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
	
	$array = array();
	
	foreach ($continent['Africa'] as $Value) {
		$temp = explode(' ', $Value);
		$array[0][] = $temp[0];
		$array[1][] = $temp[1];
		unset($temp);
	}
	foreach ($continent['Australia'] as $Value) {
		$temp = explode(' ', $Value);
		$array[0][] = $temp[0];
		$array[1][] = $temp[1];
		unset($temp);
	}
	
	$random = array(
		0 => array(0,1,2,3,4,5,6,7),
		1 => array(7,6,5,4,3,2,1,0)
	);
	
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