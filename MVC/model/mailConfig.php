<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require_once('./model/PHPMailer/src/Exception.php');

/* The main PHPMailer class. */
require_once('./model/PHPMailer/src/PHPMailer.php');

/* SMTP class, needed if you want to use SMTP. */
require_once('./model/PHPMailer/src/SMTP.php');

$mail = new PHPMailer(TRUE);
$mail->CharSet = 'UTF-8';
$mail->ContentType = 'text/html';
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
//$mail->SMTPDebug = 2;

$mail->Host = 'smtp.free.fr';
$mail->Port = 587;
$mail->Username = "homisep@free.fr";
$mail->Password = "homisep1";
$mail->IsHTML(true);
?>
