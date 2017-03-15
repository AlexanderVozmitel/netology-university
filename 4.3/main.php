<?php
	if(!defined('IN_CORE'))
	{
		die('This file cannot be accessed directly.');
	}
	
	if (isset($_POST['save']))
	{
		if ($_POST['save'] == 'Добавить' and !empty($_POST['description']))
		{
			$_POST['description'] = FormChars($_POST['description']);
			$sth = $db->prepare('INSERT INTO `task` (`id`, `user_id`, `assigned_user_id`, `description`, `is_done`, `date_added`) VALUES (NULL, :user_id, NULL, :description, 0, NOW());');
			$sth->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
			$sth->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
			$sth->execute();
			// mysqli_query($CONNECT, "INSERT INTO `task` (`id`, `user_id`, `assigned_user_id`, `description`, `is_done`, `date_added`) VALUES (NULL, '${_SESSION['USER_ID']}', NULL, '${_POST['description']}', '0', NOW())");
			Location(URL_ADDRESS);
		}
		else if ($_POST['save'] == 'Сохранить' and !empty($_POST['update_description']) and isset($_GET['id']))
		{
			$_POST['update_description'] = FormChars($_POST['update_description']);
			$sth = $db->prepare('UPDATE `task` SET `description` = :description WHERE user_id = :user_id AND id = :id or assigned_user_id = :user_id AND id = :id');
			$sth->bindValue(':description', $_POST['update_description'], PDO::PARAM_STR);
			$sth->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
			$sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
			$sth->execute();
			// mysqli_query($CONNECT, "UPDATE `task` SET `description` = '${_POST['update_description']}' WHERE user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}' or assigned_user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}'");
			Location(URL_ADDRESS);
		}
	}
	
	if (isset($_POST['assign']))
	{
		$assigned = explode("_", $_POST['assigned_user_id']);
		$sth = $db->prepare('UPDATE `task` SET `assigned_user_id` = :assigned_user_id WHERE `user_id` = :usert_id AND `id` = :id');
		$sth->bindValue(':assigned_user_id', $assigned[1], PDO::PARAM_INT);
		$sth->bindValue(':usert_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
		$sth->bindValue(':id', $assigned[3], PDO::PARAM_INT);
		$sth->execute();
		// mysqli_query($CONNECT, "UPDATE `task` SET `assigned_user_id` = '${assigned[1]}' WHERE `user_id` = '${_SESSION['USER_ID']}' AND `id` = '${assigned[3]}'");
		Location(URL_ADDRESS);
	}
	
	$users = array(''=>'Вы');
	$sth = $db->prepare('SELECT * FROM `user`');
	$sth->execute();
	while ($Row =  $sth->fetch(PDO::FETCH_ASSOC))
	{
		$users[$Row['id']] = $Row['login'];
	}
	/* $Result = mysqli_query($CONNECT, "SELECT * FROM `user`");
	while ($Row = mysqli_fetch_assoc($Result))
	{
		$users[$Row['id']] = $Row['login'];
	} */
	
	
	if (!isset($_POST['sort_by']) or array_search($_POST['sort_by'], array('date_added', 'is_done', 'description'))) $_POST['sort_by'] = 'date_added';
	$My = $db->prepare('SELECT task.id, task.description, task.is_done, task.date_added, task.assigned_user_id, user.login AS author FROM `task` JOIN user ON user.id = task.user_id WHERE user_id = :user_id ORDER BY :sort_by');
	$My->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
	$My->bindValue(':sort_by', $_POST['sort_by'], PDO::PARAM_STR);
	$My->execute();
	
	$Assigned = $db->prepare('SELECT task.id, task.description, task.is_done, task.date_added, task.assigned_user_id, user.login AS author FROM `task` JOIN user ON user.id = task.user_id WHERE task.assigned_user_id = :user_id ORDER BY :sort_by');
	$Assigned->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
	$Assigned->bindValue(':sort_by', $_POST['sort_by'], PDO::PARAM_STR);
	$Assigned->execute();
	
	// $Result_my = mysqli_query($CONNECT, "SELECT task.id, task.description, task.is_done, task.date_added, task.assigned_user_id, user.login AS 'author' FROM `task` JOIN user ON user.id = task.user_id WHERE user_id = '${_SESSION['USER_ID']}' ORDER BY ${_POST['sort_by']}");
	// $Result_assigned = mysqli_query($CONNECT, "SELECT task.id, task.description, task.is_done, task.date_added, task.assigned_user_id, user.login AS 'author' FROM `task` JOIN user ON user.id = task.user_id WHERE task.assigned_user_id = '${_SESSION['USER_ID']}' ORDER BY ${_POST['sort_by']}");
	
	if (isset($_GET['id']) and $_GET['action'] ==='delete')
	{
		$sth = $db->prepare('DELETE FROM `task` WHERE user_id = :user_id AND `id` = :id or assigned_user_id = :user_id AND id = :id');
		$sth->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
		$sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->execute();
		// mysqli_query($CONNECT, "DELETE FROM `task` WHERE user_id = '${_SESSION['USER_ID']}' AND `id` = '${_GET['id']}' or assigned_user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}'");
		Location(URL_ADDRESS);
	}
	else if (isset($_GET['id']) and $_GET['action'] === 'done')
	{
		$sth = $db->prepare('UPDATE `task` SET `is_done` = 1 WHERE user_id = :user_id AND `id` = :id or assigned_user_id = :user_id AND id = :id');
		$sth->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
		$sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->execute();
		// mysqli_query($CONNECT, "UPDATE `task` SET `is_done` = 1 WHERE user_id = '${_SESSION['USER_ID']}' AND `id` = '${_GET['id']}' or assigned_user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}'");
		Location(URL_ADDRESS);
	}
	else if (isset($_GET['id']) and $_GET['action'] === 'edit')
	{
		$sth = $db->prepare('SELECT description FROM `task` WHERE user_id = :user_id AND id = :id or assigned_user_id = :user_id AND id = :id');
		$sth->bindValue(':user_id', $_SESSION['USER_ID'], PDO::PARAM_STR);
		$sth->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
		$sth->execute();
		$Row =  $sth->fetch(PDO::FETCH_ASSOC);
		//$Row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT description FROM `task` WHERE user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}' or assigned_user_id = '${_SESSION['USER_ID']}' AND id = '${_GET['id']}'"));
	}
	
?>
<html>
<head>
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
		}

		form {
			margin: 0;
		}
	</style>

