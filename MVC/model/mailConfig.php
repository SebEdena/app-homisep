<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require './model/PHPMailer/src/Exception.php';

/* The main PHPMailer class. */
require './model/PHPMailer/src/PHPMailer.php';

echo class_exists('PHPMailer');

/* SMTP class, needed if you want to use SMTP. */
require './model/PHPMailer/src/SMTP.php';

$mailSender = new PHPMailer(TRUE);

?>
