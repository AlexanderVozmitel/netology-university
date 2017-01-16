<?php
$name = 'Александер';
$age = 16;
$email = 'avozmitel@mail.ru';
$city = 'Краснодар';
$about_myself = 'Занимаюсь написанием сайтов.';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title> <?=$name?> – <?=$about_myself?></title>
        <meta charset="utf-8">
        <style>
            body {
                font-family: sans-serif;  
            }
            dl {
                display: table-row;
            }
            dt, dd {
                display: table-cell;
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h1>Страница пользователя <?=$name?></h1>
        <dl>
            <dt>Имя</dt>
            <dd><?=$name?></dd>
        </dl>
        <dl>
            <dt>Возраст</dt>
            <dd><?=$age?></dd>
        </dl>
        <dl>
            <dt>Адрес электронной почты</dt>
            <dd><a href="mailto:<?=$email?>"><?=$email?></a></dd>
        </dl>
        <dl>
            <dt>Город</dt>
            <dd><?=$city?></dd>
        </dl>
        <dl>
            <dt>О себе</dt>
            <dd><?=$about_myself?></dd>
        </dl>
    </body>
</html>
