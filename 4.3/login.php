<?php
	if(!defined('IN_CORE'))
	{
		die('This file cannot be accessed directly.');
	}
	if (isset($_GET['users']))
	{
		if ($_GET['users'] == 'LoginIn' and isset($_POST['LoginIn']))
		{
			// $_POST['username'] = FormChars($_POST['username'], true);
			// $_POST['password'] = FormChars($_POST['password']);
			if (!$_POST['username'] or !$_POST['password']) MessageSend('Укажите имя пользователя и пароль.');
			$sth = $db->prepare('SELECT * FROM `user` WHERE `login` = :username');
			$sth->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
			$sth->execute();
			$Row = $sth->fetch(PDO::FETCH_ASSOC);
			//$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `password`, `id` FROM `user` WHERE `login` = '${_POST['username']}'"));
			if ($Row['password'] != md5($_POST['password'])) MessageSend('Имя пользователя или пароль указаны неверно.');
			$_SESSION['AUTHENTICATION'] = true;
			unset($Row['password']);
			foreach ($Row as $Key => $Value) $_SESSION['USER_'.strtoupper($Key)] = $Value;
			/*	
			$_SESSION['AUTHENTICATION'] = true;
			$_SESSION['LOGIN_ID'] = $Row['id'];
			$_SESSION['LOGIN_USERNAME'] = $_POST['username'];
			*/
			Location(URL_ADDRESS);
		}
		else if ($_GET['users'] == 'SignUp' and isset($_POST['SignUp']))
		{
			// $_POST['username'] = FormChars($_POST['username'], true);
			// $_POST['password'] = FormChars($_POST['password']);
			if (!$_POST['username'] or !$_POST['password']) MessageSend('Укажите имя пользователя и пароль.');
			$sth = $db->prepare('SELECT `id` FROM `user` WHERE `login` = :username');
			$sth->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
			$sth->execute();
			if ($sth->fetch(PDO::FETCH_ASSOC)['id']) MessageSend('Такой пользователь уже зарегистрирован.');
			// if (mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `user` WHERE `login` = '${_POST['username']}'"))) MessageSend('Такой пользователь уже зарегистрирован.');
			$_POST['password'] = md5($_POST['password']);
			$sth = $db->prepare('INSERT INTO `user` (`id`, `login`, `password`) VALUES (NULL, :username, :password)');
			$sth->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
			$sth->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
			if ($sth->execute())
			// if (mysqli_query($CONNECT, "INSERT INTO `user` (`id`, `login`, `password`) VALUES (NULL, '${_POST['username']}', '${_POST['password']}')"))
			{
				$sth = $db->prepare('SELECT `login`, `id` FROM `user` WHERE `login` = :username');
				$sth->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
				$sth->execute();
				$Row = $sth->fetch(PDO::FETCH_ASSOC);
				$_SESSION['AUTHENTICATION'] = true;
				foreach ($Row as $Key => $Value) $_SESSION['USER_'.strtoupper($Key)] = $Value;
				/*
				$_SESSION['AUTHENTICATION'] = true;
				$_SESSION['LOGIN_ID'] = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `user` WHERE `login` = '${_POST['username']}'"))['id'];
				$_SESSION['LOGIN_USERNAME'] = $_POST['username'];
				*/
				Location(URL_ADDRESS);
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Аутентификация</title>
	<style>
		* { margin: 0; }
		a { text-decoration:none;display: block;margin-bottom: 10px; }
		body { background: #efeef1; }
		.form { width: 350px;margin: 60px auto;padding: 20px;background:#fff;border-bottom:1px solid #fff;border-top:1px solid #fff;box-shadow:0 1px 2px rgba(0,0,0,.1); }
		.title { font-size: 28px;text-align: center;padding-bottom: 20px;margin-bottom: 20px;border-bottom: 1px solid #dedede; }
		.item { margin: 0 0 10px; }
		.buttons { padding: 20px 0;border-top: 1px solid #dedede;width: 100%;text-align: center; }
		label { display: block;margin-bottom: 5px;font-weight: 700;color: #575260; }
		input[type="text"], input[type="password"] {width: 100%;}
		input.text { margin: 0 0 20px;padding: 0 7px;height: 30px;font: inherit;letter-spacing: inherit;color: #706a7c;vertical-align: top;border: 1px solid #dad8de;-webkit-background-clip: padding-box;-moz-background-clip: padding;box-sizing: border-box;background: #fff;}
		.MessageBlockInfo { background: #ffe6e6;color: #c86e6e;padding: 10px;margin: 0 0 20px;border: 1px solid #f5c8c8; }
	</style>
</head>
<body>
	<div class="form">
		<form method="POST">
			<?php if (@$_GET['users'] == 'LoginIn') : ?>
			<div class="title">Авторизация</div>
			<?php MessageShow(); ?>
			<div class="item">
				<label for="username">Имя пользователя</label>
				<input class="text" type="text" id="username" name="username" >
			</div>
			<div class="item">
				<label for="password">Пароль</label>
				<input class="text" type="password" id="password" name="password" >
			</div>
			<div class="buttons">
				<input type="submit" name="LoginIn" value="Войти">
			</div>
			<?php elseif (@$_GET['users'] == 'SignUp') : ?>
			<div class="title">Регистрация</div>
			<?php MessageShow(); ?>
			<div class="item">
				<label for="username">Имя пользователя</label>
				<input class="text" type="text" id="username" name="username" >
			</div>
			<div class="item">
				<label for="password">Пароль</label>
				<input class="text" type="password" id="password" name="password" >
			</div>
			<div class="buttons">
				<input type="submit" name="SignUp" value="Зарегистрироватся">
			</div>
			<?php else : ?>
			<div class="title">Аутентификация</div>
			<div class="item">
				<a class="" href="?users=LoginIn">Войти</a>
				<a class="" href="?users=SignUp">Регистрация</a>
			</div>
			<?php endif; ?>
		</form>
	</div>
</body>
</html>