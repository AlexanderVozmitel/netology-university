<?php
	include_once 'config.php';
	include_once 'functions.php';
	if (empty($_SESSION['AUTH_LOGIN']))
	{
		header('HTTP/1.1 403');
		if (isset($_SESSION['AUTH_GUEST_LOGIN'])) exit('<center><h1>Требуется авторизоваться как пользователь.<h1></center>');
		else exit('<center><h1>Вы не авторизованы.<h1></center>');
	}
	
	if (isset($_POST['submit']))
	{
		if (empty($_FILES['test_files']['tmp_name'])) exit('Файл не загружен.');
		if ($_FILES['test_files']['error'] == 0) 
		{
			$Count = sizeof(glob(TEST_DIR.'*.json')) + 1;
			if (!move_uploaded_file($_FILES['test_files']['tmp_name'], TEST_DIR.$Count.'.json')) exit('Произошло ошибка загрузки файла.');
			header('Location: list.php');
		}
	}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style>
		* { margin: 0; }
		body { background: #efeef1; }
		.form { width: 350px;margin: 60px auto;padding: 20px;background:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff;box-shadow:0 1px 2px rgba(0,0,0,.1); }
		.item { margin: 0 0 20px; }
		.buttons { padding: 20px 0;border-top: 1px solid #dedede;width: 100%;text-align: center; }
	</style>
</head>
<body>
	<div class="form">
		<form method="POST" enctype="multipart/form-data">
			<div class="item">
				<input type="file" name="test_files" >
			</div>
			<div class="buttons">
				<input type="submit" name="submit" value="Загрузить">
			</div>
		</form>
		<form method="POST" enctype="multipart/form-data">
			<div class="item">
				<input type="text" name="test_files" >
			</div>
			<div class="buttons">
				<input type="submit" name="delete" value="Удалить Тест">
			</div>
		</form>
	</div>
</body>
</html>