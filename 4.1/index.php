<?php
	define ('HOST', 'localhost');
	define ('USER', '**');
	define ('PASS', '**');
	define('DB', 'global');

	$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
	mysqli_set_charset($CONNECT, "utf8");
	
	if (empty($_POST['submit']) and (!empty($_POST['isbn']) or !empty($_POST['name']) or !empty($_POST['author'])) )
	{
		$Result = mysqli_query($CONNECT, "SELECT * FROM `books` WHERE `isbn` LIKE '%${_POST['isbn']}%' AND `name` LIKE '%${_POST['name']}%' AND `author` LIKE '%${_POST['author']}%'");
	}
	else
	{
		$Result = mysqli_query($CONNECT, "SELECT * FROM `books`");
	}
	
	$text = '';
	$i = 0;
	while ($Row = mysqli_fetch_assoc($Result)) {
		$text .= "<tr> <td>${Row['name']}</td> <td>${Row['author']}</td> <td>${Row['year']}</td> <td>${Row['genre']}</td> <td>${Row['isbn']}</td> </tr>";
		$i++;
	}
	if ($i <= 0)
	{
		$text = '<tr> <td colspan="5">Совпадений не найдено.</td> </tr>';
	}
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
    }
</style>
</head>
<body>
<br>
<form method="POST">
    <input type="text" name="isbn" placeholder="ISBN" value="">
    <input type="text" name="name" placeholder="Название книги" value="">
    <input type="text" name="author" placeholder="Автор книги" value="">
    <input type="submit" value="Поиск">
</form>
<br>
<table>
	<tbody>
		<tr>
			<th>Название</th>
			<th>Автор</th>
			<th>Год выпуска</th>
			<th>Жанр</th>
			<th>ISBN</th>
		</tr>
		<?= $text ?>
	</tbody>
</table>
</body>
</html>