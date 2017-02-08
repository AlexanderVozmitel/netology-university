<?php
	include_once 'config.php';
	include_once 'functions.php';
	
	if (isset($_GET['number']))
	{
		if (empty(file_exists($config['dirname'].$_GET['number'].'.json'))) 
		{
			header("HTTP/1.1 404 Not Found");
			exit('Тест не найден.');
		}
	}
	else
	{
		header("HTTP/1.1 404 Not Found");
		exit('Тест не найден.');
	}
	
	$test = json_decode(file_get_contents($config['dirname'].$_GET['number'].'.json'), TRUE);
	
	$answer = array(
		0 => 0,
		1 => 0
	);
	
	if (isset($_POST['submit']))
	{
		if (empty($_POST['name'])) $errors = 'Имя не указано.';
		else {
			foreach ($_POST['test'] as $Key => $Value){
				$_POST['test'][$Key] = mb_strtolower(FormChars($Value));
				if ($_POST['test'][$Key] == $test[$Key]['answer']) 
				{
					$answer[1]++;
				}
				else 
				{
					$answer[0]++;
				}
			}
			$Count = $answer[1] + $answer[0];
			$result = array(
				'right' => $answer[1].' ('.@($answer[1] * 100 /  $Count).'%) ',
				'error' => $answer[0].' ('.@($answer[0] * 100 /  $Count).'%)'
			);
			GenCertificate($_POST['name'], $result);
			//echo 'Правильных ответов: '.$answer[1].' ('.@($answer[1] * 100 /  $Count).'%) '.'<br>'.
			//'Неправильных ответов: '.$answer[0].' ('.@($answer[0] * 100 /  $Count).'%)';
			exit();
		
		}
	}
	
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Тест №<?= $_GET['number'] ?></title>
	<style>
		* { margin: 0; }
		body { background: #efeef1; }
		.form { width: 350px;margin: 60px auto;padding: 20px;background:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff;box-shadow:0 1px 2px rgba(0,0,0,.1); }
		.title { font-size: 28px;text-align: center;padding-bottom: 20px;margin-bottom: 20px;border-bottom: 1px solid #dedede; }
		.item { margin: 0 0 10px; }
		.buttons { padding: 20px 0;border-top: 1px solid #dedede;width: 100%;text-align: center; }
		label { display: block;margin-bottom: 5px;font-weight: 700;color: #575260; }
		input[type="text"] {width: 100%;}
		input.text { margin: 0 0 20px;padding: 0 7px;height: 30px;font: inherit;letter-spacing: inherit;color: #706a7c;vertical-align: top;border: 1px solid #dad8de;-webkit-background-clip: padding-box;-moz-background-clip: padding;box-sizing: border-box;background: #fff;}
		.errors { background: #ffe6e6;color: #c86e6e;padding: 10px;margin: 0 0 20px;border: 1px solid #f5c8c8; }
	</style>
</head>
<body>
	<div class="form">
		<form method="POST">
			<div class="title">Тест №<?= $_GET['number'] ?></div>
			<?php 
				if (isset($errors)) echo '<div class="errors">'.$errors .'</div>';
			?>
			<div class="item">
				<label for="name">Имя</label>
				<input class="text" type="text" id="name" name="name" >
			</div>
			<?php foreach ($test as $Value): ?>
			<div class="item">
				<label for="<?= $Value['id'] ?>"><?= $Value['question'] ?></label>
				<input class="text" type="text" id="<?= $Value['id'] ?>" name="test[<?= $Value['id'] ?>]" >
			</div>
			<?php endforeach; ?>
			<div class="buttons">
				<input type="submit" name="submit" value="Тест выполнен">
			</div>
		</form>
	</div>
</body>
</html>