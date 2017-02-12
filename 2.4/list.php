<?php
	include_once 'config.php';
	include_once 'functions.php';
	
	if (empty($_SESSION['AUTH_LOGIN']) and empty($_SESSION['AUTH_GUEST_LOGIN']))
	{
		header('HTTP/1.1 403');
		exit('<center><h1>Вы не авторизованы.<h1></center>');
	}
	
	if (isset($_GET['del']))
	{
		unlink(TEST_DIR.$_GET['del'].'.json');
		Location(URL_ADDRESS.'list.php');
	}
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Список Тестов</title>
	<style>
		* { margin: 0; }
		body { background: #efeef1; }
		a {text-decoration: none;}
		.link { display: block;margin-bottom: 5px; }
		.link_del { float: right;color: rgba(255, 0, 0, 0.8); }
		.form { width: 350px;margin: 60px auto;padding: 20px;background:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff;box-shadow:0 1px 2px rgba(0,0,0,.1); }
		.title { font-size: 28px;text-align: center;padding-bottom: 20px;margin-bottom: 20px;border-bottom: 1px solid #dedede; }
		.item { margin: 0 0 20px; }
		.buttons { padding: 20px 0;border-top: 1px solid #dedede;width: 100%;text-align: center;margin-top: 20px; }
	</style>
</head>
<body>
	<div class="form">
		<div class="title">Список Тестов</div>
		<div class="item">
			<?php
				foreach (scandir(TEST_DIR) as $Key => $Value){
					if ($Value != '.' and $Value != '..')
					{
						$Value = substr($Value, 0, -5);
						echo  '<div class="link"><a href="test.php?number='.$Value.'"> Тест №'.$Value.'</a><a href="list.php?del='.$Value.'" class="link_del">Удалить Тест</a></div>'."\r\n";
					}
				}
			?>
		</div>
		<div class="buttons">
			<a href="index.php?logout=<?= $_SESSION['AUTH_USERNAME'] ?>"> Выход</a>
		</div>
	</div>
</body>
</html>