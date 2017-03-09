<?php
	session_start();
	
	include_once 'setting.php';
	include_once 'functions.php';
	
	$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
	mysqli_set_charset($CONNECT, "utf8");
	
	
	if (isset($_GET['users']))
	{
		if ($_GET['users'] == 'logout')
		{
			session_destroy();
			Location(URL_ADDRESS);
		}
	}

	if (!isset($_SESSION['AUTHENTICATION'])) include(ROOT.'login.php');
	else include(ROOT.'main.php');
	//MessageShow();
	//print_r($_SESSION);
	mysqli_close($CONNECT);
?>