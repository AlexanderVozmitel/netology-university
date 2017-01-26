<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$continent = array(
		'Africa' => array(
			'Mammuthus columbi',
			'Scorpiones',
			'Gazella dorcas',
			'Colobus',
			'Felis margarita',
			'Trioceros jacksonii',
			'Theropithecus gelada'
		),
		'Australia' => array(
			'Dromaius novaehollandiae',
			'Trichosurus',
			'Sarcophilus laniarius',
			'Thylacinus cynocephalus',
			'Tachyglossidae',
			'Cygnus atratus',
			'Vombatidae'
		)
	);
	
	$array = array();
	$random = array();
	$quantity = 0;
	
	foreach ($continent['Africa'] as $Value) {
		if (str_word_count($Value) == 2) {
			$temp = explode(' ', $Value);
			$array[0][] = $temp[0];
			$array[1][] = $temp[1];
			unset($temp);
			$quantity++;
		}
	}
	foreach ($continent['Australia'] as $Value) {
		if (str_word_count($Value) === 2) {
			$temp = explode(' ', $Value);
			$array[0][] = $temp[0];
			$array[1][] = $temp[1];
			unset($temp);
			$quantity++;
		}
	}
	
	shuffle($array[0]);
	shuffle($array[1]);
	
	foreach ($array[0] as $Key => $Value) {
		if ($Key == 0) echo $Value.' '.$array[1][$Key];
		else echo '<br><br>'.$Value.' '.$array[1][$Key];
	}
	
?>