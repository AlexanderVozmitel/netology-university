<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$x = intval($_GET['number']);
	$y = 10;

	while (true)
	{
		if ($y > $x)
		{
			echo 'задуманное число НЕ входит в числовой ряд';
			break;
		}
		if ($y === $x)
		{
			echo 'задуманное число входит в числовой ряд';
			break;
		}
		$z = $x;
		$x = $x + $y;
		$y = $z;
	}

?>