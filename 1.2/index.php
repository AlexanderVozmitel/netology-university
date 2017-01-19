<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$x = 1;
	$y = 1;
	$number = intval($_GET['number']);

	while (true)
	{
		if ($x > $number)
		{
			echo 'задуманное число НЕ входит в числовой ряд';
			break;
		}
		if ($x === $number)
		{	
			echo 'задуманное число входит в числовой ряд';
			break;
		}else {
			$z = $x;
			$x += $y;
			$y = $z;
		}
	}

?>