<?php
function check_valid($code) {
    return ($code ? '<small><i><font color="red">* Поле не заполненно</font></i></small><br>' : '');
}

function send_mail($to, $thm, $html, $path, $filename) {
    $fp = fopen($path,'r');
    if(!$fp) exit('Внутренняя ошибка. Чтения файла невозможно.');
    $file = fread($fp, filesize($path));
    fclose($fp);

    $boundary = "--".md5(uniqid(time()));
    $headers.= "MIME-Version: 1.0\n"; 
    $headers.="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 
    $multipart.= "--$boundary\n"; 
    $kod = 'UTF-8';
    $multipart.= "Content-Type: text/html; charset=$kod\n"; 
    $multipart.= "Content-Transfer-Encoding: Quot-Printed\n\n"; 
    $multipart.= "$html\n\n"; 
    $message_part = "--$boundary\n"; 
    $message_part.= "Content-Type: application/octet-stream\n"; 
    $message_part.= "Content-Transfer-Encoding: base64\n"; 
    $message_part.= "Content-Disposition: attachment; filename = \"".$filename."\"\n\n"; 
    $message_part.= chunk_split(base64_encode($file))."\n"; 
    $multipart.= $message_part."--$boundary--\n"; 

    if(!mail($to, $thm, $multipart, $headers)) {
        return false;
    } else {
        return true;
    }
}
?>