</head>
<body>
	<h1>Здравствуйте, <?= $_SESSION['USER_LOGIN'] ?>!</h1>
	<h2>Вот ваш список дел:</h2>
	<div style="float: left; margin-bottom: 20px;">
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
				<th>Ответственный</th>
				<th>Автор</th>
				<th>Закрепить задачу за пользователем</th>
			</tr>
			<?php $i = 0; ?>
			<?php // while ($Row = mysqli_fetch_assoc($Result_my)) : ?>
			<?php while ($Row = $My->fetch(PDO::FETCH_ASSOC)) : ?>
			<tr> 
				<td><?= $Row['description'] ?></td> 
				<td><?= $Row['date_added'] ?></td>
			<?php if ($Row['is_done'] == 1): ?>
				<td><span style="color: green;">Выполнено</span></td>
			<?php else: ?>
				<td><span style="color: orange;">В процессе</span></td>
			<?php endif; ?>
				<td>
					<a href="?id=<?= $Row['id'] ?>&amp;action=edit">Изменить</a>
				<?php if (empty($Row['assigned_user_id'])): ?>
					<a href="?id=<?= $Row['id'] ?>&amp;action=done">Выполнить</a>
				<?php endif; ?>
					<a href="?id=<?= $Row['id'] ?>&amp;action=delete">Удалить</a>
				</td>
				<td><?= $users[$Row['assigned_user_id']] ?></td>
				<td><?= $Row['author'] ?></td>
				<td> 
					<form method="POST">
					<select name="assigned_user_id">
				<?php foreach ($users as $Key => $Value): ?>
					<?php if ($Key != $_SESSION['USER_ID'] AND $Key != null): ?>
					<option value="user_<?= $Key ?>_task_<?= $Row['id'] ?>"><?= $Value ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
					</select> 
					<input type="submit" name="assign" value="Переложить ответственность">
					</form> 
				</td>
			</tr>
			<?php $i++; ?> 
			<?php endwhile; ?>
			<?php if ($i <= 0): ?> 
				<tr> <td colspan="7">Нет данных.</td> </tr>
			<?php endif; ?>
		</tbody>
	</table>
	<p><strong>Также, посмотрите, что от Вас требуют другие люди:</strong></p>
	<table>
        <tbody>
			<tr>
				<th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th>&nbsp;</th>
				<th>Ответственный</th>
				<th>Автор</th>
            </tr>
			<?php $i = 0; ?>
			<?php // while ($Row = mysqli_fetch_assoc($Result_assigned)): ?>
			<?php while ($Row = $Assigned->fetch(PDO::FETCH_ASSOC)): ?>
			<tr> 
				<td><?= $Row['description'] ?></td> 
				<td><?= $Row['date_added'] ?></td>
			<?php if ($Row['is_done'] == 1): ?>
				<td><span style="color: green;">Выполнено</span></td>
			<?php else: ?>
				<td><span style="color: orange;">В процессе</span></td>
			<?php endif; ?>
				<td>
					<a href="?id=<?= $Row['id'] ?>&amp;action=edit">Изменить</a>
					<a href="?id=<?= $Row['id'] ?>&amp;action=done">Выполнить</a>
					<a href="?id=<?= $Row['id'] ?>&amp;action=delete">Удалить</a>
				</td>
				<td><?= $users[$Row['assigned_user_id']] ?></td>
				<td><?= $Row['author'] ?></td>
			</tr>
			<?php $i++; ?> 
			<?php endwhile; ?>
			<?php if ($i <= 0): ?> 
				<tr> <td colspan="7">Нет данных.</td> </tr>
			<?php endif; ?>
		</tbody>
	</table>
	<p><a href="<?= URL_ADDRESS ?>?users=logout">Выход</a></p>
</body>
</html>