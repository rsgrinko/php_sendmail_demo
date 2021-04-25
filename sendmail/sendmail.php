<?php
require_once 'func.php';
$subject = 'Mail from '.$_SERVER['SERVER_NAME'];
$mailto = 'rsgrinko@gmail.com';
$erract = '?act=error&'; 
$err = false;
$dest_path = '';

if(empty($_POST['name'])) { $erract = $erract.'failname=1&'; $err = true; }
if(empty($_POST['email'])) { $erract = $erract.'failemail=1&'; $err = true; }
if(empty($_POST['number'])) { $erract = $erract.'failnumber=1&'; $err = true; }
if(empty($_POST['msg'])) { $erract = $erract.'failtext=1&'; $err = true; }

if($err==true) { header('Location: index.php'.$erract); } //Если есть ошибки - редиректим на форму

$msg = htmlspecialchars($_POST['msg']);
$name = htmlspecialchars($_POST['name']);
$number = htmlspecialchars($_POST['number']);
$email = htmlspecialchars($_POST['email']);

// Формируем текст письма
$text = 'Отправлено письмо с сайта '.$_SERVER['SERVER_NAME'].'. ФИО: '.$name.', телефон: '.$number.', Email: '.$email.', Сообщение: "'.$msg.'". Используйте для ответа адрес почты, указанный в теле сообщения.';

if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    echo 'Попытка отправки письма с вложением<br>';
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileNameCmps = explode('.', $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    if($fileExtension=='php' or $fileExtension=='html' or $fileExtension=='htm') exit('Неудачная попытка загрузить скрипт на сервер. Взлом не удался...');

    $newFileName = md5(time().$fileName).'.'.$fileExtension;
    $dest_path = './tmp/'.$newFileName;
    move_uploaded_file($fileTmpPath, $dest_path);
}


if($dest_path!=='') { //если есть файл - шлем письмо с вложением, иначе шлем просто письмо
    if(send_mail($mailto, $subject, $text, $dest_path, $fileName.'.'.$fileExtension)) {
        echo 'Письмо с вложением отправлено';
        unlink($dest_path);
    } else {
        echo 'Письмо с вложением НЕ отправлено';
    }
} else {
    if(mail($mailto, $subject, $text)) {
        echo 'Письмо без вложения отправлено';
    } else {
        echo 'Письмо без вложения НЕ отправлено';
    }
} 
?>