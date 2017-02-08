<?php
	include_once 'config.php';
?>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Список Тестов</title>
	<style>
		* { margin: 0; }
		body { background: #efeef1; }
		a { text-decoration: none;display: block; }
		.form { width: 350px;margin: 60px auto;padding: 20px;background:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff;box-shadow:0 1px 2px rgba(0,0,0,.1); }
		.title { font-size: 28px;text-align: center;padding-bottom: 20px;margin-bottom: 20px;border-bottom: 1px solid #dedede; }
		.item { margin: 0 0 20px; }
	</style>
</head>
<body>
	<div class="form">
		<div class="title">Список Тестов</div>
		<div class="list">
			<?php
				foreach (scandir($config['dirname']) as $Key => $Value){
					if ($Value != '.' and $Value != '..')
					{
						$Value = substr($Value, 0, -5);
						echo  '<a href="test.php?number='.$Value.'"> Тест №'.$Value.'</a>'."\r\n";
					}
				}
			?>
		</div>
	</div>
</body>
</html>