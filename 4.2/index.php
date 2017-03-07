<?php
	define ('HOST', '**.**.**');
	define ('USER', '**');
	define ('PASS', '**');
	define('DB', '**');
	
	$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
	mysqli_set_charset($CONNECT, "utf8");

	if (isset($_POST['save']))
	{
		if ($_POST['save'] == 'Добавить' and !empty($_POST['description']))
		{
			mysqli_query($CONNECT, "INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES (NULL, '${_POST['description']}', 0, NOW())");
			header('Location: /u/vozmitel/4.2/');
		}
		else if ($_POST['save'] == 'Сохранить' and !empty($_POST['update_description']) and isset($_GET['id']))
		{
			mysqli_query($CONNECT, "UPDATE `tasks` SET `description` = '${_POST['update_description']}' WHERE `id` = '${_GET['id']}'");
			header('Location: /u/vozmitel/4.2/');
		}
	}

	if (!isset($_POST['sort_by'])) $_POST['sort_by'] = 'date_added';
	$Result = mysqli_query($CONNECT, "SELECT * FROM `tasks` ORDER BY ${_POST['sort_by']}");
	
	$text = '';
	$i = 0;
	
	while ($Row = mysqli_fetch_assoc($Result)) {
		$text .= '<tr> <td>'.$Row['description'].'</td> <td>'.$Row['date_added'].'</td>';
		if ($Row['is_done'] == 1) 
		{
			$text .= '<td><span style="color: green;">Выполнено</span></td>';
		}
		else
		{
			$text .= '<td><span style="color: orange;">В процессе</span></td>';
		}
		$text .= '<td><a href="?id='.$Row['id'].'&amp;action=edit">Изменить</a> <a href="?id='.$Row['id'].'&amp;action=done">Выполнить</a> <a href="?id='.$Row['id'].'&amp;action=delete">Удалить</a></td></tr>';
		$i++;
	}
	if ($i <= 0)
	{
		$text = '<tr> <td colspan="4">Нет данных.</td> </tr>';
	}

	if (isset($_GET['id']) and $_GET['action'] ==='delete')
	{
		mysqli_query($CONNECT, "DELETE FROM `tasks` WHERE `id` = '${_GET['id']}'");
		header('Location: /u/vozmitel/4.2/');
	}
	else if (isset($_GET['id']) and $_GET['action'] === 'done')
	{
		mysqli_query($CONNECT, "UPDATE `tasks` SET `is_done` = 1 WHERE `id` = '${_GET['id']}'");
		header('Location: /u/vozmitel/4.2/');
	}
	else if (isset($_GET['id']) and $_GET['action'] === 'edit')
	{
		$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `description` FROM `tasks` WHERE `id` = '${_GET['id']}'"));
	}

	mysqli_close($CONNECT);
?>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		table { 
			border-spacing: 0;
			border-collapse: collapse;
		}

		table td, table th {
			border: 1px solid #ccc;
			padding: 5px;
		}

		table th {
			background: #eee;
			min-width: 78px;
		}
	</style>
</head>
<body>
	<br>
	<div style="float: left">
		<form method="POST">
		<?php if (!empty($_GET['id']) and !empty($Row['description'])) : ?>
			<input type="text" name="update_description" placeholder="Описание задачи" value="<?= $Row['description'] ?>">
			<input type="submit" name="save" value="Сохранить">
		<?php else : ?>
			<input type="text" name="description" placeholder="Описание задачи">
			<input type="submit" name="save" value="Добавить">
		<?php endif; ?>
		</form>
	</div>
	<div style="float: left; margin-left: 20px;">
		<form method="POST">
			<label for="sort">Сортировать по:</label>
			<select name="sort_by">
				<option value="date_added">Дате добавления</option>
				<option value="is_done">Статусу</option>
				<option value="description">Описанию</option>
			</select>
			<input type="submit" name="sort" value="Отсортировать">
		</form>
	</div>
	<div style="clear: both"></div>
	<table>
		<tbody>
			<tr>
				<th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th>&nbsp;</th>
			</tr>
			<?= $text ?>
		</tbody>
	</table>
</body>
</html>