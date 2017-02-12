<?php
	include_once 'config.php';
	include_once 'functions.php';
	
	if (isset($_GET['logout']))
	{
		session_destroy();
		Location(URL_ADDRESS);
	}
	
	if (isset($_SESSION['AUTH_LOGIN']) or isset($_SESSION['AUTH_GUEST_LOGIN'])) Location(URL_ADDRESS.'list.php');
	
	if (isset($_POST['u_submit']))
	{
		$_POST['username'] = FormChars($_POST['username']);
		$_POST['password'] = FormChars($_POST['password']);
		if (file_exists(USER_DIR.$_POST['username'].'.json'))
		{
			$Row = json_decode(file_get_contents(USER_DIR.$_POST['username'].'.json'), TRUE);
			if ($Row['password'] != $_POST['password']) MessageSend('Неправильный логин или пароль.');
			unset($Row['password']);
			$_SESSION['AUTH_LOGIN'] = true;
			foreach ($Row as $Key => $Value) $_SESSION['AUTH_'.strtoupper($Key)] = $Value;
			Location(URL_ADDRESS.'list.php');
		}
		else MessageSend('Неправильный логин или пароль.');
	}
	else if (isset($_POST['g_submit']))
	{
		$_POST['guestname'] = FormChars($_POST['guestname']);
		$_SESSION['AUTH_GUEST_LOGIN'] = true;
		$_SESSION['AUTH_USERNAME'] = $_POST['guestname'];
		Location(URL_ADDRESS.'list.php');
	}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
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
			<div class="title">Авторизация</div>
			<?php MessageShow(); ?>
			<?php if (@$_GET['login'] == 'user') : ?>
			<div class="item">
				<label for="username">Имя пользователя</label>
				<input class="text" type="text" id="username" name="username" >
			</div>
			<div class="item">
				<label for="password">Пароль</label>
				<input class="text" type="password" id="password" name="password" >
			</div>
			<div class="buttons">
				<input type="submit" name="u_submit" value="Войти">
			</div>
			<?php elseif (@$_GET['login'] == 'guest') : ?>
			<div class="item">
				<label for="guestname">Имя пользователя</label>
				<input class="text" type="text" id="guestname" name="guestname" >
			</div>
			<div class="buttons">
				<input type="submit" name="g_submit" value="Войти">
			</div>
			<?php else : ?>
			<div class="item">
				<a class="" href="?login=user">Войти как Пользователь</a>
				<a class="" href="?login=guest">Войти как Гость</a>
			</div>
			<?php endif; ?>
		</form>
	</div>
</body>
</html>