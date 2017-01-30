<?php
$phone_book = json_decode(file_get_contents('phone_book.json'), true);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>2.1</title>
</head>
<body>
    <table>
    <thead>
        <tr>
            <th>Имя</th>
            <th>Номер</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($phone_book as $Value): ?>
        <tr>
            <td><?= $Value['name'] ?></td>
            <td><?= $Value['number'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
</body>
</html>