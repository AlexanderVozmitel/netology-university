<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$x = 1;
	$y = 1;
	$z = intval($_GET['number']);

	while (true)
	{
		echo $y." - ".$x."<br>";
		if ($x > $z)
		{
			echo 'задуманное число НЕ входит в числовой ряд';
			break;
		}
		if ($x === $z)
		{	
			echo $y." ".$x;
			echo 'задуманное число входит в числовой ряд';
			break;
		}else {
			$z = $x;
			$x += $y;
			$y = $z;
		}
	}

?>