<?php

  /**
   * fichier contenant les configurations pour l'envoi de mail avec PHPMailer (source PHPMailer)
   */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('./model/PHPMailer/src/Exception.php');

require_once('./model/PHPMailer/src/PHPMailer.php');

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
