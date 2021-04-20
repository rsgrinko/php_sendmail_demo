<?php
include 'func.php';
?>
<html>
<head>
<title>Страница отправки E-Mail</title>
</head>
<body>
<h1>Форма обратной связи</h1>
<p>Тестовое задание на вакансию PHP-программист<br>Все поля, кроме вложения, обязательны для заполнения</p><br>
<form enctype="multipart/form-data" action="sendmail.php" method="POST">
ФИО*:<br><?=check_valid($_GET['failname']);?><input type="text" name="name" value=""><br><br>
E-Mail*:<br><?=check_valid($_GET['failemail']);?><input type="text" name="email" value=""><br><br>
Телефон*:<br><?=check_valid($_GET['failnumber']);?><input type="text" name="number" value=""><br><br>
Сообщение*:<br><?=check_valid($_GET['failtext']);?><textarea name="msg" rows="10" cols="50">Это тестовое сообщение для проверки работоспособности системы. Написано, чтобы во время теста не писать текст лишний раз...</textarea><br><br>
<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br>
Вложение:<br><input type="file" name="uploadedFile" value=""><br><br>
<input type="submit" value="Отправить"><br>
</form>
</body>
